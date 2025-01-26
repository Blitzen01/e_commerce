<?php
require_once 'vendor/autoload.php';  // Include the Google Client library

// Start a session to store user data
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Access the secrets
$clientId = getenv('CLIENT_ID');
$clientSecret = getenv('SECRET_TOKEN');

// Create the Google client object
$client = new Google_Client();
$client->setClientId('$clientId');
$client->setClientSecret('$clientSecret');
$client->setRedirectUri('http://localhost/e_commerce/user/index.php'); // Use the URI where Google will redirect after login
$client->addScope('email');  // Request email access

// Generate the login URL
$loginUrl = $client->createAuthUrl();

header('Location: ' . $loginUrl);  // Redirect the user to Google
exit;
?>