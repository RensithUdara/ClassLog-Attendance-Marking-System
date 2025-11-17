<?php
session_start();
include '../db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    echo "Error: User not logged in.";
    exit();
}

$user_name = $_SESSION['user_name'];

// Fetch the lecturer ID based on the username
$lecturer_result = $conn->query("SELECT lecturer_id FROM lecturer WHERE name = '$user_name'");
if ($lecturer_result->num_rows === 0) {
    echo "Error: Lecturer not found.";
    exit();
}
$lecturer_row = $lecturer_result->fetch_assoc();
$lecturer_id = $lecturer_row['lecturer_id'];

// Check if batch_id is passed
if (!isset($_GET['batch_id']) || empty($_GET['batch_id'])) {
    echo "Error: Batch ID not provided.";
    exit();
}
$batch_id = $_GET['batch_id'];

// Fetch distinct departments relevant to the lecturer and batch
$options = "";
$result = $conn->query("
    SELECT DISTINCT d.department_id, d.department_name 
    FROM batch_subject bs
    JOIN department d ON bs.department_id = d.department_id
    WHERE bs.lecturer_id = '$lecturer_id' AND bs.batch_id = '$batch_id'
");

while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['department_id']}'>{$row['department_name']}</option>";
}

// Output the options for the select dropdown
echo $options;
?>
