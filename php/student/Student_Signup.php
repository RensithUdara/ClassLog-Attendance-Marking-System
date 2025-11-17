<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $reg_no = $_POST['reg_no'];
    $department = $_POST['department'];
    $batch_year = $_POST['batch_year'];
    $password = $_POST['password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Validate registration number (you can add specific validation based on your requirements)
    if (!preg_match('/^\d{4}t\d{5}$/', $reg_no)) {
        header("Location:Student.php?stat=Invalid_Registration_Number");
        exit();
       // die("Invalid registration number format. It should be in the format 20xxtxxxxx.");
    }

    //validate password
    if (strlen($password) < 8 ||!preg_match('/[A-Z]/', $password) ||!preg_match('/[a-z]/', $password) ||!preg_match('/\d/', $password)) {
        header("Location:Student.php?stat=Invalid_password_format");
        exit();
        //die("Invalid password format. It should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.");
    }


    // Fetch the list of tables whose names start with '20'
    $sql = "SHOW TABLES LIKE '20%'";
    $result = $conn->query($sql);

    $isUnique = true;

    if ($result->num_rows > 0) {
        // Loop through each table to check for existing registration number and email
        while ($row = $result->fetch_array()) {
            $table = $row[0];
            $checkQuery = "SELECT * FROM $table WHERE student_id = ? OR email = ?";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bind_param("ss", $reg_no, $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $isUnique = false;
                break;
            }

            $stmt->close();
        }
    }

    if (!$isUnique) {
        header("Location:Student.php?stat=Registration_number_or_email_already_exists");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the appropriate table based on the batch year
    $table =  $batch_year;
    $insertQuery = "INSERT INTO $table (student_id, email, name, department_id, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssss", $reg_no, $email, $user_name, $department, $hashedPassword);

    if ($stmt->execute()) {
        header("Location:Student.php?stat=User_Registration_Success");
    } else {
        header("Location:Student.php?stat=Error");
    }

    $stmt->close();
    $conn->close();
}
?>