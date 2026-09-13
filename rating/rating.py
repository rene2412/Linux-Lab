from flask import Flask, request, jsonify
from flask_cors import CORS
from datetime import datetime, timedelta

import mysql.connector
from mysql.connector import Error

app = Flask(__name__)
CORS(app)
MAX_REVIEW_LENGTH = 1000


def format_db_timestamp(value):
    if value is None:
        return None
    if isinstance(value, datetime):
        return value.strftime('%d-%m-%Y')
    return datetime.strptime(str(value), '%Y-%m-%d %H:%M:%S').strftime('%d-%m-%Y')


def get_current_date():
    return datetime.now().date()

@app.route('/api/rating', methods=['POST'])
def submit_rating():
    data = request.get_json() or {}
    username = data.get('username')
    user_id = data.get('user_id')
    rating = data.get('rating')
    message = data.get('message')
    if isinstance(message, str):
        message = message.strip()

    if message is not None and len(message) > MAX_REVIEW_LENGTH:
        return jsonify({
            'status': 'error',
            'message': 'Review must be 1000 characters or less.'
        }), 400

    print(f"Rating: {rating}, Message: {message}, User: {username}, User ID: {user_id}")

    connection = None
    cursor = None
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='Linux_Lab',
            user='labuser',
            password='your_password_here'
        )
        if connection.is_connected():
            cursor = connection.cursor()
            query = "SELECT * FROM ratings WHERE user_id = %s"
            cursor.execute(query, (user_id,))
            existing_rating = cursor.fetchone()
            if existing_rating:
                return jsonify({
                    'status': 'warning_existing_rating',
                    'message': 'Warning: You have already submitted a rating. Do you want to resubmit another rating?'
                }), 400

            query = "INSERT INTO ratings (user_id, stars, review) VALUES (%s, %s, %s)"
            values = (user_id, rating, message)
            cursor.execute(query, values)
            connection.commit()
            return jsonify({'status': 'success', 'message': 'Rating received!'})

        return jsonify({'status': 'error', 'message': 'Could not connect to database.'}), 500
    except Error as e:
        print(f"Error while connecting to MySQL: {e}")
        return jsonify({'status': 'error', 'message': 'Failed to submit rating.'})
    finally:
        if cursor is not None:
            cursor.close()
        if connection is not None and connection.is_connected():
            connection.close()


@app.route('/api/rating/resubmit', methods=['POST'])
def resubmit_rating():
    data = request.get_json() or {}
    user_id = data.get('user_id')
    rating = data.get('rating')
    message = data.get('message')

    if user_id is None or rating is None or message is None:
        return jsonify({'status': 'error', 'message': 'user_id, rating and message are required.'}), 400

    if len(message) > MAX_REVIEW_LENGTH:
        return jsonify({
            'status': 'error',
            'message': 'Review must be 1000 characters or less.'
        }), 400

    connection = None
    cursor = None
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='Linux_Lab',
            user='labuser',
            password='your_password_here'
        )
        if connection.is_connected():
            cursor = connection.cursor()
            query_last_submission = "SELECT last_review FROM ratings WHERE user_id = %s ORDER BY last_review DESC LIMIT 1"
            cursor.execute(query_last_submission, (user_id,))
            last_submission = cursor.fetchone()

            if last_submission and last_submission[0]:
                last_review = last_submission[0]
                if isinstance(last_review, str):
                    last_review = datetime.strptime(last_review, '%Y-%m-%d %H:%M:%S')

                if datetime.now() - last_review < timedelta(hours=24):
                    return jsonify({
                        'status': 'error',
                        'message': 'You have exceeded your daily submission limit. Please try again later.'
                    }), 400

            query = "UPDATE ratings SET stars = %s, review = %s, last_review = NOW() WHERE user_id = %s"
            values = (rating, message, user_id)
            cursor.execute(query, values)
            connection.commit()

            if cursor.rowcount == 0:
                return jsonify({
                    'status': 'error',
                    'message': 'No previous rating exists for this user.'
                }), 404

            return jsonify({'status': 'success', 'message': 'Rating updated!'})

        return jsonify({'status': 'error', 'message': 'Failed to update rating.'}), 500
    except Error as e:
        print(f"Error while connecting to MySQL: {e}")
        return jsonify({'status': 'error', 'message': 'Failed to update rating.'})
    finally:
        if cursor is not None:
            cursor.close()
        if connection is not None and connection.is_connected():
            connection.close()


@app.route('/api/rating/show', methods=['GET', 'POST'])
def show_rating():
    if request.is_json:
        data = request.get_json() or {}
        user_id = data.get('user_id')
    else:
        user_id = request.args.get('user_id')

    if user_id is None:
        return jsonify({'status': 'error', 'message': 'user_id is required.'}), 400

    connection = None
    cursor = None
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='Linux_Lab',
            user='labuser',
            password='your_password_here'
        )
        if connection.is_connected():
            cursor = connection.cursor()
            query = "SELECT stars, review, last_review FROM ratings WHERE user_id = %s ORDER BY last_review DESC"
            cursor.execute(query, (user_id,))
            rows = cursor.fetchall()

            history = [
                {
                    'stars': row[0],
                    'review': row[1],
                    'last_review': format_db_timestamp(row[2])
                }
                for row in rows
            ]

            if not history:
                return jsonify({'status': 'success', 'history': [], 'message': 'No previous ratings found.'})

            return jsonify({'status': 'success', 'history': history})

        return jsonify({'status': 'error', 'message': 'Could not connect to database.'}), 500
    except Error as e:
        print(f"Error while connecting to MySQL: {e}")
        return jsonify({'status': 'error', 'message': 'Failed to retrieve rating history.'})
    finally:
        if cursor is not None:
            cursor.close()
        if connection is not None and connection.is_connected():
            connection.close()

if __name__ == '__main__':
    app.run(port=5000, debug=True)