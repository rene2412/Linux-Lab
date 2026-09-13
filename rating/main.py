from flask import Flask
from flask_cors import CORS

from rating import (
    submit_rating,
    resubmit_rating,
    show_rating,
)
from comments import submit_comment, comment_history

app = Flask(__name__)
CORS(app)

app.add_url_rule('/api/rating', view_func=submit_rating, methods=['POST'])
app.add_url_rule('/api/rating/resubmit', view_func=resubmit_rating, methods=['POST'])
app.add_url_rule('/api/rating/show', view_func=show_rating, methods=['GET', 'POST'])
app.add_url_rule('/api/comments', view_func=submit_comment, methods=['POST'])
app.add_url_rule('/api/comments/history', view_func=comment_history, methods=['GET'])


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
