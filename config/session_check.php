<?php
// Include this file at the top of protected pages

// If session is not already started (it should be started in db.php usually), start it.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if it's an API request (URL contains '/api/')
$is_api_request = strpos($_SERVER['REQUEST_URI'], '/api/') !== false;

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    if ($is_api_request) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    } else {
        header("Location: /Satitschool/login.php");
        exit();
    }
}

// Function to check roles
function checkRole($allowed_roles) {
    global $is_api_request;

    if (!isset($_SESSION['user_role'])) {
        if ($is_api_request) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        } else {
            header("Location: /Satitschool/login.php");
            exit();
        }
    }
    
    // Check if the current user's role is in the array of allowed roles
    if (!in_array($_SESSION['user_role'], $allowed_roles)) {
        if ($is_api_request) {
            header('Content-Type: application/json');
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Forbidden']);
            exit();
        } else {
            die("<h1>403 Forbidden</h1><p>You do not have permission to access this page.</p><a href='/Satitschool/index.php'>Return to Dashboard</a>");
        }
    }
}

// Example usage on a teacher page:
// checkRole(['teacher', 'admin']);
?>
