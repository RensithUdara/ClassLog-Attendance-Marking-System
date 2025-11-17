<?php
/**
 * Universal Logout Script
 * ClassLog Attendance Marking System
 * 
 * This script handles logout for all user types (Admin, Lecturer, Student, Parent)
 */

session_start();

// Clear all session variables
$_SESSION = array();

// Delete the session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Clear remember me cookies
$cookies_to_clear = [
    'remember_admin',
    'remember_lecturer', 
    'remember_student',
    'remember_parent'
];

foreach ($cookies_to_clear as $cookie) {
    if (isset($_COOKIE[$cookie])) {
        setcookie($cookie, '', time() - 3600, '/');
        unset($_COOKIE[$cookie]);
    }
}

// Destroy the session
session_destroy();

// Redirect to home page with success message
header('Location: ../index.html?success=logged_out');
exit();
?>