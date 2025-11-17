<?php
session_start();
require_once('../../config/database.php');
require_once('../../config/language.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    try {
        // Check if parent exists and verify password
        $stmt = $pdo->prepare("SELECT parent_id, name, email, phone, student_id, relationship, password FROM parent_guardian WHERE email = ?");
        $stmt->execute([$email]);
        $parent = $stmt->fetch();
        
        if ($parent && password_verify($password, $parent['password'])) {
            // Get student information
            $batch_year = '20' . substr($parent['student_id'], 0, 2) . '_' . substr($parent['student_id'], 2, 2);
            $student_stmt = $pdo->prepare("SELECT name, department_id, batch_id FROM `{$batch_year}` WHERE student_id = ?");
            $student_stmt->execute([$parent['student_id']]);
            $student = $student_stmt->fetch();
            
            if ($student) {
                // Get department name
                $dept_stmt = $pdo->prepare("SELECT department_name FROM department WHERE department_id = ?");
                $dept_stmt->execute([$student['department_id']]);
                $department = $dept_stmt->fetch();
                
                // Get batch year
                $batch_stmt = $pdo->prepare("SELECT year FROM batch WHERE batch_id = ?");
                $batch_stmt->execute([$student['batch_id']]);
                $batch = $batch_stmt->fetch();
                
                // Set session variables
                $_SESSION['parent_id'] = $parent['parent_id'];
                $_SESSION['parent_name'] = $parent['name'];
                $_SESSION['parent_email'] = $parent['email'];
                $_SESSION['parent_phone'] = $parent['phone'];
                $_SESSION['relationship'] = $parent['relationship'];
                $_SESSION['student_id'] = $parent['student_id'];
                $_SESSION['student_name'] = $student['name'];
                $_SESSION['department_name'] = $department['department_name'];
                $_SESSION['batch_year'] = $batch['year'];
                $_SESSION['user_type'] = 'parent';
                
                // Set remember me cookie if requested
                if ($remember) {
                    $cookie_value = base64_encode($email . ':' . $parent['parent_id']);
                    setcookie('remember_parent', $cookie_value, time() + (30 * 24 * 60 * 60), '/', '', false, true); // 30 days
                }
                
                // Redirect to dashboard
                header('Location: Parent_Dashboard.php');
                exit();
            } else {
                header('Location: Parent.html?error=student_not_found');
                exit();
            }
        } else {
            header('Location: Parent.html?error=invalid');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Parent login error: " . $e->getMessage());
        header('Location: Parent.html?error=system');
        exit();
    }
} else {
    header('Location: Parent.html');
    exit();
}
?>