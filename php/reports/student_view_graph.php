<?php
// Include database connection and session handling
session_start();
include '../db.php';

// Check if the user is logged in
if (!isset($_SESSION['name']) || !isset($_SESSION['student_id']) || !isset($_SESSION['batch_id']) || !isset($_SESSION['department_id'])) {
    echo json_encode(["error" => "User not logged in or missing session data"]);
    exit();
}

// Fetch report data from the JSON output of generate_report.php
// Assuming that the data is sent via an AJAX request to this page
if (!isset($_GET['subject_id'])) {
    echo json_encode(['error' => 'No subject id provided.']);
    exit();
}

$subject_id = json_decode($_GET['subject_id'], true);

// Check if the report data was fetched successfully
if (isset($subject_id['error'])) {
    echo json_encode(['error' => $subject_id['error']]);
    exit();
}

$student_name = $_SESSION ['name'];
$student_id = $_SESSION ['student_id'];
$batchId = $_SESSION['batch_id'];
$departmentId = $_SESSION['department_id'];

// Fetch the batch year
$queryBatchYear = "SELECT year FROM batch WHERE batch_id = ?";
$stmtBatchYear = $conn->prepare($queryBatchYear);
$stmtBatchYear->bind_param("i", $batchId);
$stmtBatchYear->execute();
$resultBatchYear = $stmtBatchYear->get_result();
$batch_year = $resultBatchYear->fetch_assoc()['year'] ?? 'N/A';

// Fetch the department name
$queryDept = "SELECT department_name FROM department WHERE department_id = ?";
$stmtDept = $conn->prepare($queryDept);
$stmtDept->bind_param("i", $departmentId);
$stmtDept->execute();
$resultDept = $stmtDept->get_result();
$department_name = $resultDept->fetch_assoc()['department_name'] ?? 'N/A';


// Fetch the subject details
$querySubject = "SELECT subject_name, subject_code, total_lectures, table_name FROM subjects WHERE subject_id = ?";
$stmtSubject = $conn->prepare($querySubject);
$stmtSubject->bind_param("i", $subject_id);
$stmtSubject->execute();
$resultSubject = $stmtSubject->get_result();
$subject_data = $resultSubject->fetch_assoc();
$subject_name = $subject_data['subject_name'] ?? 'N/A';
$subject_code = $subject_data['subject_code'] ?? 'N/A';
$total_lectures = $subject_data['total_lectures'] ?? 'N/A';
$table_name = $subject_data['table_name'] ?? 'N/A';


// Fetch lecturer id
$queryLecturerid = "SELECT lecturer_id FROM batch_subject WHERE batch_id = ? AND Subject_id = ? AND department_id = ?";
$stmtLecturerid = $conn->prepare($queryLecturerid);
$stmtLecturerid->bind_param("iii", $batchId, $subject_id, $departmentId);
$stmtLecturerid->execute();
$resultLecturerid = $stmtLecturerid->get_result();
$lecturer_id = $resultLecturerid->fetch_assoc()['lecturer_id'] ?? 'N/A';

// Fetch lecturer name from id if lecturer_id exists
$lecturer_name = 'N/A';
if ($lecturer_id !== 'N/A') {
    $queryLecturerName = "SELECT name FROM lecturer WHERE lecturer_id = ?";
    $stmtLecturerName = $conn->prepare($queryLecturerName);
    $stmtLecturerName->bind_param("i", $lecturer_id);
    $stmtLecturerName->execute();
    $resultLecturerName = $stmtLecturerName->get_result();
    $lecturer_name = $resultLecturerName->fetch_assoc()['name'] ?? 'N/A';
}

// Ensure that the table name variable is set correctly before using it in the query
$table_name = $conn->real_escape_string($table_name);

// Fetch total presents for the student in the specific subject
$queryTotalPresents = "SELECT COUNT(scanned_Date) AS total_presents, MIN(scanned_Date) AS start_date, MAX(scanned_Date) AS end_date
                       FROM $table_name 
                       WHERE batch_id = ? AND department_id = ? AND Subject_id = ? AND student_id = ?";

$stmtTotalPresents = $conn->prepare($queryTotalPresents);
$stmtTotalPresents->bind_param("iiis", $batchId, $departmentId, $subject_id, $student_id);
$stmtTotalPresents->execute();
$resultTotalPresents = $stmtTotalPresents->get_result();

// Fetching the results
$data = $resultTotalPresents->fetch_assoc();

$totalPresents = $data['total_presents'] ?? 0; // Default to 0 if no records found
$startDate = $data['start_date'] ?? null; // Get start date, can be null if no records found
$endDate = $data['end_date'] ?? null; // Get end date, can be null if no records found

// Calculate total absences
$totalAbsences = $total_lectures - $totalPresents;

// Calculate attendance percentage
$attPercentage = $total_lectures > 0 ? ($totalPresents / $total_lectures) * 100 : 0;
$attendancePercentage = round($attPercentage);


// Determine qualification for exam
$qualified = ($attendancePercentage >= 80) ? "Yes" : "No";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="../../css/style.css">
    <style>
        
       
        .info-button-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Align buttons and info at the top */
            width: 100%;
        }

        .button-section {
            margin-top: 100px;
            display: flex;
            flex-direction: row;
            gap: 10px; /* Space between buttons */
            align-items: flex-end; /* Align buttons to the right */
        }

        .button-section button {
            background-color: #007bff; /* Bootstrap primary color */
            font-size: 13px;
            color: white; /* Button text color */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth background color transition */
            line-height: 1.2; /* Adjust line height for better text spacing */
        }

        .button-section button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .report-info {  
            color: white;
            text-align: left; /* Align text to the left */
            font-size: 1.0em;
           
            padding: 1px; /* Add some padding */
            border-radius: 8px; /* Add rounded corners */
            display: block; /* Ensures the report info takes full width */
        }
        
        .flex-container {
            display: flex; /* Enable Flexbox on the container */
            justify-content: center; /* Center child containers */
            width: 100%; /* Full width of the viewport */
            padding: 20px; /* Padding around the container */
        }

        .container66 {
            max-width: 1200px; /* Maximum width */
            width: 100%; /* Full width up to max-width */
            margin-top: 80px; /* Space at the top */
            border-radius: 8px; /* Rounded corners */
            
            padding: 20px; /* Inner padding */
        }

        .attendance-cards {
            display: flex;
            flex-direction: column; /* Stack cards vertically */
            gap: 15px; /* Space between cards */
            margin-top: 20px; /* Margin above cards */
            align-items: center;
        }

        .card {
            background-color: white; /* Card background */
            padding: 15px; /* Inner padding */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Shadow effect */
            text-align: center; /* Center text */
            max-width: 300px; /* Set maximum width for cards */
            width: 100%; /* Ensure it takes the full width available */
        }

        .qualified-yes {
            color: green;
            font-weight: bold;
        }

        .qualified-no {
            color: red;
            font-weight: bold;
        }


    </style>
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
    <div class="flex-container">
        <div class="container66">
            
        <div class="info-button-container">
            <div class="report-info">
                <h2>Attendance Report</h2><br>
                <p><strong>Report Date:</strong> <?= htmlspecialchars(date('Y-m-d H:i:s')) ?></p>
                <p><strong>Report Date Range:</strong> <?= htmlspecialchars($startDate) ?> to <?= htmlspecialchars($endDate) ?></p>
                <p><strong>Batch Year:</strong> <?= htmlspecialchars($batch_year) ?></p>
                <p><strong>Subject Name:</strong> <?= htmlspecialchars($subject_name) ?></p>
                <p><strong>Subject Code:</strong> <?= htmlspecialchars($subject_code) ?></p>
                <p><strong>Lecturer Name:</strong> <?= htmlspecialchars($lecturer_name) ?></p>
                <p><strong>Total Lectures:</strong> <?= htmlspecialchars($total_lectures) ?></p>
                <p><strong>Department:</strong> <?= htmlspecialchars($department_name) ?></p>
                <p><strong>Student ID:</strong> <?= htmlspecialchars($student_id) ?></p>
                <p><strong>Student Name:</strong> <?= htmlspecialchars($student_name) ?></p>

            </div>
            <div class="button-section">
                <button id="prevPageBtn">Previous Page</button>
            </div>
        </div> <br>
            
        <div class="attendance-cards">
            <div class="card">
                <h4>Total Presents</h4>
                <p><?= htmlspecialchars($totalPresents) ?></p>
            </div>
            <div class="card">
                <h4>Total Absences</h4>
                <p><?= htmlspecialchars($totalAbsences) ?></p>
            </div>
            <div class="card">
                <h4>Attendance Percentage</h4>
                <p><?= htmlspecialchars($attendancePercentage) ?>%</p>
            </div>
            <div class="card <?= $qualified == 'Yes' ? 'qualified-yes' : 'qualified-no' ?>">
                <h4 style="color: black;">Qualified for Exam</h4>
                <p><?= htmlspecialchars($qualified) ?></p>
            </div>
        </div>
        <div style="margin-top: 20px; padding: 20px; background-color: #f0f8ff; border-radius: 10px; max-width: 300px; margin-left: auto; margin-right: auto;">
            <h3 style="text-align: center;">Attendance Overview</h3>
            <canvas id="attendanceChart" style="max-height: 300px; width: 100%;"></canvas>
        </div>

        </div>
    </div>

    
    <script src="../../js/script_2.js"></script>
    <script>
        document.getElementById("logoutBtn").addEventListener("click", function () {
            alert("You have been logged out!");
            window.location.href = "../logout.php";
        });
        
        // Add event listeners for buttons
        document.getElementById("prevPageBtn").addEventListener("click", function () {
            window.history.back(); // Go back to the previous page
        });

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            const attendanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Presents', 'Absences'],
                    datasets: [{
                        label: 'Attendance',
                        data: [<?= htmlspecialchars($totalPresents) ?>, <?= htmlspecialchars($totalAbsences) ?>],
                        backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>





</body>
</html>
