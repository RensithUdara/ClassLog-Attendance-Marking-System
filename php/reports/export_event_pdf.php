<?php
require 'vendor/autoload.php'; // Include Dompdf autoloader

use Dompdf\Dompdf;
use Dompdf\Options;

// Start session to check if user is logged in
session_start(); // Make sure to start the session

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    echo json_encode(['error' => 'User not logged in.']);
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

// Check for filter parameters
$selectedDepartment = isset($_GET['department']) ? $_GET['department'] : '';
$selectedBatch = isset($_GET['batch']) ? $_GET['batch'] : '';

if ($selectedDepartment || $selectedBatch) {
    // Filter students based on selected department and batch
    $filteredStudents = [];
    foreach ($students as $student) {
        $departmentMatches = !$selectedDepartment || $student['department'] === $selectedDepartment;
        $batchMatches = !$selectedBatch || $student['batch_year'] === $selectedBatch;

        if ($departmentMatches && $batchMatches) {
            $filteredStudents[] = $student;
        }
    }
    $students = $filteredStudents; // Update students with filtered list
}

// Prepare metadata for filename
$event_number = $event['Event_Number'];
$filename = "{$event_number}.pdf";

// Initialize Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Generate HTML content for the PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
        }
        .report-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>QR-Based Event Attendance Report</h2><br>
    <div class="report-info">
        <strong>Report Date:</strong> ' . date('Y-m-d H:i:s') . '<br>
        <strong>Event Number:</strong> ' . $event['Event_Number'] . '<br>
        <strong>Topic:</strong> '. $event['topic'] . '<br>
        <strong>Event Date:</strong> ' . $event['date'] . '<br>
        <strong>Venue:</strong> ' . $event['venue'] . '<br>
        <strong>Audience:</strong> ' . $event['audience'] . '<br>
    </div><br>
    <table>
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Batch</th>
            <th>Department</th>
        </tr>';

// Table Data
foreach ($students as $data) {
    $html .= '
        <tr>
            <td>' . $data['student_id'] . '</td>
            <td>' . $data['student_name'] . '</td>
            <td>' . $data['batch_year'] . '</td>
            <td>' . $data['department'] . '</td>
        </tr>';
}

$html .= '
    </table>
</body>
</html>';

// Load HTML content into Dompdf
$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Get the PDF output
$pdfOutput = $dompdf->output();

// Clean the output buffer
ob_clean();

// Send headers to force download
header('Content-Type: application/pdf');
header("Content-Disposition: inline; filename=\"{$filename}\"");
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Expires: 0');

// Output the generated PDF to the browser
echo $pdfOutput;
?>
