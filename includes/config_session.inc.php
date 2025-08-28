<?php 

//Forces PHP to only use cookies for managing sessions ID's, disallowing the use of session IDs passed on the URL
//It is dangerous to pass session ID's via URLS, since they can become visible 
//1 means "enable this argument), 0 would mean the opposite 

ini_set("session.use_only_cookies", 1);

//Ensures that only server generated session IDs are accepetedm preventing malicious injections
ini_set("session.use_strict_mode", 1);

//the arguments that the session cookie will hold
session_set_cookie_params([
	"lifetime" => 0, //set the session to be 30 mins
	"domain" => "localhost", //limits the cookies range to this domain 
	"path" => "/", //cookies are valid across the website
	"secure" => false, //cookies are only valid with https
	"httponly" => true, //cookies not accessible bia javascript, enhaning security
  ]);

session_start();

if (isset($_SESSION["user_id"])) {
	if (!isset($_SESSION["last_regeneration"])) {
		regenerate_session_id_loggedin();
	} else {
		$interval = 60 * 30;
		if (time() - $_SESSION["last_regeneration"] >= $interval) {
			regenerate_session_id_loggedin();
		}
	}
}

else {
	if (!isset($_SESSION["last_regeneration"])) {
	regenerate_session_id();
	} else {
	$interval = 60 * 30;
	if (time() - $_SESSION["last_regeneration"] >= $interval) {
		regenerate_session_id();
		}
	}
}

function regenerate_session_id() : void {
	session_regenerate_id(true);
	$_SESSION["last_regeneration"] = time();
}

function regenerate_session_id_loggedin() : void {
		session_regenerate_id(true);

		$userId = $_SESSION["user_id"];
		$newSessionId = session_create_id();		
	    $sessionId = $newSessionId . "_" . $userId;
		session_id($sessionId);
		
		$_SESSION["last_regeneration"] = time();
		}
