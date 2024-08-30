<?php

include('functions.php');


if (isset($_SESSION['auth'])) {
    if (isset($_SESSION['loggedInUserRole']) && isset($_SESSION['loggedInUser']['email'])) {
        $role = validate($_SESSION['loggedInUserRole']);
        $email = validate($_SESSION['loggedInUser']['email']);

        // Prepare the SQL query using MySQLi
        $query = "SELECT * FROM users WHERE email = ? AND role = ? LIMIT 1";
        $stmt = $conn->prepare($query);

        // Bind the parameters
        $stmt->bind_param('ss', $email, $role);

        // Execute the query
        $stmt->execute();
        
        // Fetch the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row === null) {  // If no user is found, or there’s a mismatch
            logoutSession();
            redirect('../login.php', 'Access Denied');
        } else {
            if ($row['role'] !== 'admin') {
                logoutSession();
                redirect('../login.php', 'Access Denied');
            }
        }

        // Close the statement
        $stmt->close();
    } else {
        redirect('../login.php', 'Login to continue..');
    }
} else {
    redirect('../login.php', 'Login to continue..');
}

