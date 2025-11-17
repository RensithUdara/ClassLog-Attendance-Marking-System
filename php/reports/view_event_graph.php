<?php
session_start();
include '../db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    echo "Error: User not logged in.";
    exit();
}

// Retrieve event data from the session
$eventData = $_SESSION['event_data'] ?? null;

if (!$eventData) {
    echo "Error: No event data available.";
    exit();
}

// Event details
$event = $eventData['event'];
$students = $eventData['students'];

// Fetch departments and batches for filtering
$departmentsQuery = "SELECT department_id, department_name FROM department";
$departmentsResult = $conn->query($departmentsQuery);
$departments = $departmentsResult->fetch_all(MYSQLI_ASSOC);

$batchesQuery = "SELECT batch_id, year FROM batch";
$batchesResult = $conn->query($batchesQuery);
$batches = $batchesResult->fetch_all(MYSQLI_ASSOC);

// Handle sorting
$selectedDepartment = isset($_GET['department']) ? $_GET['department'] : '';
$selectedBatch = isset($_GET['batch']) ? $_GET['batch'] : '';

if ($selectedDepartment || $selectedBatch) {
    $filteredStudents = [];

    foreach ($students as $student) {
        // Check if the selected department matches and if the selected batch matches
        $departmentMatches = !$selectedDepartment || $student['department'] === $selectedDepartment;
        $batchMatches = !$selectedBatch || $student['batch_year'] === $selectedBatch;

        // Include student if both conditions are met (or if no filter is selected)
        if ($departmentMatches && $batchMatches) {
            $filteredStudents[] = $student;
        }
    }
    $students = $filteredStudents;
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
    <style>
        .info-button-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
        }

        .button-section {
            margin-top: 100px;
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .button-section button {
            background-color: #007bff;
            font-size: 13px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            line-height: 1.2;
        }

        .button-section button:hover {
            background-color: #0056b3;
        }

        .report-info {
            color: white;
            text-align: left;
            font-size: 1.0em;
            padding: 1px;
            border-radius: 8px;
            display: block;
        }

        .flex-container {
            display: flex;
            justify-content: center;
            width: 100%;
            padding: 20px;
        }

        .container66 {
            max-width: 1200px;
            width: 100%;
            margin-top: 70px;
            border-radius: 8px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        th, td {
            padding: 10px;
            color: black;
            border: 1px solid #ccc;
            text-align: center;
        }
        
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .filter-form {
            margin: 20px 0;
        }

        .filter-form select {
            padding: 10px;
            margin-right: 10px;
        }

        .filter-form button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #0056b3;
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
                        <span class="username"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <div class="popup-info">
                            <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>                       
                            <p>Department: <?php echo htmlspecialchars($_SESSION['department_name']); ?></p>
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
    <div class="flex-container">
        <div class="container66">
            <div class="info-button-container">
                <div class="report-info">
                    <h2>QR-Based Event Attendance Report</h2><br>
                    <p><strong>Report Date:</strong> <?= htmlspecialchars(date('Y-m-d H:i:s')) ?></p>
                    <p><strong>Event Number:</strong> <?= htmlspecialchars($event['Event_Number']) ?></p>
                    <p><strong>Topic:</strong> <?= htmlspecialchars($event['topic']) ?></p>
                    <p><strong>Event Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                    <p><strong>Venue:</strong> <?= htmlspecialchars($event['venue']) ?></p>
                    <p><strong>Audience:</strong> <?= htmlspecialchars($event['audience']) ?></p>

                    <!-- Filter Form -->
                    <div class="filter-form">
                        <form method="GET" action="">
                            <select name="department">
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $department): ?>
                                    <option value="<?= htmlspecialchars($department['department_name']) ?>" <?= ($selectedDepartment === $department['department_name']) ? 'selected' : '' ?>><?= htmlspecialchars($department['department_name']) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <select name="batch">
                                <option value="">Select Batch</option>
                                <?php foreach ($batches as $batch): ?>
                                    <option value="<?= htmlspecialchars($batch['year']) ?>" <?= ($selectedBatch === $batch['year']) ? 'selected' : '' ?>><?= htmlspecialchars($batch['year']) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" style="max-width:80px; padding: 1px;">Filter</button>
                        </form>
                    </div>

                </div>
                <div class="button-section">
                    <button id="prevPageBtn">Previous Page</button>
                    <button id="exportExcelBtn">Export to Excel</button>
                    <button id="exportPdfBtn">Export to PDF</button>
                </div>
            </div> 
            
            <div style="overflow-x: auto;">
                <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Batch</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['student_id']) ?></td>
                            <td><?= htmlspecialchars($student['student_name']) ?></td>
                            <td><?= htmlspecialchars($student['batch_year']) ?></td>
                            <td><?= htmlspecialchars($student['department']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No attendance data available for this report.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="../../js/script_2.js"></script>
    <script>
        document.getElementById("logoutBtn").addEventListener("click", function () {
            alert("You have been logged out!");
            window.location.href = "../logout.php";
        });
        
        document.getElementById("prevPageBtn").addEventListener("click", function () {
            window.history.back();
        });
        
        document.getElementById("exportExcelBtn").addEventListener("click", function () {
            const department = document.querySelector("select[name='department']").value;
            const batch = document.querySelector("select[name='batch']").value;
            const exportUrl = `export_event_excel.php?event_id=<?= htmlspecialchars($event['event_id']) ?>&department=${encodeURIComponent(department)}&batch=${encodeURIComponent(batch)}`;
            window.location.href = exportUrl; // Redirect to the export URL with filters
        });

        document.getElementById("exportPdfBtn").addEventListener("click", function () {
            const department = document.querySelector("select[name='department']").value;
            const batch = document.querySelector("select[name='batch']").value;
            const exportUrl = `export_event_pdf.php?event_id=<?= htmlspecialchars($event['event_id']) ?>&department=${encodeURIComponent(department)}&batch=${encodeURIComponent(batch)}`;
            window.location.href = exportUrl; // Redirect to the export URL with filters
        });
    </script>
</html>
