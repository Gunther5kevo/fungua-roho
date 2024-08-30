<?php
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

if (isset($_POST['saveSetting'])) {
    $title = validate($_POST['title']);
    $slug = validate($_POST['slug']);
    $small_description = validate($_POST['small_description']);
    $meta_description = validate($_POST['meta_description']);
    $meta_keyword = validate($_POST['meta_keyword']);
    $email1 = validate($_POST['email1']);
    $email2 = validate($_POST['email2']);
    $phone1 = validate($_POST['phone1']);
    $phone2 = validate($_POST['phone2']);
    $address = validate($_POST['address']);
    $settingId = validate($_POST['settingId']);

    if ($settingId == 'insert') {
        $query = "INSERT INTO settings (title, slug, small_description, meta_description, meta_keyword, email1, email2, phone1, phone2, address)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssss", $title, $slug, $small_description, $meta_description, $meta_keyword, $email1, $email2, $phone1, $phone2, $address);
    } elseif (is_numeric($settingId)) {
        $query = "UPDATE settings SET 
                    title = ?, 
                    slug = ?, 
                    small_description = ?, 
                    meta_description = ?, 
                    meta_keyword = ?, 
                    email1 = ?, 
                    email2 = ?, 
                    phone1 = ?, 
                    phone2 = ?, 
                    address = ? 
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssssi", $title, $slug, $small_description, $meta_description, $meta_keyword, $email1, $email2, $phone1, $phone2, $address, $settingId);
    }

    if ($stmt->execute()) {
        redirect('settings.php', 'Settings Saved');
    } else {
        redirect('settings.php', 'Something went wrong');
    }

    $stmt->close();
}

if (isset($_POST['saveSocialMedia'])) {
   
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $url = isset($_POST['url']) ? $_POST['url'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    
    if (!empty($name) && !empty($url) && !empty($status)) {
        
        // Prepare the SQL statement
        $sql = "INSERT INTO social_media (name, url, status) 
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
 
        // Bind parameters
        $stmt->bind_param('sss', $name, $url, $status);
 
        // Execute the statement
        if ($stmt->execute()) {
            redirect('social-media.php', 'Social Media link added successfully');
        } else {
            redirect('social-media-create.php', 'Something went wrong');
        }
 
        // Close the statement
        $stmt->close();
    } else {
        redirect('social-media-create.php', 'All fields are required');
    }
}

if (isset($_POST['updateSocialMedia'])) {

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $url = isset($_POST['url']) ? $_POST['url'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $socialMediaId = isset($_POST['socialMediaId']) ? $_POST['socialMediaId'] : '';  
    
    if (!empty($name) && !empty($url) && !empty($status) && !empty($socialMediaId)) {
        
        // Prepare the SQL statement
        $sql = "UPDATE social_media SET name = ?, url = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param('sssi', $name, $url, $status, $socialMediaId);

        // Execute the statement
        if ($stmt->execute()) {
            redirect('social-media.php', 'Social Media  updated successfully');
        } else {
            redirect('social-media-edit.php?id=' . $socialMediaId, 'Something went wrong');
        }

        // Close the statement
        $stmt->close();
    } else {
        redirect('social-media-edit.php?id=' . $socialMediaId, 'All fields are required');
    }
}
