<?php
session_start();
require_once('../../config/database.php');
require_once('../../config/language.php');

// Check if parent is logged in
if (!isset($_SESSION['parent_name']) || $_SESSION['user_type'] !== 'parent') {
    header('Location: Parent.html?error=notloggedin');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard - ClassLog</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="../../img/logo.png" alt="logo">
                <h2>Attendance Marking System</h2>
            </a>
            
            <div class="navbar-right">
                <ul class="links">
                    <div class="profile">
                        <img src="../../img/user.png" class="profile-photo">
                        <span class="username"><?php echo htmlspecialchars($_SESSION['parent_name']); ?></span>
                        <div class="popup-info">
                            <p><strong>Relationship:</strong> <?php echo htmlspecialchars($_SESSION['relationship']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['parent_email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($_SESSION['parent_phone']); ?></p>
                            <hr>
                            <p><strong>Child:</strong> <?php echo htmlspecialchars($_SESSION['student_name']); ?></p>
                            <p><strong>Student ID:</strong> <?php echo htmlspecialchars($_SESSION['student_id']); ?></p>
                            <p><strong>Department:</strong> <?php echo htmlspecialchars($_SESSION['department_name']); ?></p>
                            <p><strong>Batch:</strong> <?php echo htmlspecialchars($_SESSION['batch_year']); ?></p>
                        </div>
                    </div>
                    <span class="close-btn material-symbols-rounded">close</span>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
                <span class="notification-btn material-symbols-rounded">notifications</span>
                <button class="logout-btn" id="logoutBtn">LOGOUT</button>
            </div>
        </nav>
    </header>
    
    <main>
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['parent_name']); ?>!</h1>
            <p>Monitor your child's attendance and academic progress</p>
        </div>
        
        <section class="options">
            <div class="option">
                <a href="Child_Attendance.php">
                    <span class="material-symbols-rounded">person</span>
                    <span>Child's Attendance</span>
                </a>
            </div>
            
            <div class="option">
                <a href="Attendance_Reports.php">
                    <span class="material-symbols-rounded">assessment</span>
                    <span>Attendance Reports</span>
                </a>
            </div>
            
            <div class="option">
                <a href="Subject_Performance.php">
                    <span class="material-symbols-rounded">school</span>
                    <span>Subject Performance</span>
                </a>
            </div>
            
            <div class="option">
                <a href="Absence_Requests.php">
                    <span class="material-symbols-rounded">event_busy</span>
                    <span>Absence Requests</span>
                </a>
            </div>
            
            <div class="option">
                <a href="Messages.php">
                    <span class="material-symbols-rounded">message</span>
                    <span>Messages</span>
                </a>
            </div>
            
            <div class="option">
                <a href="Profile_Settings.php">
                    <span class="material-symbols-rounded">settings</span>
                    <span>Profile Settings</span>
                </a>
            </div>
        </section>
        
        <!-- Quick Stats Section -->
        <section class="quick-stats">
            <h2>Quick Overview</h2>
            <div class="stats-grid">
                <?php
                try {
                    $student_id = $_SESSION['student_id'];
                    
                    // Get current month attendance percentage
                    $current_month = date('Y-m');
                    $attendance_query = "
                        SELECT COUNT(*) as total_present
                        FROM (
                            SELECT scanned_Date FROM ic_2201_attendance WHERE student_id = ? AND DATE_FORMAT(scanned_Date, '%Y-%m') = ?
                            UNION ALL
                            SELECT scanned_Date FROM ft_1101_attendance WHERE student_id = ? AND DATE_FORMAT(scanned_Date, '%Y-%m') = ?
                            UNION ALL
                            SELECT scanned_Date FROM events_attendance WHERE student_id = ? AND DATE_FORMAT(scanned_Date, '%Y-%m') = ?
                        ) as all_attendance
                    ";
                    
                    $stmt = $pdo->prepare($attendance_query);
                    $stmt->execute([$student_id, $current_month, $student_id, $current_month, $student_id, $current_month]);
                    $attendance_data = $stmt->fetch();
                    $total_present = $attendance_data['total_present'] ?? 0;
                    
                    // Get total possible classes this month (estimated)
                    $total_possible = 20; // Approximate classes per month
                    $attendance_percentage = $total_possible > 0 ? round(($total_present / $total_possible) * 100, 1) : 0;
                    
                    echo "
                    <div class='stat-card'>
                        <div class='stat-icon'>
                            <span class='material-symbols-rounded'>check_circle</span>
                        </div>
                        <div class='stat-info'>
                            <h3>{$attendance_percentage}%</h3>
                            <p>This Month's Attendance</p>
                        </div>
                    </div>
                    
                    <div class='stat-card'>
                        <div class='stat-icon'>
                            <span class='material-symbols-rounded'>event</span>
                        </div>
                        <div class='stat-info'>
                            <h3>{$total_present}</h3>
                            <p>Classes Attended</p>
                        </div>
                    </div>
                    
                    <div class='stat-card'>
                        <div class='stat-icon'>
                            <span class='material-symbols-rounded'>school</span>
                        </div>
                        <div class='stat-info'>
                            <h3>" . $_SESSION['department_name'] . "</h3>
                            <p>Department</p>
                        </div>
                    </div>
                    ";
                } catch (PDOException $e) {
                    echo "<div class='error'>Unable to load statistics</div>";
                }
                ?>
            </div>
        </section>
    </main>
    
    <script src="../../js/script_2.js"></script>
    <script>
        document.getElementById("logoutBtn").addEventListener("click", function () {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "../logout.php";
            }
        });
    </script>
</body>
</html>