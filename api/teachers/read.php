<?php
header('Content-Type: application/json');
require_once '../../config/db.php';
require_once '../../config/session_check.php';

// Only Admin can read all teachers
if ($_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

try {
    $stmt = $pdo->prepare("
        SELECT t.id, t.user_id, t.teacher_code, t.first_name, t.last_name, t.phone, t.line_id, t.profile_image, t.department, u.status 
        FROM teachers t
        JOIN users u ON t.user_id = u.id
        ORDER BY t.created_at DESC
    ");
    $stmt->execute();
    $teachers = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'data' => $teachers]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
