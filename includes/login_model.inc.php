<?php 

declare(strict_types=1);
function GetUser(object $pdo, string $username) : array|false {
    $query = "SELECT * FROM users  WHERE username = :username;";
	$statement = $pdo->prepare($query);
	$statement->bindParam(":username", $username);
	$statement->execute();

	$result = $statement->fetch(PDO::FETCH_ASSOC);
	return $result ?: false;
}