<?php
session_start();

if (isset($_SESSION["user_username"])) {
    $username = $_SESSION["user_username"];
    
    try {
        require_once '../../includes/database.inc.php';
        
        $sql = "UPDATE users SET is_logged_in = FALSE WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => htmlspecialchars($username)]); 

        // Clear the session data
        session_unset();   // Unset all session variables
        session_destroy(); // Destroy the session

        // Once user logs out redirect to the landing page
        header("Location: ../pages/landing_page/landing_page.html");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle case if user is not logged in or session is not set
    header("Location: ../pages/landing_page/landing_page.html");
    exit();
}
?>
