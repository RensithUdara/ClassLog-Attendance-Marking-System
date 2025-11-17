<?php

$email = $_POST['email'];
$pass = $_POST['password'];

require_once '../db.php';

// SQL query to fetch the lecturer
$sql = "SELECT * FROM lecturer WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pwdCheck = password_verify($pass, $row['password']);
    if ($pwdCheck == true) {
        // Login successful
        session_start();

        // Store lecturer data in session
        $_SESSION['lecturer_id'] = $row['lecturer_id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['department_id'] = $row['department_id'];

        // Fetch department name
        $dept_id = $row['department_id'];
        $sql_dept = "SELECT department_name FROM department WHERE department_id = ?";
        $stmt_dept = $conn->prepare($sql_dept);
        $stmt_dept->bind_param("i", $dept_id);
        $stmt_dept->execute();
        $result_dept = $stmt_dept->get_result();
        if ($row_dept = $result_dept->fetch_assoc()) {
            $_SESSION['department_name'] = $row_dept['department_name'];
        }

        header("Location: Lecturer_Dashboard.php?stat=Login_successfully");
        exit();
    } else {
        // Invalid password
        header("Location: Lecturer.html?stat=Invalid_email_or_password");
    }
} else {
    // Invalid email
    header("Location: Lecturer.html?stat=Invalid_email_or_password");
}

?>
