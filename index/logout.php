<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login or home page
header('Location: index.php'); // Adjust the URL to your login page
exit();
?>
