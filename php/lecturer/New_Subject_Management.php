<?php
session_start();
require_once('../../config/database.php');
require_once('../../config/language.php');

// Check if lecturer is logged in
if (!isset($_SESSION['user_name'])) {
    header('Location: ../../index.html?error=notloggedin');
    exit();
}

// Handle QR code generation for new subject
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_qr'])) {
    $subject_id = 12; // New Subject ID
    $subject_code = 'NS 1001';
    $date = $_POST['date'];
    $time = $_POST['time'];
    $batch_id = $_POST['batch_id'];
    $department_id = $_POST['department_id'];
    
    // Generate QR code data
    $qr_data = json_encode([
        'subject_id' => $subject_id,
        'subject_code' => $subject_code,
        'date' => $date,
        'time' => $time,
        'batch_id' => $batch_id,
        'department_id' => $department_id,
        'lecturer_id' => $_SESSION['lecturer_id'],
        'timestamp' => time()
    ]);
    
    // Store in session for QR display
    $_SESSION['qr_data'] = $qr_data;
    $_SESSION['qr_subject'] = 'New Subject - Introduction to Technology';
    $_SESSION['qr_date'] = $date;
    $_SESSION['qr_time'] = $time;
}

// Handle attendance marking via QR scan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mark_attendance'])) {
    $qr_data = json_decode($_POST['qr_data'], true);
    $student_id = $_POST['student_id'];
    
    if ($qr_data && $student_id) {
        try {
            // Insert attendance record
            $stmt = $pdo->prepare("
                INSERT INTO new_subject_attendance 
                (scanned_Date, scanned_Time, Subject_id, Subject_Code, student_id, batch_id, department_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            $result = $stmt->execute([
                $qr_data['date'],
                $qr_data['time'],
                $qr_data['subject_id'],
                $qr_data['subject_code'],
                $student_id,
                $qr_data['batch_id'],
                $qr_data['department_id']
            ]);
            
            if ($result) {
                $success_message = "Attendance marked successfully for {$qr_data['subject_code']}!";
            } else {
                $error_message = "Failed to mark attendance. Please try again.";
            }
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Subject Management - ClassLog</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="../lecturer/Lecturer_Dashboard.php" class="logo">
                <img src="../../img/logo.png" alt="logo">
                <h2>New Subject Management</h2>
            </a>
            
            <div class="navbar-right">
                <ul class="links">
                    <div class="profile">
                        <img src="../../img/user.png" class="profile-photo">
                        <span class="username"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </div>
                    <span class="close-btn material-symbols-rounded">close</span>
                    <li><a href="../lecturer/Lecturer_Dashboard.php">Dashboard</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
                <button class="logout-btn" id="logoutBtn">LOGOUT</button>
            </div>
        </nav>
    </header>
    
    <main>
        <div class="container">
            <h1>New Subject - Introduction to Technology (NS 1001)</h1>
            
            <?php if (isset($success_message)): ?>
                <div class="success-message">
                    <span class="material-symbols-rounded">check_circle</span>
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="error-message">
                    <span class="material-symbols-rounded">error</span>
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <div class="tabs">
                <button class="tab-button active" onclick="openTab(event, 'generate-qr')">Generate QR Code</button>
                <button class="tab-button" onclick="openTab(event, 'mark-attendance')">Mark Attendance</button>
                <button class="tab-button" onclick="openTab(event, 'view-attendance')">View Attendance</button>
            </div>
            
            <!-- Generate QR Code Tab -->
            <div id="generate-qr" class="tab-content active">
                <h2>Generate QR Code for New Subject</h2>
                <form method="POST" class="qr-form">
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="time">Time:</label>
                        <input type="time" id="time" name="time" value="<?php echo date('H:i'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="batch_id">Batch:</label>
                        <select id="batch_id" name="batch_id" required>
                            <option value="1">2019_20</option>
                            <option value="2">2020_21</option>
                            <option value="3">2021_22</option>
                            <option value="4" selected>2022_23</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="department_id">Department:</label>
                        <select id="department_id" name="department_id" required>
                            <option value="1">IAT</option>
                            <option value="2">ICT</option>
                            <option value="3">AT</option>
                            <option value="4">ET</option>
                        </select>
                    </div>
                    
                    <button type="submit" name="generate_qr" class="btn-primary">
                        <span class="material-symbols-rounded">qr_code</span>
                        Generate QR Code
                    </button>
                </form>
                
                <?php if (isset($_SESSION['qr_data'])): ?>
                    <div class="qr-display">
                        <h3>QR Code Generated</h3>
                        <div class="qr-info">
                            <p><strong>Subject:</strong> <?php echo $_SESSION['qr_subject']; ?></p>
                            <p><strong>Date:</strong> <?php echo $_SESSION['qr_date']; ?></p>
                            <p><strong>Time:</strong> <?php echo $_SESSION['qr_time']; ?></p>
                        </div>
                        <div id="qrcode"></div>
                        <p class="qr-instruction">Show this QR code to students to mark their attendance</p>
                    </div>
                    
                    <script>
                        // Generate QR code
                        const qrData = '<?php echo addslashes($_SESSION['qr_data']); ?>';
                        QRCode.toCanvas(document.getElementById('qrcode'), qrData, {
                            width: 300,
                            height: 300,
                            colorDark: '#000000',
                            colorLight: '#FFFFFF',
                            correctLevel: QRCode.CorrectLevel.H
                        });\n                    </script>
                    
                    <?php 
                    // Clear QR data from session after display
                    unset($_SESSION['qr_data'], $_SESSION['qr_subject'], $_SESSION['qr_date'], $_SESSION['qr_time']);
                    ?>
                <?php endif; ?>
            </div>
            
            <!-- Mark Attendance Tab -->
            <div id="mark-attendance" class="tab-content">
                <h2>Manual Attendance Marking</h2>
                <form method="POST" class="attendance-form">
                    <div class="form-group">
                        <label for="student_id">Student ID:</label>
                        <input type="text" id="student_id" name="student_id" placeholder="e.g., 2022t01101" required>
                    </div>
                    
                    <input type="hidden" name="qr_data" value='{"subject_id":12,"subject_code":"NS 1001","date":"<?php echo date('Y-m-d'); ?>","time":"<?php echo date('H:i'); ?>","batch_id":4,"department_id":1}'>
                    
                    <button type="submit" name="mark_attendance" class="btn-primary">
                        <span class="material-symbols-rounded">check</span>
                        Mark Attendance
                    </button>
                </form>
            </div>
            
            <!-- View Attendance Tab -->
            <div id="view-attendance" class="tab-content">
                <h2>Attendance Records</h2>
                <div class="attendance-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $pdo->prepare("
                                    SELECT nsa.scanned_Date, nsa.scanned_Time, nsa.student_id, 
                                           s.name as student_name, d.department_name
                                    FROM new_subject_attendance nsa
                                    LEFT JOIN `2022_23` s ON nsa.student_id = s.student_id
                                    LEFT JOIN department d ON nsa.department_id = d.department_id
                                    ORDER BY nsa.scanned_Date DESC, nsa.scanned_Time DESC
                                    LIMIT 50
                                ");
                                $stmt->execute();
                                $records = $stmt->fetchAll();
                                
                                if ($records) {
                                    foreach ($records as $record) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($record['scanned_Date']) . "</td>";
                                        echo "<td>" . htmlspecialchars($record['scanned_Time']) . "</td>";
                                        echo "<td>" . htmlspecialchars($record['student_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($record['student_name'] ?? 'N/A') . "</td>";
                                        echo "<td>" . htmlspecialchars($record['department_name'] ?? 'N/A') . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No attendance records found</td></tr>";
                                }
                            } catch (PDOException $e) {
                                echo "<tr><td colspan='5'>Error loading attendance records</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <script src="../../js/script_2.js"></script>
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tab-button");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }
        
        document.getElementById("logoutBtn").addEventListener("click", function () {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "../logout.php";
            }
        });
    </script>
    
    <style>
        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }
        
        .tab-button {
            background: none;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .tab-button:hover, .tab-button.active {
            background-color: #f0f8ff;
            border-bottom-color: #007bff;
            color: #007bff;
        }
        
        .tab-content {
            display: none;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .tab-content.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
        }
        
        .qr-display {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .qr-info {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .qr-instruction {
            margin-top: 15px;
            font-style: italic;
            color: #666;
        }
        
        .attendance-table {
            overflow-x: auto;
        }
        
        .attendance-table table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .attendance-table th, .attendance-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .attendance-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .success-message, .error-message {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</body>
</html>