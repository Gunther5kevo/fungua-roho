<?php
include('functions.php');

$paramId = checkParamId('id');

if (is_numeric($paramId)) {
    $userId = validate($paramId);

    // Use $conn instead of $pdo
    $user = getById($conn, 'users', $userId);

    if ($user['status'] == 200) {
        $userDeleteRes = deleteQuery($conn, 'users', $userId);
        if ($userDeleteRes) {
            redirect('users.php', 'User deleted successfully');
        } else {
            redirect('users.php', 'Failed to delete user');
        }
    } else {
        redirect('users.php', $user['message']);
    }
} else {
    redirect('users.php', $paramId);
}

