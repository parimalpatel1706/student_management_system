<?php
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$id   = (int) ($data['id'] ?? 0);

if (!$id) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'Invalid student ID.']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['status'=>'success','deletedId'=>$id]);
} else {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'Delete failed.']);
}

$stmt->close();
$conn->close();
