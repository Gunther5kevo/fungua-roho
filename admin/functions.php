<?php
include '../config/server.php';


function validate($inputData) {
    global $conn;
    // Trim and escape the input data
    return $conn->real_escape_string(trim($inputData));
}

function redirect($url, $status) {
    $_SESSION['status'] = $status;
    header('Location: ' . $url);
    exit(0);
}

function alertMessage() {
    if (isset($_SESSION['status'])) {
        echo '<div class="alert alert-success">
        <h6>' . $_SESSION['status'] . '</h6>
        </div>';
        unset($_SESSION['status']);
    } 
}


function logoutSession() {
    unset($_SESSION['auth']);
    unset($_SESSION['loggedInUserRole']);
    unset($_SESSION['loggedInUser']);
}

function checkParamId($paramType) {
    if (isset($_GET[$paramType])) {
        return $_GET[$paramType];
    } else {
        return 'No id given';
    }
}

function deleteQuery($conn, $tableName, $id) {
    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function getById($conn, $tableName, $id) {
    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        return [
            'status' => 200,
            'data' => $result
        ];
    } else {
        return [
            'status' => 404,
            'message' => 'No Data Record'
        ];
    }
}

function getAll($conn, $tableName) {
    $table = validate($tableName);

    $query = "SELECT * FROM $table";
    $result = $conn->query($query);

    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return false;
    }
}

