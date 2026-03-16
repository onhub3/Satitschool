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

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'รหัสไม่ถูกต้อง']);
        exit();
    }

    try {
        $pdo->beginTransaction();

        // Get user_id and profile_image
        $stmtGet = $pdo->prepare("SELECT user_id, profile_image FROM teachers WHERE id = ?");
        $stmtGet->execute([$id]);
        $teacher = $stmtGet->fetch();

        if (!$teacher) {
            throw new Exception("ไม่พบข้อมูลครูนี้ในระบบ");
        }

        // DELETE from users (Because of ON DELETE CASCADE in teachers, this will also delete the teacher record)
        $stmtDel = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmtDel->execute([$teacher['user_id']]);

        // Delete profile image file if exists
        $uploadDir = '../../assets/images/profiles/';
        if (!empty($teacher['profile_image']) && file_exists($uploadDir . $teacher['profile_image'])) {
            unlink($uploadDir . $teacher['profile_image']);
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'ลบข้อมูลสำเร็จ']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
}
?>
