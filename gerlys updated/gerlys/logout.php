<?php
session_start();

// If email session is set, use it
if (isset($_SESSION['email'])) {
    $logout = md5($_SESSION['email']);
    $email_md5 = md5($logout); // added the missing semicolon

    // Unset the email session
    unset($_SESSION['email']);
}

// Destroy the session completely
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session

// Provide feedback to the user
echo "Logging out... Please wait...";
header('location:index.php');

// Redirect the
