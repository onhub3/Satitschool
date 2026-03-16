<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../config/session_check.php';

if ($_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $line_id = trim($_POST['line_id'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $status = trim($_POST['status'] ?? 'active');

    if ($id <= 0 || empty($first_name) || empty($last_name)) {
        echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วนหรือไม่ถูกต้อง']);
        exit();
    }

    try {
        $pdo->beginTransaction();

        // 1. Get user_id related to this teacher and current profile image
        $stmtGet = $pdo->prepare("SELECT user_id, profile_image FROM teachers WHERE id = ?");
        $stmtGet->execute([$id]);
        $teacher = $stmtGet->fetch();

        if (!$teacher) {
            throw new Exception("ไม่พบข้อมูลครูนี้ในระบบ");
        }

        $user_id = $teacher['user_id'];
        $old_profile_image = $teacher['profile_image'];
        $new_profile_image = $old_profile_image; // Keep old by default

        // --- File Upload Handling ---
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_image']['tmp_name'];
            $fileName = $_FILES['profile_image']['name'];
            $fileSize = $_FILES['profile_image']['size'];
            
            if ($fileSize > 2 * 1024 * 1024) {
                 throw new Exception('ขนาดไฟล์รูปภาพต้องไม่เกิน 2MB');
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $fileTmpPath);
            finfo_close($finfo);

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($mimeType, $allowedMimeTypes)) {
                 throw new Exception('อนุญาตให้อัปโหลดเฉพาะไฟล์รูปภาพ (JPG, PNG, GIF) เท่านั้น');
            }

            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = 'teacher_' . uniqid() . '.' . $fileExtension;
            $uploadDir = '../../assets/images/profiles/';
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $new_profile_image = $newFileName;
                
                // Try to delete old image
                if ($old_profile_image && file_exists($uploadDir . $old_profile_image)) {
                    unlink($uploadDir . $old_profile_image);
                }
            } else {
                 throw new Exception('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');
            }
        }

        // 2. Update users table
        $stmtUser = $pdo->prepare("UPDATE users SET first_name=?, last_name=?, status=? WHERE id=?");
        $stmtUser->execute([$first_name, $last_name, $status, $user_id]);

        // 3. Update teachers table
        $stmtTeacher = $pdo->prepare("UPDATE teachers SET first_name=?, last_name=?, phone=?, line_id=?, profile_image=?, department=? WHERE id=?");
        $stmtTeacher->execute([$first_name, $last_name, $phone, $line_id, $new_profile_image, $department, $id]);

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'เพิ่มข้อมูลสำเร็จ']); // The UI expects 'เพิ่มข้อมูลสำเร็จ' from original code although it means Updated
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
}
?>
