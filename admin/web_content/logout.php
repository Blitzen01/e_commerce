<?php
session_start();
// Destroy the session and logout the user
unset($_SESSION['admin_email']);

header("Location: ../index.php"); // Redirect to the login page after logout

exit;
