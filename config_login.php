<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('769125436131-mkc56vu3kmio6a1m1rcpv6btuesnv7db.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('a-uPveGNC6M2aFqlshgGBgwX');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/foodzie_v3/login.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?> 