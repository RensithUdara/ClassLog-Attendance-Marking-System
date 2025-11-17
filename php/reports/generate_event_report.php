<?php
session_start();
include '../db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    echo json_encode(['status' => 'error', 'message' => 'Error: User not logged in.']);
    exit();
}

// Fetch the event number from POST request
$eventNumber = $_POST['event_id']; // Assuming you're passing this via POST
$query = "SELECT * FROM events WHERE Event_Number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $eventNumber);
$stmt->execute();
$eventResult = $stmt->get_result();

if ($eventResult->num_rows > 0) {
    $event = $eventResult->fetch_assoc();
    $eventAttendanceQuery = "
        SELECT ea.student_id, ea.batch_id, ea.department_id 
        FROM events_attendance ea 
        WHERE ea.Event_Number = ?";

    $attendanceStmt = $conn->prepare($eventAttendanceQuery);
    $attendanceStmt->bind_param("s", $event['Event_Number']);
    $attendanceStmt->execute();
    $attendanceResult = $attendanceStmt->get_result();

    $studentsData = [];

    while ($attendance = $attendanceResult->fetch_assoc()) {
        // Fetch batch year
        $batchQuery = "SELECT year FROM batch WHERE batch_id = ?";
        $batchStmt = $conn->prepare($batchQuery);
        $batchStmt->bind_param("i", $attendance['batch_id']);
        $batchStmt->execute();
        $batchResult = $batchStmt->get_result();
        $batchYear = $batchResult->fetch_assoc()['year'] ?? '';

        // Fetch department name
        $departmentQuery = "SELECT department_name FROM department WHERE department_id = ?";
        $departmentStmt = $conn->prepare($departmentQuery);
        $departmentStmt->bind_param("i", $attendance['department_id']);
        $departmentStmt->execute();
        $departmentResult = $departmentStmt->get_result();
        $departmentName = $departmentResult->fetch_assoc()['department_name'] ?? '';

        // Fetch student name based on batch year table
        $studentTable = strtolower($batchYear); // Assuming your table names are based on the batch year
        $studentNameQuery = "SELECT name FROM $studentTable WHERE student_id = ?";
        $studentStmt = $conn->prepare($studentNameQuery);
        $studentStmt->bind_param("i", $attendance['student_id']);
        $studentStmt->execute();
        $studentResult = $studentStmt->get_result();
        $studentName = $studentResult->fetch_assoc()['name'] ?? '';

        $studentsData[] = [
            'student_id' => $attendance['student_id'],
            'student_name' => $studentName,
            'batch_year' => $batchYear,
            'department' => $departmentName
        ];
    }

    // Store event data in session
    $_SESSION['event_data'] = [
        'event' => $event,
        'students' => $studentsData
    ];

    // Send success response
    echo json_encode(['status' => 'success', 'data' => $_SESSION['event_data']]);
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: Event not found.']);
}
?>
