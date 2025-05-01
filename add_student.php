<?php
require 'config.php';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$name   = trim($data['name']   ?? '');
$age    = (int)   ($data['age']    ?? 0);
$course = trim($data['course'] ?? '');

if (!$name || !$age || !$course) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'All fields are required.']);
    exit;
}

// Prepare and execute
$stmt = $conn->prepare("INSERT INTO students (name, age, course) VALUES (?, ?, ?)");
$stmt->bind_param('sis', $name, $age, $course);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'student' => [
            'id'      => $stmt->insert_id,
            'name'    => $name,
            'age'     => $age,
            'course'  => $course
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'Insert failed.']);
}

$stmt->close();
$conn->close();
