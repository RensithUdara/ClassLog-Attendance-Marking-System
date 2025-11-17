<?php


$reg_no = $_POST['reg_no'];
$pass = $_POST['password'];

require_once '../db.php';


$sql = "SHOW TABLES LIKE '20%'";
$result = $conn->query($sql);

$isAuthenticated = false;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_array()) {
        $table = $row[0];
        $query = "SELECT * FROM $table WHERE student_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $reg_no);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $student = $res->fetch_assoc();
            if (password_verify($pass, $student['password'])) {
                $isAuthenticated = true;
                session_start();

                // Assuming you have a database connection in $conn
                $batch_id = $student['batch_id'];
                $department_id = $student['department_id'];

                // Fetch batch year
                $query_batch = "SELECT year FROM batch WHERE batch_id = ?";
                $stmt_batch = $conn->prepare($query_batch);
                $stmt_batch->bind_param("i", $batch_id);
                $stmt_batch->execute();
                $result_batch = $stmt_batch->get_result();
                if ($row_batch = $result_batch->fetch_assoc()) {
                    $_SESSION['year'] = $row_batch['year'];
                }

                // Fetch department name
                $query_dept = "SELECT department_name FROM department WHERE department_id = ?";
                $stmt_dept = $conn->prepare($query_dept);
                $stmt_dept->bind_param("i", $department_id);
                $stmt_dept->execute();
                $result_dept = $stmt_dept->get_result();
                if ($row_dept = $result_dept->fetch_assoc()) {
                    $_SESSION['department_name'] = $row_dept['department_name'];
                }

                $_SESSION['student_id'] = $student['student_id'];
                $_SESSION['name'] = $student['name'];
                $_SESSION['email'] = $student['email'];
                $_SESSION['department_id'] = $student['department_id'];
                $_SESSION['batch_id'] = $student['batch_id'];
                break;
            }
        }

        $stmt->close();
    }
}

if ($isAuthenticated) {
    
    header("Location: Student_Dashboard.php?stat=Login_success");
    exit();
} else {
    
    header("Location: Student.html?stat=Invalid_Registration_Number_or_password");
}

?>
