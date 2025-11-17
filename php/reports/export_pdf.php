<?php
require 'vendor/autoload.php'; // Include Dompdf autoloader

use Dompdf\Dompdf;
use Dompdf\Options;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session to check if user is logged in
session_start(); // Make sure to start the session

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

// Check if report data is provided
if (!isset($_GET['report_data'])) {
    echo json_encode(['error' => 'No report data provided.']);
    exit();
}

$report_data = json_decode($_GET['report_data'], true);
if (empty($report_data['data'])) {
    echo json_encode(['error' => 'No data available to export.']);
    exit();
}

// Prepare metadata for filename
$report_type = $report_data['meta']['report_type'];
$batch_year = $report_data['meta']['batch_year'];
$department = $report_data['meta']['department_name'];
$subject_code = $report_data['meta']['subject_code'];
$date = date('Y-m-d');
$start_date = $report_data['meta']['start_date'];
$end_date = $report_data['meta']['end_date'];

if ($report_type == 'student') {
    $student_id = $report_data['data'][0]['student_id'];
    $filename = "{$student_id}_{$batch_year}_{$department}_{$subject_code}_{$date}.pdf";
} else {
    $filename = "{$batch_year}_{$department}_{$subject_code}_{$report_type}.pdf";
}

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
        .qualified-yes {
            color: green;
        }
        .qualified-no {
            color: red;
        }
    </style>
</head>
<body>
    <h2>QR-Based Attendance Report</h2><br>
    <div class="report-info">
        <strong>Report Date:</strong> ' . date('Y-m-d H:i:s') . '<br>
        <strong>Report Date Range:</strong> ' . $start_date . ' to ' . $end_date . '<br>
        <strong>Report Type:</strong> '. $report_type . '<br>
        <strong>Batch Year:</strong> ' . $batch_year . '<br>
        <strong>Subject Name:</strong> ' . $report_data['meta']['subject_name'] . '<br>
        <strong>Subject Code:</strong> ' . $subject_code . '<br>
        <strong>Lecturer Name:</strong> ' . $report_data['meta']['lecturer_name'] . '<br>
        <strong>Total Lectures:</strong> ' . $report_data['meta']['total_lectures'] . '<br>
        <strong>Depertment:</strong> ' . $department . '
    </div><br>
    <table>
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Total Presents</th>
            <th>Total Absences</th>
            <th>Attendance %</th>
            <th>Qualified</th>
        </tr>';

// Table Data
foreach ($report_data['data'] as $data) {
    $qualifiedClass = ($data['qualified'] === 'No') ? 'qualified-no' : 'qualified-yes';
    $html .= '
        <tr>
            <td>' . $data['student_id'] . '</td>
            <td>' . $data['student_name'] . '</td>
            <td>' . $data['total_presents'] . '</td>
            <td>' . $data['total_absences'] . '</td>
            <td>' . $data['percentage'] . '%</td>
            <td class="' . $qualifiedClass . '">' . $data['qualified'] . '</td>
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
