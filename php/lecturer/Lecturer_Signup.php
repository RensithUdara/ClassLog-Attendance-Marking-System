<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $password = $_POST['password'];


    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check if email already exists
    $sql = "SELECT * FROM lecturer WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: lecturer.html?stat=stmtfailed1");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        header("Location: lecturer.html?stat=Email_Already_Exists");
        exit();
    }

    mysqli_stmt_close($stmt);

    // Insert new user
    $sql = "INSERT INTO Lecturer (name, email, department_id, password) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: lecturer.html?stat=stmtfailed2");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $user_name, $email, $department, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: lecturer.html?stat=registration_successful");
    exit();
} else {
    header('Location: lecturer.html?stat=error');
    exit();
}
?>