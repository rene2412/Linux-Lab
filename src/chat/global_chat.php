<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL & ~E_WARNING);

require_once "../../includes/database.inc.php";
$userID = $_SESSION["user_id"]; 
$username = $_SESSION["user_username"] ?? "User Not Logged In";
$sendJson = json_encode(["username" => $username]) ;
function process_comment(PDO $pdo, $userID, $username, string $comment) : string {
    $sql = "INSERT INTO user_global_comments (user_id, username, comment) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$userID, $username, $comment])) {
        return "Comment Succesfully published\n";
    }
    else return "Failiure to post comment\n";
}
function display_user_comments(PDO $pdo): array {
    //display every usernames comments
    $sql = "SELECT username, comment, modified FROM user_global_comments ORDER BY modified DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
} 

  if ($_SERVER['REQUEST_METHOD'] === "POST" && $userID) {
    $comment = trim($_POST["comment"]);
    if (!empty($comment)) {
        echo process_comment( $pdo, $userID, $username, $comment) . "\n";    
    }
    else echo "Comment Can't Be Empty\n";
} 
elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
         echo "Log In or Sign Up To Post A Comment\n";
}

// Fetch and display all comments
$commentLogs = display_user_comments($pdo);
// Print every comment for every user
foreach ($commentLogs as $chat) {
    if (isset($chat['username']) && isset($chat['comment']) && isset($chat['modified'])) {
        echo "Username: " . $chat['username'] . "\n";
        echo "Comment: " . $chat['comment'] . "\n";
        echo "Modified: " . $chat['modified'] . "\n";
        echo "-------------------------\n";
    }
}