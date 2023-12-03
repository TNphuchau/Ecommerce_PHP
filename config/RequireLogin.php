<?php
function requireLogin() {
    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page in the app/View directory
        header('Location: app/View/loginRegister.php');
        exit();
    }
}
?>
