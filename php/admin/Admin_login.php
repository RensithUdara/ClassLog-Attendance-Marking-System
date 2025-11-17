<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get username and password from form
$user = $_POST['username'];
$pass = $_POST['password'];

require_once '../db.php';

// SQL query to fetch the user
$sql = "SELECT * FROM admin WHERE username = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Assuming passwords are not hashed
    if ($pass === $row['password']) {
        // Login successful
        $_SESSION['username'] = $user;
        header("Location: Admin_Dashboard.php?stat=login_successfully");
        exit;
    } else {
        // Invalid password
        header("Location: Admin.html?stat=Invalid_username_or_password");
    }
} else {
    // Invalid username
    header("Location: Admin.html?stat=Invalid_username_or_password");
}

$stmt->close();
$conn->close();
?>
