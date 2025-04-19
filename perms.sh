#!/bin/bash

# Change ownership to Apache's web user (www-data)
sudo chown www-data:www-data src/testAPI/updateLessonCompleted.php
sudo chown www-data:www-data src/testAPI/updateUserInfo.php
sudo chown www-data:www-data src/testAPI/userInfo.json

# Give read & write permissions for Apache
sudo chmod 664 src/testAPI/updateLessonCompleted.php
sudo chmod 664 src/testAPI/updateUserInfo.php
sudo chmod 664 src/testAPI/userInfo.json

echo "Permissions have been updated!"

