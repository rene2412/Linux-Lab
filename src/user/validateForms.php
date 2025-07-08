<?php

function GetEmail(PDO $pdo, int $userID) : string|false {
    $sql = "SELECT email FROM users WHERE id=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$userID]);
    $email = $statement->fetchColumn();
    return $email;
}

function GetUsername(PDO $pdo, int $userID) : string|false {
    $sql = "SELECT username FROM users WHERE id=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$userID]);
    $email = $statement->fetchColumn();
    return $email;
}

function UpdateEmail(PDO $pdo, int $userID, $new_email) : void {
    $sql = "UPDATE users SET email=? WHERE id=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$new_email, $userID]);
}

function UpdateUsername(PDO $pdo, int $userID, $new_username) : void {
    $sql = "UPDATE users SET username=? WHERE id=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$new_username, $userID]);
}

function Is_Username_Taken(PDO $pdo, string $username) : bool {
    $sql = "SELECT username FROM users WHERE username = ?";
    $statement = $pdo->prepare($sql);
	$statement->execute([$username]);
	$result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function Delete_Account(PDO $pdo, int $userID) : bool {
    $sql = "DELETE FROM user_progress WHERE user_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$userID]);
    
    $sql = "DELETE FROM user_lessons WHERE user_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$userID]);

    $sql = "DELETE FROM users WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$userID]);
}