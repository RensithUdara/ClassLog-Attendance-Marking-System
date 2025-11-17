<?php
session_start();
include '../db.php';

// Assuming the username is stored in the session
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

// Fetch relevant batches for the lecturer
$options = "";
$result = $conn->query("
    SELECT DISTINCT b.batch_id, b.year 
    FROM batch_subject bs 
    JOIN batch b ON bs.batch_id = b.batch_id 
    WHERE bs.lecturer_id = '$lecturer_id'
");

while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['batch_id']}'>{$row['year']}</option>";
}

// Output the options for the select dropdown
echo $options;
?>
