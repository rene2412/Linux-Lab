<?php

//type decleration
declare(strict_types=1);

function GetUsername(object $pdo, string $username) : array|false {
	$query = "SELECT username FROM users WHERE LOWER(username) = LOWER(:username);";
	$statement = $pdo->prepare($query);
	$statement->bindParam(":username", $username);
	$statement->execute();
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	return $result;
}

function GetEmail(object $pdo, string $email) : array|false {
	$query = "SELECT username FROM users WHERE email = :email;";
	$statement = $pdo->prepare($query);
	$statement->bindParam(":email", $email);
	$statement->execute();

	$result = $statement->fetch(PDO::FETCH_ASSOC);
	return $result;
}

function GetUsernameByEmail(object $pdo, string $email) {
	$query = "SELECT username FROM users where email= :email";
	$statement = $pdo->prepare($query);
	$statement->bindParam(":email", $email);
	$statement->execute();

	$result = $statement->fetch(PDO::FETCH_ASSOC);
	return $result ? $result['username'] : null;
}

function set_user(object $pdo, string $pwd, string $username, string $email)  {
	$query = "INSERT INTO users (username, email, pwd) VALUES (:username, :email, :pwd);";
	$statement = $pdo->prepare($query);
	$options = [
		"cost" => 12
	];

	$hashedPassword = password_hash($pwd, PASSWORD_BCRYPT, $options); 

	$statement->bindParam(":username", $username);
	$statement->bindParam(":email", $email);
	$statement->bindParam(":pwd", $hashedPassword);
	$statement->execute();

    // Get the newly created user's ID
    $userId = $pdo->lastInsertId();
    
    // Return the user data needed for session
    return [
        "id" => $userId,
        "username" => $username
    ];


}




