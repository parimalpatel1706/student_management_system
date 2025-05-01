<?php
// config.php
$host     = '127.0.0.1';
$username = 'root';
$password = 'root';
$dbname   = 'student_mgmt';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Always serve JSON
header('Content-Type: application/json; charset=utf-8');
