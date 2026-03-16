<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../config/session_check.php';

if ($_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Debug logging
file_put_contents('debug_log.txt', date('[Y-m-d H:i:s] ') . "POST: " . json_encode($_POST) . " FILES: " . json_encode($_FILES) . "\n", FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_code = trim($_POST['teacher_code'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $line_id = trim($_POST['line_id'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $status = trim($_POST['status'] ?? 'active');

    if (empty($teacher_code) || empty($first_name) || empty($last_name)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน']);
        exit();
    }

    // --- File Upload Handling ---
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];

        // Validate File Size (Max 2MB)
        if ($fileSize > 2 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB']);
            exit();
        }

        // Validate MIME type securely
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fileTmpPath);
        finfo_close($finfo);

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mimeType, $allowedMimeTypes)) {
            echo json_encode(['success' => false, 'message' => 'อนุญาตให้อัปโหลดเฉพาะไฟล์รูปภาพ (JPG, PNG, GIF) เท่านั้น']);
            exit();
        }

        // Generate secure random filename
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = 'teacher_' . uniqid() . '.' . $fileExtension;
        $uploadDir = '../../assets/images/profiles/';
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $profile_image = $newFileName;
        }
        else {
            echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ']);
            exit();
        }
    }
    // ---------------------------

    try {
        $pdo->beginTransaction();

        // 1. Check if user already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$teacher_code]);
        if ($stmt->rowCount() > 0) {
            throw new Exception("รหัสประจำตัวนี้มีอยู่ในระบบแล้ว");
        }

        // 2. Create User account
        $password_hash = password_hash($teacher_code, PASSWORD_BCRYPT);
        $stmtUser = $pdo->prepare("INSERT INTO users (username, password_hash, role, first_name, last_name, status) VALUES (?, ?, 'teacher', ?, ?, ?)");
        $stmtUser->execute([$teacher_code, $password_hash, $first_name, $last_name, $status]);
        $user_id = $pdo->lastInsertId();

        // 3. Create Teacher record
        $stmtTeacher = $pdo->prepare("INSERT INTO teachers (user_id, teacher_code, first_name, last_name, phone, line_id, profile_image, department) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtTeacher->execute([$user_id, $teacher_code, $first_name, $last_name, $phone, $line_id, $profile_image, $department]);

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'เพิ่มข้อมูลครูสำเร็จ (รหัสผ่านเริ่มต้นคือรหัสประจำตัว)']);
    }
    catch (Exception $e) {
        $pdo->rollBack();
        // If DB fails, delete the uploaded image
        if ($profile_image && file_exists('../../assets/images/profiles/' . $profile_image)) {
            unlink('../../assets/images/profiles/' . $profile_image);
        }
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
}
?>
