<?php
include '../config/server.php';

session_start();

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

function webSetting($columnName) {
    $setting = getById('settings', 1); 
    if ($setting['status'] == 200 && isset($setting['data'][$columnName])) {
        return $setting['data'][$columnName];
    } else {
        return null; 
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
function getById($tableName, $id) {
    global $conn;

    // Validate and wrap the table name with backticks
    $table = "`" . validate($tableName) . "`";
    $id = validate($id);

    // Prepare the SQL statement
    $query = "SELECT * FROM $table WHERE id = ? LIMIT 1";
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("i", $id);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the associative array
        $data = $result->fetch_assoc();

        // Check if any data was fetched
        if ($data) {
            $stmt->close();
            return [
                'status' => 200,
                'data' => $data
            ];
        } else {
            $stmt->close();
            return [
                'status' => 404,
                'message' => 'No Data Record'
            ];
        }
    } else {
        // Prepare failed, return error details and the actual query
        return [
            'status' => 500,
            'message' => 'SQL Preparation Error: ' . $conn->error,
            'query' => $query
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

