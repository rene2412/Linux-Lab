<?php
$host = "localhost"; 
$dbname = "Linux_Lab";  
$dbusername = "root";
$dbpassword = "Pandas_1"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {  
    die("Connection Failed: " . $e->getMessage());
}
?>