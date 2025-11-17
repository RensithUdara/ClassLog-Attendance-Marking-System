<?php
// Include database connection and session handling
session_start();
include '../db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    echo "Error: User not logged in.";
    exit();
}

// Fetch report data from the JSON output of generate_report.php
// Assuming that the data is sent via an AJAX request to this page
if (!isset($_GET['report_data'])) {
    echo json_encode(['error' => 'No report data provided.']);
    exit();
}

$report_data = json_decode($_GET['report_data'], true);

// Check if the report data was fetched successfully
if (isset($report_data['error'])) {
    echo json_encode(['error' => $report_data['error']]);
    exit();
}

// Prepare metadata for display
$meta_data = $report_data['meta'];
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
            margin-top: 70px; /* Space at the top */
            border-radius: 8px; /* Rounded corners */
            
            padding: 20px; /* Inner padding */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white; /* Set table background color */
            border-radius: 8px; /* Add rounded corners */
            overflow: hidden; /* Ensure borders are rounded */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
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
        
        .qualified-yes {
            color: green;
            font-weight: bold;
        }
        
        .qualified-no {
            color: red;
            font-weight: bold;
        }
        .loading-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px;
            border-radius: 5px;
            z-index: 1000; /* Ensure it is on top */
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
                            <p>Lecturer ID: <?php echo htmlspecialchars($_SESSION['lecturer_id']); ?></p>                         
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
                <h2>Attendance Report</h2><br>
                <p><strong>Report Date:</strong> <?= htmlspecialchars(date('Y-m-d H:i:s')) ?></p>
                <?php if (!empty($meta_data['start_date']) && !empty($meta_data['end_date'])): ?>
                    <p><strong>Report Date Range:</strong> <?= htmlspecialchars($meta_data['start_date']) ?> to <?= htmlspecialchars($meta_data['end_date']) ?></p>
                <?php endif; ?>
                <p><strong>Batch Year:</strong> <?= htmlspecialchars($meta_data['batch_year']) ?></p>
                <p><strong>Subject Name:</strong> <?= htmlspecialchars($meta_data['subject_name']) ?></p>
                <p><strong>Subject Code:</strong> <?= htmlspecialchars($meta_data['subject_code']) ?></p>
                <p><strong>Lecturer Name:</strong> <?= htmlspecialchars($meta_data['lecturer_name']) ?></p>
                <p><strong>Total Lectures:</strong> <?= htmlspecialchars($meta_data['total_lectures']) ?></p>
                <p><strong>Department:</strong> <?= htmlspecialchars($meta_data['department_name']) ?></p>
            </div>
            <div class="button-section">
                <button id="prevPageBtn">Previous Page</button>
                <button id="exportExcelBtn">Export to Excel</button>
                <button id="exportPdfBtn">Export to PDF</button>
            </div>
        </div> <br><br>
            
            <div style="overflow-x: auto;">
                <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Total Presents</th>
                        <th>Total Absences</th>
                        <th>Attendance Percentage</th>
                        <th>Qualified for Exam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($report_data['data'])): ?>
                        <?php foreach ($report_data['data'] as $data): ?>
                        <tr>
                            <td><?= htmlspecialchars($data['student_id']) ?></td>
                            <td><?= htmlspecialchars($data['student_name']) ?></td>
                            <td><?= htmlspecialchars($data['total_presents']) ?></td>
                            <td><?= htmlspecialchars($data['total_absences']) ?></td>
                            <td><?= htmlspecialchars($data['percentage']) ?>%</td>
                            <td class="<?= $data['qualified'] == 'Yes' ? 'qualified-yes' : 'qualified-no' ?>">
                                <?= htmlspecialchars($data['qualified']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No attendance data available for this report.</td>
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
        
        // Add event listeners for buttons
        document.getElementById("prevPageBtn").addEventListener("click", function () {
            window.history.back(); // Go back to the previous page
        });

        document.getElementById("exportExcelBtn").addEventListener("click", function () {
            window.location.href = 'export_excel.php?report_data=' + encodeURIComponent(JSON.stringify(<?php echo json_encode($report_data); ?>));
        });

        document.getElementById("exportPdfBtn").addEventListener("click", function () {
            window.location.href = 'export_pdf.php?report_data=' + encodeURIComponent(JSON.stringify(<?php echo json_encode($report_data); ?>));
        });
    </script>

</body>
</html>
