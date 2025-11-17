<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header('Location:../../index.html?error=notloggedin');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <script src="script2.js"></script>
    <link rel="stylesheet" href="style.css">
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
                        <span class="username"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                        <div class="popup-info">
                            <p>Student ID: <?php echo htmlspecialchars($_SESSION['student_id']); ?></p>
                            <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                            <p>Batch: <?php echo htmlspecialchars($_SESSION['year']); ?></p>                        
                            <p>Department: <?php echo htmlspecialchars($_SESSION['department_name']); ?></p>
                        </div>
                    </div>
                    <span class="close-btn material-symbols-rounded">close</span>
                    <li><a href="../student/Student_Dashboard.php">Home</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
                <span class="notification-btn material-symbols-rounded">notifications</span>
                <button class="logout-btn" id="logoutBtn">LOGOUT</button>
            </div>
        </nav>
    </header>
    
    <!-- content must in this section -->
    <div class="container100" style="max-width: 425px;">
    <h2>Attendance Report</h2><br>
        
        <div id="form-container">
            <div id="report-form" class="form-slide">
                <h2>View Reports</h2>
                
                <form id="report-form-step3">
                    <label for="subject">Select a Subject:</label>
                    <select id="subject" name="subject" required>
                        <option value="">Select Subject</option>
                        <!-- Options populated via AJAX -->
                    </select>
                    <button class="button100" type="button" id="generate-report">Generate Report</button>
                </form>

            </div>   
        </div>


        
    </div>
    

    <script src="../../js/script_2.js"></script>
    <script>
    document.getElementById("logoutBtn").addEventListener("click", function () {
      alert("You have been logged out!");
      window.location.href = "../logout.php";
    });
  </script>
</body>
</html>
