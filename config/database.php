<?php
/**
 * Database Configuration File
 * ClassLog Attendance Marking System
 * 
 * This file contains database connection settings.
 * Make sure to update these values according to your environment.
 */

// Database connection parameters
$servername = "localhost";
$username = "root";  // Change to your database username
$password = "";      // Change to your database password
$dbname = "attendance_system";

// Set the timezone
date_default_timezone_set('Asia/Colombo');

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set PDO attributes for better error handling and security
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch(PDOException $e) {
    // Log error and die gracefully
    error_log("Database Connection Error: " . $e->getMessage());
    die("Connection failed. Please check your database configuration.");
}

// Database connection function for legacy code
function getConnection() {
    global $servername, $username, $password, $dbname;
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        error_log("MySQLi Connection Error: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Application settings
define('APP_NAME', 'ClassLog Attendance System');
define('APP_VERSION', '2.0.0');
define('BASE_URL', 'http://localhost/classlog-attendance-system/');
define('UPLOAD_DIR', dirname(__DIR__) . '/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
ini_set('session.gc_maxlifetime', 3600); // 1 hour session timeout

?>