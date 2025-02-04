<?php
// Start or resume the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); // Ensure the script stops executing after redirection
}
?>