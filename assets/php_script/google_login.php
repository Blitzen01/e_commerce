<?php
require_once 'vendor/autoload.php';  // Include the Google Client library

// Start a session to store user data
session_start();

// Create the Google client object
$client = new Google_Client();
$client->setClientId('871355226961-19ip522e0enk01oofpqdbscedb6r2ini.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/e_commerce/user/index.php'); // Use the URI where Google will redirect after login
$client->addScope('email');  // Request email access

// Generate the login URL
$loginUrl = $client->createAuthUrl();

header('Location: ' . $loginUrl);  // Redirect the user to Google
exit;
?>