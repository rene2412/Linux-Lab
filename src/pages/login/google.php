   <?php
   session_start();
   require_once __DIR__. "/../../../vendor/autoload.php";
   require_once "../../../includes/database.inc.php";
   require_once "../../../includes/signup_contr.inc.php";
   require_once "../../../includes/signup.inc.php";
   require_once "../../../includes/signup_model.inc.php";
   require_once "../../../includes/login_model.inc.php";

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
    $dotenv->load();
    $client = new Google\Client;
    $client->setClientId($_ENV["CLIENT_ID"]);
    $client->setClientSecret($_ENV["CLIENT_SECRET"]);
    $client->setRedirectUri("http://localhost/Linux-Lab/src/pages/login/google.php");

   function TrimUsername(string $email) {
    return explode('@', $email)[0];
   }

    if (! isset($_GET["code"])) {
        exit("Login Failed!");
    }
    $_SESSION["auth_type"] = "google";
    $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
    $client->setAccessToken($token["access_token"]);
    $oauth = new Google\Service\Oauth2($client);
    $userinfo = $oauth->userinfo->get();

    $firstName = explode(' ', trim($userinfo->name))[0];
    $userEmail = $userinfo->email;
    $_SESSION['user_username'] = $firstName;
    $_SESSION['email'] = $userEmail;

    if (email_is_registered($pdo, $userEmail)) {
        session_set_cookie_params([
        'lifetime' => 0, // session cookie (dies on browser close)
        'path' => '/',
        'domain' => '', 
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    $username = GetUsernameByEmail($pdo, $userEmail);
    $result = GetUser($pdo, $username); 
    $_SESSION["user_id"] = $result["id"];
    $newUsername = TrimUsername($userEmail);
    $_SESSION["user_username"] = $newUsername;
    $_SESSION["last_regeneration"] = time();
try {
    $stmt = $pdo->prepare("UPDATE users SET is_logged_in = 1 WHERE id = ?");
    $stmt->execute([$_SESSION["user_id"]]);
    if ($_SESSION["user_id"] !== null) {
        require_once '../../../includes/cookies.inc.php';
        $json_response = json_encode($response);
        setcookie('user_info', $json_response,  0 , "/"); // Expires when browser closes
    }
    header('Location: ../../../src/pages/dashboard/dashboard.html');
    $pdo = null;
    $statement = null;
    die();
    }   catch (PDOException $e) {
         echo "Caught exception: " . $e->getMessage();
    }
}

    try {
        $result = create_user($pdo, "Google", $userEmail, $userEmail);
		$newSessionId = session_create_id();		
	    $sessionId = $newSessionId . "_" . $result["id"];
		session_id($sessionId);
		$_SESSION["user_id"] = $result["id"];
        $newUsername = TrimUsername($userEmail);
		$_SESSION["user_username"] = $newUsername;
		$_SESSION["last_regeneration"] = time();
		$user_id = $_SESSION["user_id"];

        //for current module
		$sql = $pdo->prepare("INSERT INTO user_progress (user_id, lesson_id, lessons_completed, current_lesson, current_module) VALUES (?, ?, ?, ?, ?)");
		$sql->execute([$user_id, 0, 0, 0, 'The Basics']);
		//set user is logged
		$stmt = $pdo->prepare("UPDATE users SET is_logged_in = 1 WHERE id = ?");
        $stmt->execute([$_SESSION["user_id"]]);

		if ($_SESSION["user_id"] !== null) {
			require_once '../../../includes/cookies.inc.php';
			$json_response = json_encode($response);
			setcookie('user_info', $json_response, 0, "/"); // Expires when browser closes
		}
	    header("Location: ../../../src/pages/landing_page/landing_page.html");
	    $pdo = null;
	    $stmt = null;	 
	    die();

	} catch (PDOException $e) {
        echo "Caught exception: " . $e->getMessage();
        }

