<?php
session_start();
include '../db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;

require 'vendor/autoload.php';

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
    $filename = "{$student_id}_{$batch_year}_{$department}_{$subject_code}_{$date}.xlsx";
} else {
    $filename = "{$batch_year}_{$department}_{$subject_code}_{$report_type}.xlsx";
}

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add "Attendance Report" title
$sheet->setCellValue('A1', 'QR-Based Attendance Report');
$sheet->mergeCells('A1:F1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Add metadata (Report Info) with bold style for labels (A3:A9)
$sheet->setCellValue('A3', 'Report Date:');
$sheet->setCellValue('B3', date('Y-m-d H:i:s'));
$sheet->mergeCells('B3:C3');

$sheet->setCellValue('A4', 'Report Type:');
$sheet->setCellValue('B4', $report_data['meta']['report_type']);

$sheet->setCellValue('A5', 'Report Date Range:');
$sheet->setCellValue('B5', $report_data['meta']['start_date'] . ' to ' . $report_data['meta']['end_date']);
$sheet->mergeCells('B5:C5');

$sheet->setCellValue('A6', 'Batch Year:');
$sheet->setCellValue('B6', $report_data['meta']['batch_year']);

$sheet->setCellValue('A7', 'Subject Name:');
$sheet->setCellValue('B7', $report_data['meta']['subject_name']);
$sheet->mergeCells('B7:D7'); // Merge cells for subject name

$sheet->setCellValue('A8', 'Subject Code:');
$sheet->setCellValue('B8', $report_data['meta']['subject_code']);

$sheet->setCellValue('A9', 'Lecturer Name:');
$sheet->setCellValue('B9', $report_data['meta']['lecturer_name']);

$sheet->setCellValue('A10', 'Total Lectures:');
$sheet->setCellValue('B10', $report_data['meta']['total_lectures']);
$sheet->getStyle('B10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Left-align B9 cell data

$sheet->setCellValue('A11', 'Department:');
$sheet->setCellValue('B11', $report_data['meta']['department_name']);

// Apply bold styling to metadata labels in A3:A9
$sheet->getStyle('A3:A11')->getFont()->setBold(true);

// Leave a blank line between metadata and table
$startRow = 14;

// Add Table Headers with Bold Style and Borders
$tableHeaders = ['Student ID', 'Student Name', 'Total Presents', 'Total Absences', 'Attendance Percentage', 'Qualified for Exam'];
$column = 'A';
foreach ($tableHeaders as $header) {
    $sheet->setCellValue($column . $startRow, $header);
    $sheet->getStyle($column . $startRow)->getFont()->setBold(true);
    $sheet->getStyle($column . $startRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle($column . $startRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $column++;
}

// Add Table Data with Borders and Conditional Formatting for "Qualified for Exam" column
$row = $startRow + 1;
foreach ($report_data['data'] as $data) {
    $sheet->setCellValue('A' . $row, $data['student_id']);
    $sheet->setCellValue('B' . $row, $data['student_name']);
    $sheet->setCellValue('C' . $row, $data['total_presents']);
    $sheet->setCellValue('D' . $row, $data['total_absences']);
    $sheet->setCellValue('E' . $row, $data['percentage'] . '%');

    // Set qualified status with color coding
    $qualifiedCell = 'F' . $row;
    $sheet->setCellValue($qualifiedCell, $data['qualified']);
    if ($data['qualified'] === 'No') {
        $sheet->getStyle($qualifiedCell)->getFont()->getColor()->setARGB(Color::COLOR_RED);
    } elseif ($data['qualified'] === 'Yes') {
        $sheet->getStyle($qualifiedCell)->getFont()->getColor()->setARGB(Color::COLOR_GREEN);
    }

    // Apply borders for each cell
    foreach (range('A', 'F') as $col) {
        $sheet->getStyle($col . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }
    $row++;
}

// Set fixed column widths
$sheet->getColumnDimension('A')->setWidth(17); // Student ID
$sheet->getColumnDimension('B')->setWidth(25); // Student Name
$sheet->getColumnDimension('C')->setWidth(13); // Total Presents
$sheet->getColumnDimension('D')->setWidth(13); // Total Absences
$sheet->getColumnDimension('E')->setWidth(20.11); // Attendance Percentage
$sheet->getColumnDimension('F')->setWidth(16); // Qualified for Exam

// Set headers to force download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header('Cache-Control: max-age=0');

// Write the file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
