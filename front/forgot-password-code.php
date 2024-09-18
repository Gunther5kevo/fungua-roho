<?php
session_start();

include 'functions.php'; // Include any necessary functions

if(isset($_POST['resetPasswordBtn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(50)); // Generate a secure token

        // Store the token in the database with the user's email
        $updateQuery = "UPDATE users SET reset_token='$token', reset_token_expiry=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email='$email'";
        if(mysqli_query($conn, $updateQuery)) {
            // Send reset link to the user's email
            $resetLink = "http://yourwebsite.com/reset-password.php?token=" . $token;
            $subject = "Password Reset Request";
            $message = "Hi, you requested a password reset. Click the link below to reset your password:\n\n$resetLink";
            $headers = "From: no-reply@yourwebsite.com";

            if(mail($email, $subject, $message, $headers)) {
                $_SESSION['message'] = "A password reset link has been sent to your email.";
                header("Location: login.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Failed to send the reset link. Please try again.";
                header("Location: forgot-password.php");
                exit(0);
            }
        }
    } else {
        $_SESSION['message'] = "Email address not found.";
        header("Location: forgot-password.php");
        exit(0);
    }
} else {
    header("Location: forgot-password.php");
    exit(0);
}
