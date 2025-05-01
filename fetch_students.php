<?php
require 'config.php';

$result = $conn->query("SELECT id, name, age, course FROM students ORDER BY created_at DESC");
$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode(['status'=>'success','students'=>$students]);

$conn->close();
