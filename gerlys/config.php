<?php

require 'vendor/autoload.php'; 
include 'connections.php'; // Use the existing database connection from connections.php

// Google API configuration
define('GOOGLE_CLIENT_ID', '537911589337-hngokud8kko9s9gi6btv5egr4nmefabq.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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x');
define('GOOGLE_REDIRECT_URL', 'http://localhost/gerlys/login.php');

// Start session
if(!session_id()){
    session_start();
}

// Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to Gerlys');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);

// Set the required scopes
$gClient->addScope("email");
$gClient->addScope("profile");

// Use the correct class for the Google OAuth service
$google_oauthV2 = new Google_Service_Oauth2($gClient);

?>