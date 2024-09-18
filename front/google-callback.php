<?php
session_start();
require_once 'google-signin.php';

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        $google_service = new Google_Scervice_Oauth2($client);
        $data = $google_service->userinfo->get();

        // Example: Store user data in session
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['user_email'] = $data['email'];
        $_SESSION['user_name'] = $data['name'];

        // Redirect to the homepage or dashboard
        header('Location: index.php');
        exit();
    } else {
        echo "Error during Google authentication.";
    }
} else {
    header('Location: login.php');
    exit();
}
