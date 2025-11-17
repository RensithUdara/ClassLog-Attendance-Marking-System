<?php
session_start();
include '../db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

require 'vendor/autoload.php';

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
$topic = str_replace(' ', '_', $event['topic']); // Replace spaces with underscores for filename
$event_date = date('Y-m-d', strtotime($event['date'])); // Format date for filename
$venue = str_replace(' ', '_', $event['venue']); // Replace spaces with underscores for filename

$filename = "{$event_number}_{$topic}_{$event_date}_{$venue}.xlsx";

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add "Attendance Report" title
$sheet->setCellValue('A1', 'QR-Based Event Attendance Report');
$sheet->mergeCells('A1:D1'); // Adjust columns if necessary
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Add metadata (Report Info)
$sheet->setCellValue('A3', 'Report Date:')
      ->setCellValue('B3', date('Y-m-d H:i:s'))
      ->mergeCells('B3:C3');
$sheet->setCellValue('A4', 'Event Number:')
      ->setCellValue('B4', $event['Event_Number'])
      ->getStyle('B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); 
$sheet->setCellValue('A5', 'Topic:')
      ->setCellValue('B5', $event['topic']);
$sheet->setCellValue('A6', 'Event Date:')
      ->setCellValue('B6', $event['date']);
$sheet->setCellValue('A7', 'Venue:')
      ->setCellValue('B7', $event['venue']);
$sheet->setCellValue('A8', 'Audience:')
      ->setCellValue('B8', $event['audience']);

// Apply bold styling to metadata labels
$sheet->getStyle('A3:A8')->getFont()->setBold(true);

// Leave a blank line between metadata and table
$startRow = 11;

// Add Table Headers with Bold Style and Borders
$tableHeaders = ['Student ID', 'Student Name', 'Batch', 'Department'];
$column = 'A';
foreach ($tableHeaders as $header) {
    $sheet->setCellValue($column . $startRow, $header);
    $sheet->getStyle($column . $startRow)->getFont()->setBold(true);
    $sheet->getStyle($column . $startRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle($column . $startRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $column++;
}

// Add Table Data with Borders
$row = $startRow + 1;
foreach ($students as $student) {
    $sheet->setCellValue('A' . $row, $student['student_id']);
    $sheet->setCellValue('B' . $row, $student['student_name']);
    $sheet->setCellValue('C' . $row, $student['batch_year']);
    $sheet->setCellValue('D' . $row, $student['department']);

    // Apply borders for each cell in the row
    foreach (range('A', 'D') as $col) {
        $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }
    $row++;
}

// Auto-fit column widths
foreach (range('A', 'D') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Set headers to force download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header('Cache-Control: max-age=0');

// Write the file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
