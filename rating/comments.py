from flask import Flask, request, jsonify
from flask_cors import CORS

import mysql.connector
from mysql.connector import Error

app = Flask(__name__)
CORS(app)
MAX_COMMENT_LENGTH = 1000


def format_db_timestamp(value):
    if value is None:
        return None
    if isinstance(value, str):
        try:
            from datetime import datetime
            return datetime.strptime(value, '%Y-%m-%d %H:%M:%S').strftime('%d-%m-%Y')
        except ValueError:
            return value
    return value.strftime('%d-%m-%Y')


def validate_comment_text(comment):
    if comment is None:
        return False, 'Comment is required.'
    if isinstance(comment, str):
        comment = comment.strip()
    if comment in (None, ''):
        return False, 'Comment is required.'
    if len(comment) > MAX_COMMENT_LENGTH:
        return False, f'Comment must be {MAX_COMMENT_LENGTH} characters or less.'
    return True, ''


@app.route('/api/comments', methods=['POST'])
def submit_comment():
    print("Received request to submit comment.")
    data = request.get_json() or {}
    username = data.get('username')
    user_id = data.get('user_id')
    comment = data.get('comment')
    if comment is None:
        comment = data.get('comments')
    if isinstance(comment, str):
        comment = comment.strip()

    if user_id is None or comment in (None, ''):
        return jsonify({'status': 'error', 'message': 'user_id and comment are required.'}), 400

    valid, message = validate_comment_text(comment)
    if not valid:
        return jsonify({'status': 'error', 'message': message}), 400

    print(f"Comment: {comment}, User: {username}, User ID: {user_id}")

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
            query = "INSERT INTO user_global_comments (user_id, username, comment) VALUES (%s, %s, %s)"
            values = (user_id, username, comment)
            cursor.execute(query, values)
            connection.commit()
            return jsonify({'status': 'success', 'message': 'Comment received!'})

        return jsonify({'status': 'error', 'message': 'Could not connect to database.'}), 500
    except Error as e:
        print(f"Error while connecting to MySQL: {e}")
        return jsonify({'status': 'error', 'message': 'Failed to submit comment.'})
    finally:
        if cursor is not None:
            cursor.close()
        if connection is not None and connection.is_connected():
            connection.close()


@app.route('/api/comments/history', methods=['GET'])
def comment_history():
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
            query = "SELECT id, username, comment, modified FROM user_global_comments WHERE user_id = %s ORDER BY modified DESC"
            cursor.execute(query, (user_id,))
            rows = cursor.fetchall()

            history = [
                {
                    'id': row[0],
                    'username': row[1],
                    'comment': row[2],
                    'modified': format_db_timestamp(row[3])
                }
                for row in rows
            ]

            return jsonify({'status': 'success', 'history': history})

        return jsonify({'status': 'error', 'message': 'Could not connect to database.'}), 500
    except Error as e:
        print(f"Error while connecting to MySQL: {e}")
        return jsonify({'status': 'error', 'message': 'Failed to retrieve comment history.'})
    finally:
        if cursor is not None:
            cursor.close()
        if connection is not None and connection.is_connected():
            connection.close()


if __name__ == '__main__':
    app.run(port=5000, debug=True)