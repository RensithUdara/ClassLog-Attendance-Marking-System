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

// Check if batch_id and department_id are provided
if (!isset($_GET['batch_id']) || empty($_GET['batch_id']) || !isset($_GET['department_id']) || empty($_GET['department_id'])) {
    echo "Error: Batch ID or Department ID not provided.";
    exit();
}

$batch_id = $_GET['batch_id'];
$department_id = $_GET['department_id'];

// Fetch subjects relevant to the lecturer, batch, and department
$options = "";
$result = $conn->query("
    SELECT DISTINCT s.Subject_id, s.Subject_Code, s.Subject_Name 
    FROM batch_subject bs
    JOIN subjects s ON bs.Subject_id = s.Subject_id
    WHERE bs.lecturer_id = '$lecturer_id' AND bs.batch_id = '$batch_id' AND bs.department_id = '$department_id'
");

while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['Subject_id']}'>{$row['Subject_Code']} - {$row['Subject_Name']}</option>";
}

// Output the options for the select dropdown
echo $options;
?>
