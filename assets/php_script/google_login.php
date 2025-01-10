<?php
require_once 'vendor/autoload.php';  // Include the Google Client library

// Start a session to store user data
session_start();

// Create the Google client object
$client = new Google_Client();
$client->setClientId('341495212949-oqiqf3dfcte9ba1hhqu079mbohlcsgr8.apps.googleusercontent.com');
$client->setClientSecret('HYreuk1huMIatoJ29X8i77dv0XHR');
$client->setRedirectUri('http://localhost/e_commerce/user/index.php'); // Use the URI where Google will redirect after login
$client->addScope('email');  // Request email access

// Generate the login URL
$loginUrl = $client->createAuthUrl();

header('Location: ' . $loginUrl);  // Redirect the user to Google
exit;
?>