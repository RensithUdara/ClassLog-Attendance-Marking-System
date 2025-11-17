<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['name']) || !isset($_SESSION['student_id']) || !isset($_SESSION['batch_id']) || !isset($_SESSION['department_id'])) {
    echo json_encode(["error" => "User not logged in or missing session data"]);
    exit();
}

require '../db.php';

$batchId = $_SESSION['batch_id'];
$departmentId = $_SESSION['department_id'];

$subjects = [];
$result = $conn->query("
    SELECT s.subject_id, s.subject_code, s.subject_name
    FROM subjects s
    JOIN batch_subject bs ON s.subject_id = bs.Subject_id
    WHERE bs.batch_id ='$batchId' AND bs.department_id = '$departmentId'
");

while ($row = $result->fetch_assoc()) {
    $subjects[] = [
        "subject_id" => $row['subject_id'],
        "subject_code" => $row['subject_code'],
        "subject_name" => $row['subject_name']
    ];
}

echo json_encode($subjects);
?>
