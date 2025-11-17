<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
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
    <script src="script.js"></script>
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
                        <span class="username"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <div class="popup-info">
                            <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                            <p>Lecturer ID: <?php echo htmlspecialchars($_SESSION['lecturer_id']); ?></p>                         
                            <p>Department: <?php echo htmlspecialchars($_SESSION['department_name']); ?></p>
                        </div>
                    </div>
                    <span class="close-btn material-symbols-rounded">close</span>
                    <li><a href="../lecturer/Lecturer_Dashboard.php">Home</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
                <span class="notification-btn material-symbols-rounded">notifications</span>
                <button class="logout-btn" id="logoutBtn">LOGOUT</button>
            </div>
        </nav>
    </header>
    
    <!-- content must in this section -->
    <div class="container100" style="max-width: 420px">
    <h2>Attendance Report</h2><br>
        <button class="button100" id="add-report">Lecture Reports</button>
        <button class="button100" id="event-report">Event Reports</button>

        
        <div id="form-container">
            <div id="report-form" class="form-slide">
                <h2>Lecture Reports</h2>
                <form id="report-form-step1">
                    <label for="batch-year">Select a Batch Year:</label>
                    <select id="batch-year" name="batch_id" required>
                        <option value="">Select Year</option>
                        <!-- Options populated via AJAX -->
                    </select>
                    <button class="button100" type="button" id="prev-to-home">Previous</button>
                    <button class="button100" type="button" id="next-to-department">Next</button>
                </form>
                
                <form id="report-form-step2" style="display: none;">
                    <label for="department">Select a Department:</label>
                    <select id="department" name="department_id" required>
                        <option value="">Select Department</option>
                        <!-- Options populated via AJAX -->
                    </select>
                    <button class="button100" type="button" id="prev-to-batch-year">Previous</button>
                    <button class="button100" type="button" id="next-to-subject">Next</button>
                    
                </form>
                
                <form id="report-form-step3" style="display: none;">
                    <label for="subject">Select a Subject:</label>
                    <select id="subject" name="subject_id" required>
                        <option value="">Select Subject</option>
                        
                        <!-- Options populated via AJAX -->
                    </select>
                    <button class="button100" type="button" id="prev-to-department">Previous</button>
                    <button class="button100" type="button" id="next-to-report-type">Next</button>
                    
                </form>

                <form id="report-form-step4" style="display: none;">
                <label for="report-type">Select Report Type:</label>
                <select id="report-type" name="report_type" required>
                    <option value="" Selected>Select Report Type</option>
                    <option value="semester">Semester-wise</option>
                    <option value="lecture">Lecture-wise</option>
                    <option value="student">Selected Student</option>
                    <option value="time_period">Selected Time Period</option>
                </select>
                
                <div id="additional-fields" style="display: none;">
                    <!-- Fields will be added here dynamically based on report type -->
                </div><br>

                <button class="button100" type="button" id="prev-to-subject">Previous</button>
                <button class="button100" type="button" id="generate-report">Generate Report</button>
                </form>
            </div>


            <div id="event-form" class="form-slide">
                <h2>Event Reports</h2><br>
                <form id="event-report-form">
                    <label for="event-id">Enter Event Number:</label><br>
                    <input type="number" style="border-radius: 8px; padding: 8px; border: 1px solid #ccc;" id="event-id" name="event-id" required>
                    <br><br>
                    <button class="button100" type="button" id="prev-to-home1">Previous</button>
                    <button class="button100" type="button" id="generate-event-report">Generate Report</button>
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
