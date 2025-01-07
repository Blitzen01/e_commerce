<?php
session_start();
// Destroy the session and logout the user
unset($_SESSION['email']);
header("Location: ../../user/index.php"); // Redirect to the login page after logout
exit;
