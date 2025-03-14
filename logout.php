<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Ensure the user cannot access previous pages
header("Location: login.php");
exit();
?>
