<?php
$host = "localhost";
$dbname = "Linux_Lab";
$dbusername = "root";
$dbpassword = "";

try {
	//create a php data object called php that represents the parameters to connect to the database
	$pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword); 
	//->setAttribute will set the php object to look for errors in the connection
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {  
	die("Connection Failed: " . $e->getMessage());
} 


/*
//$host = "localhost";
$host = "2.tcp.us-cal-1.ngrok.io"; 
$port = "12376";
$dbname = "Linux_Lab";
$dbusername = "root";
$dbpassword = "";

// Create a connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";

try {
	//create a php data object called php that represents the parameters to connect to the database
	$pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword); 
	//->setAttribute will set the php object to look for errors in the connection
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {  
	die("Connection Failed: " . $e->getMessage());
} 
*/