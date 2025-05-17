<?php 
//type declaration, if an int is declared an int, it cannot be converted 
declare(strict_types=1);

function is_input_empty(string $username, string $pwd, string $email) : bool {
	if (empty($username) || empty($pwd) || empty($email)) {
		 return true;
	}
	else return false;
}

//checks if the email format is valid 
function is_email_valid(string $email) : bool {
	if (filter_var($email, FILTER_VALIDATE_EMAIL))	{ 
		return true;
	}
	else return false;
}
function is_username_too_long(string $username) : bool {
    if (strlen($username) > 15) {
        return true;
    }
    else return false;
}
function username_is_taken(object $pdo, string $username) : bool {
	if(GetUsername($pdo, $username)) {
		return true;
	}
	else return false;
}

function email_is_registered(object $pdo, string $email) : bool {
	if (GetEmail($pdo, $email)) {
		return true;
	}
	else return false;
}

function is_passsword_valid (string $pwd) : bool {
	if (strlen($pwd) > 10) {
		return false;
	}
// Check for at least one uppercase letter
	if (!preg_match('/[A-Z]/', $pwd)) {
		return false;
	}

// Check for at least one lowercase letter
	if (!preg_match('/[a-z]/', $pwd)) {
		return false;
	}

// Check for at least one digit
	if (!preg_match('/\d/', $pwd)) {
		return false;
	}

// Check for at least one special character
	if (!preg_match('/[\W_]/', $pwd)) {
		return false;
	}
else return true;
}

function create_user(object $pdo, string $pwd, string $username, string $email)  {
	return set_user($pdo, $pwd, $username, $email);
}

