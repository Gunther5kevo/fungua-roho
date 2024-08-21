<?php
include '../config/server.php';
include 'functions.php';

if (isset($_POST['saveUser'])) {
   
   $name = isset($_POST['name']) ? $_POST['name'] : '';
   $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $password = isset($_POST['password']) ? $_POST['password'] : '';
   $role = isset($_POST['role']) ? $_POST['role'] : '';
   $is_ban = isset($_POST['is_ban']) ? ($_POST['is_ban'] == true ? 1 : 0) : 0;

   if (!empty($name) && !empty($email) && !empty($phone) && !empty($password)) {
       // Hash the password before saving it to the database
       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

       // Prepare the SQL statement
       $sql = "INSERT INTO users (name, phone, email, password, role, is_ban) 
               VALUES (?, ?, ?, ?, ?, ?)";
       $stmt = $conn->prepare($sql);

       // Bind parameters
       $stmt->bind_param('sssssi', $name, $phone, $email, $hashedPassword, $role, $is_ban);

       // Execute the statement
       if ($stmt->execute()) {
           redirect('users.php', 'User/Admin added successfully');
       } else {
           redirect('users-create.php', 'Something went wrong');
       }

       // Close the statement
       $stmt->close();
   } else {
       redirect('users-create.php', 'All fields are required');
   }
}

if (isset($_POST['updateUser'])) {
   $id = validate($_POST['user_id']);
   $name = validate($_POST['name']);
   $phone = validate($_POST['phone']);
   $email = validate($_POST['email']);
   $password = validate($_POST['password']);
   $role = validate($_POST['role']);
   $is_ban = isset($_POST['is_ban']) ? 1 : 0;

   // Hash the password before saving it to the database
   $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   // Prepare the SQL statement
   $sql = "UPDATE users SET name = ?, phone = ?, email = ?, password = ?, role = ?, is_ban = ? WHERE id = ?";
   $stmt = $conn->prepare($sql);

   // Bind parameters
   $stmt->bind_param('sssssii', $name, $phone, $email, $hashedPassword, $role, $is_ban, $id);

   // Execute the statement
   if ($stmt->execute()) {
       $_SESSION['message'] = 'User updated successfully';
       $_SESSION['alert_type'] = 'success';
   } else {
       $_SESSION['message'] = 'Failed to update user: ' . $stmt->error;
       $_SESSION['alert_type'] = 'danger';
   }

   // Close the statement
   $stmt->close();

   header('Location: users-edit.php');
   exit();
}
