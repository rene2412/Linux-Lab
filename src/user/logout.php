<?php
session_start();

// Check if the session variable for user username is set
if (isset($_SESSION["user_username"])) {
    // Get the username from the session
    $username = $_SESSION["user_username"];
    
    try {
        require_once '../../includes/database.inc.php'; // Make sure $pdo is initialized here
        
        // Prepare the SQL query to update the user's login status
        $sql = "UPDATE users SET is_logged_in = FALSE WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => htmlspecialchars($username)]); // Use session's username

        // Clear the session data
        session_unset();   // Unset all session variables
        session_destroy(); // Destroy the session

        // Redirect to the landing page
        header("Location: ../pages/landing_page/landing_page.html");
        exit();  // Make sure no further code is executed after the redirect

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle case if user is not logged in or session is not set
    header("Location: ../pages/landing_page/landing_page.html");
    exit();
}
?>
