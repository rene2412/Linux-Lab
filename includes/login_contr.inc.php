<?php 

declare(strict_types=1);
function is_input_empty(string $username, string $pwd) : bool {
	if (empty($username) || empty($pwd)) {
		 return true;
	}
	else return false;
}

function is_username_wrong($result) : bool|array {
    if (!$result) {
        return true;
    }
    else return false;
}   

function is_password_wrong(string $pwd, string $hashedPwd) : bool|array {
    if (!password_verify($pwd, $hashedPwd)) {
        return true;
    }
    else return false;
}
