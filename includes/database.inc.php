<?php
$host = "localhost"; 
$dbname = "Linux_Lab";  
$dbusername = "root";
$dbpassword = "";
try {
	//create a php data object called php that represents the parameters to connect to the database
	$pdo = new PDO("mysql:host=$host;port=26632;dbname=$dbname", $dbusername, $dbpassword); 
	//->setAttribute will set the php object to look for errors in the connection
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {  
	die("Connection Failed: " . $e->getMessage());
} 
