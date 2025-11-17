<?php
include '../db.php'; // Include your DB connection

if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

    $query = "SELECT total_lectures FROM subjects WHERE subject_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $subject_id);
    $stmt->execute();
    $stmt->bind_result($total_lectures);
    $stmt->fetch();
    $stmt->close();

    echo $total_lectures;
}
?>
