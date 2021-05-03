<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('ENTER GOOGLE CLIENT ID');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('ENTER GOOGLE CLIENT SECRET KEY');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/foodzie_v3/register.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?> 
