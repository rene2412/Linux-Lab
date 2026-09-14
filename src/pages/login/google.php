   <?php
session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";
require_once "../../../includes/database.inc.php";
require_once "../../../includes/signup_contr.inc.php";
require_once "../../../includes/signup.inc.php";
require_once "../../../includes/signup_model.inc.php";
require_once "../../../includes/login_model.inc.php";

function TrimUsername(string $email): string {
    return explode('@', $email)[0];
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

$client = new Google\Client();
$client->setClientId($_ENV["CLIENT_ID"]);
$client->setClientSecret($_ENV["CLIENT_SECRET"]);
$client->setRedirectUri("https://linux-lab.live/src/pages/login/google.php");

if (!isset($_GET["code"])) {
    exit("Login Failed!");
}

$_SESSION["auth_type"] = "google";

try {
    $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if (isset($token["error"])) {
        exit("Google OAuth token error: " . $token["error"]);
    }

    $client->setAccessToken($token["access_token"]);
    $oauth = new Google\Service\Oauth2($client);
    $userinfo = $oauth->userinfo->get();

    $userEmail = $userinfo->email;
    $firstName = explode(' ', trim($userinfo->name))[0] ?? "User";

    $_SESSION['email'] = $userEmail;
    $_SESSION['user_username'] = $firstName;

    if (email_is_registered($pdo, $userEmail)) {
        $username = GetUsernameByEmail($pdo, $userEmail);
        $result = GetUser($pdo, $username);

        if (!$result || !isset($result['id'])) {
            die("User lookup failed after Google login.");
        }

        $_SESSION['user_id'] = (int) $result['id'];
        $_SESSION['user_username'] = TrimUsername($userEmail);
        $_SESSION['last_regeneration'] = time();

        $stmt = $pdo->prepare("UPDATE users SET is_logged_in = 1 WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);

        require_once '../../../includes/cookies.inc.php';
        setcookie('user_info', json_encode($response), 0, '/');

        header('Location: ../../../src/pages/dashboard/dashboard.html');
        exit;
    }

    $result = create_user($pdo, "Google", $userEmail, $userEmail);
    if (!$result || !isset($result['id'])) {
        die("User creation failed after Google login.");
    }

    $_SESSION['user_id'] = (int) $result['id'];
    $_SESSION['user_username'] = TrimUsername($userEmail);
    $_SESSION['last_regeneration'] = time();

    $user_id = $_SESSION['user_id'];
    $sql = $pdo->prepare("INSERT INTO user_progress (user_id, lesson_id, lessons_completed, current_lesson, current_module) VALUES (?, ?, ?, ?, ?)");
    $sql->execute([$user_id, 0, 0, 0, 'The Basics']);

    $stmt = $pdo->prepare("UPDATE users SET is_logged_in = 1 WHERE id = ?");
    $stmt->execute([$user_id]);

    require_once '../../../includes/cookies.inc.php';
    setcookie('user_info', json_encode($response), 0, '/');

    header('Location: ../../../src/pages/dashboard/dashboard.html');
    exit;
} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage();
}

