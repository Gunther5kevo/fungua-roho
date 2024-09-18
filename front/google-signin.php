<?php
require_once '../vendor/autoload.php';

$client = new Google_Client();
$client->setClientId(getenv('GOOGLE_CLIENT_ID'));
$client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
$client->setRedirectUri('localhost/confess/front/google-callback.php'); // Set this to your callback URL
$client->addScope("email");
$client->addScope("profile");
