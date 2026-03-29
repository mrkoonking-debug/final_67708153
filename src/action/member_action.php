<?php
require_once '../config/db.php';
$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    if ($action == 'read') {
        $stmt = $pdo->query("SELECT * FROM members ORDER BY id DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } 
    elseif ($action == 'create') {
        $stmt = $pdo->prepare("INSERT INTO members (member_id, fullname, faculty) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['member_id'], $_POST['fullname'], $_POST['faculty']]);
        echo json_encode(['status' => 'success']);
    } 
    elseif ($action == 'update') {
        $stmt = $pdo->prepare("UPDATE members SET member_id=?, fullname=?, faculty=? WHERE id=?");
        $stmt->execute([$_POST['member_id'], $_POST['fullname'], $_POST['faculty'], $_POST['id']]);
        echo json_encode(['status' => 'success']);
    } 
    elseif ($action == 'delete') {
        $stmt = $pdo->prepare("DELETE FROM members WHERE id=?");
        $stmt->execute([$_POST['id']]);
        echo json_encode(['status' => 'success']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>