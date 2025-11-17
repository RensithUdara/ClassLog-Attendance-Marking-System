<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_name'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
$batch_id = isset($_GET['batch_id']) ? $_GET['batch_id'] : null; // Get batch ID

if (!$subject_id || !$batch_id) {
    echo json_encode(['error' => 'Subject ID and Batch ID are required.']);
    exit();
}

// Step 1: Get the batch year from the batch table
$batchYearQuery = "SELECT year FROM batch WHERE batch_id = '$batch_id' LIMIT 1";
$batchYearResult = $conn->query($batchYearQuery);

if ($batchYearResult->num_rows === 0) {
    echo json_encode(['error' => 'No batch year found for the specified Batch ID.']);
    exit();
}

$row = $batchYearResult->fetch_assoc();
$batch_year = substr($row['year'], 0, 4); // Get first 4 characters of batch year

// Step 2: Fetch the table name for the subject
$tableNameQuery = "SELECT table_name FROM subjects WHERE subject_id = '$subject_id' LIMIT 1";
$tableNameResult = $conn->query($tableNameQuery);

if ($tableNameResult->num_rows === 0) {
    echo json_encode(['error' => 'No table found for the specified subject.']);
    exit();
}

$row = $tableNameResult->fetch_assoc();
$table_name = $row['table_name'];

// Step 3: Query the attendance table for scanned dates for students matching the batch year
$query = "SELECT DISTINCT scanned_Date 
          FROM $table_name 
          WHERE student_id LIKE '$batch_year%' 
          ORDER BY scanned_Date DESC";
$result = $conn->query($query);

if (!$result) {
    echo json_encode(['error' => 'Database error: ' . $conn->error]);
    exit();
}

$scanned_dates = [];
while ($row = $result->fetch_assoc()) {
    $scanned_dates[] = $row['scanned_Date'];
}

// Return the scanned dates as a JSON response
echo json_encode($scanned_dates);
?>
