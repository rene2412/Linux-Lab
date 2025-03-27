#!/bin/bash

# Change ownership to Apache's web user (www-data)
sudo chown _www:_www src/testAPI/updateLessonCompleted.php
sudo chown _www:_www src/testAPI/updateUserInfo.php
sudo chown _www:_www src/testAPI/userInfo.json

# Give read & write permissions for Apache
sudo chmod 664 src/testAPI/updateLessonCompleted.php
sudo chmod 664 src/testAPI/updateUserInfo.php
sudo chmod 664 src/testAPI/userInfo.json

echo "Permissions have been updated!"

