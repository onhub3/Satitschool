<?php
require_once '../config/db.php';

// Prepare response array
$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $response['message'] = 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน';
    } else {
        try {
            // Prepare statement to prevent SQL injection
            $stmt = $pdo->prepare("SELECT id, username, password_hash, role, first_name, last_name, status FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                
                // Check if account is active
                if ($user['status'] !== 'active') {
                    $response['message'] = 'บัญชีของคุณถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแลระบบ';
                }
                // Verify password
                elseif (password_verify($password, $user['password_hash'])) {
                    // Password correct, start a secure session
                    
                    // Prevent session fixation
                    session_regenerate_id(true);

                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_firstname'] = $user['first_name'];
                    $_SESSION['user_lastname'] = $user['last_name'];
                    
                    $response['success'] = true;
                    $response['message'] = 'เข้าสู่ระบบสำเร็จ';
                    $response['redirect'] = '/Satitschool/index.php'; // Explicit absolute path for redirect
                } else {
                    $response['message'] = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
                }
            } else {
                 $response['message'] = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            }
        } catch (PDOException $e) {
            $response['message'] = 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล';
            // Log error in production
            error_log("Login Error: " . $e->getMessage());
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
exit();
?>
