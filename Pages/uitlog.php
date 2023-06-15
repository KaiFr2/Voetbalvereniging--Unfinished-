<?php
session_start(); // Start the session

session_destroy(); // Destroy all session data

// Redirect to the login page or any other desired page
header("Location: index.php");
?>