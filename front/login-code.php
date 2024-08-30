<?php
require_once('../admin/functions.php');


if (isset($_POST['loginBtn'])) {
    $emailInput = validate($_POST['email']);
    $passwordInput = validate($_POST['password']);

    $email = filter_var($emailInput, FILTER_SANITIZE_EMAIL);

    if ($email != '' && $passwordInput != '') {
        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            if (password_verify($passwordInput, $row['password'])) {
                if ($row['role'] == 'admin') {
                    if ($row['is_ban'] == 1) {
                        redirect('login.php', 'Your account has been banned. Please contact admin.');
                    }

                    $_SESSION['auth'] = true;
                    $_SESSION['loggedInUserRole'] = $row['role'];
                    $_SESSION['loggedInUser'] = [
                        'name' => $row['name'],
                        'email' => $row['email']
                    ];

                    redirect('../admin/index.php', 'Logged In Successfully');
                } else {
                    if ($row['is_ban'] == 1) {
                        redirect('login.php', 'Your account has been banned. Please contact admin.');
                    }

                    $_SESSION['auth'] = true;
                    $_SESSION['loggedInUserRole'] = $row['role'];
                    $_SESSION['loggedInUser'] = [
                        'name' => $row['name'],
                        'email' => $row['email']
                    ];
                    redirect('index.php', 'Logged In Successfully');
                }
            } else {
                redirect('login.php', 'Invalid Email or Password');
            }
        } else {
            redirect('login.php', 'Invalid Email or Password');
        }

        $stmt->close();
    } else {
        redirect('login.php', 'All Fields Required');
    }
}

