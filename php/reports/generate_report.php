<?php
// Include database connection
session_start();
include '../db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    echo "Error: User not logged in.";
    exit();
}


// Check if required fields are present
$batch_id = isset($_POST['batch_id']) ? $_POST['batch_id'] : null;
$department_id = isset($_POST['department_id']) ? $_POST['department_id'] : null;
$subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : null;
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : null;
$lecturer_name = $_SESSION['user_name'];

if (!$batch_id || !$department_id || !$subject_id || !$report_type) {
    echo json_encode(['error' => 'Missing required fields.']);
    exit;
}

// Fetch the subject details
$subject_query = $conn->query("SELECT subject_code, subject_name, total_lectures, table_name FROM subjects WHERE subject_id = '$subject_id'");
if (!$subject_query) {
    echo json_encode(["error" => "Database error: " . $conn->error]);
    exit();
}

$subject_data = $subject_query->fetch_assoc();
$subject_code = $subject_data['subject_code'];
$subject_name = $subject_data['subject_name'];
$table_name = $subject_data['table_name'];
$total_lectures = $subject_data['total_lectures']; // Get total lectures from subject data


// Initialize variables for graph data
$report_data = [];
$meta_data = [
    'subject_name' => $subject_name,
    'subject_code' => $subject_code,
    'lecturer_name' => $lecturer_name,
    'batch_year' => '', // This should ideally be fetched from your batch table
    'department_name' => '', // Fetch department name if needed
    'start_date' => '', // Initialize as empty by default
    'end_date' => '',
    'total_lectures' => $total_lectures, // Add total lectures to metadata
    'report_type' => $report_type 
];

// Fetch the batch year information
$batch_query = $conn->query("SELECT year FROM batch WHERE batch_id = '$batch_id'");
if (!$batch_query) {
    echo json_encode(["error" => "Database error: " . $conn->error]);
    exit();
}
if ($batch_row = $batch_query->fetch_assoc()) {
    $meta_data['batch_year'] = $batch_row['year'];
    $student_table = $batch_row['year']; // Assume this is the table name for the batch
} else {
    $meta_data['batch_year'] = 'Unknown';
    echo json_encode(["error" => "Batch not found"]);
    exit();
}



// Fetch the department name if needed
$department_query = $conn->query("SELECT department_name FROM department WHERE department_id = '$department_id'");
if (!$department_query) {
    echo json_encode(["error" => "Database error: " . $conn->error]);
    exit();
}
if ($department_row = $department_query->fetch_assoc()) {
    $meta_data['department_name'] = $department_row['department_name'];
}

// Common code to fetch start_date and end_date for semester and student report types
$time_period_query = $conn->query("SELECT MIN(scanned_Date) AS start_date, MAX(scanned_Date) AS end_date 
                                   FROM $table_name 
                                   WHERE batch_id = '$batch_id' AND department_id = '$department_id'");
if ($time_period_result = $time_period_query->fetch_assoc()) {
    $meta_data['start_date'] = $time_period_result['start_date'];
    $meta_data['end_date'] = $time_period_result['end_date'];
} else {
    $meta_data['start_date'] = '';
    $meta_data['end_date'] = '';
}



// Prepare additional fields based on the report type
switch ($report_type) {
    case 'semester':
        $query = "SELECT student_id, COUNT(*) AS total_presents 
                  FROM $table_name 
                  WHERE batch_id = '$batch_id' AND department_id = '$department_id' 
                  GROUP BY student_id";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            $student_id = $row['student_id'];
            $total_presents = $row['total_presents'];
            $total_absences = $total_lectures - $total_presents;
            $percentage = ($total_lectures > 0) ? ($total_presents / $total_lectures) * 100 : 0;
            $qualified = ($percentage >= 80) ? 'Yes' : 'No';

            // Fetch the student name
            $student_name_query = $conn->query("SELECT name FROM $student_table WHERE student_id = '$student_id'");
            $student_name_row = $student_name_query->fetch_assoc();
            $student_name = $student_name_row ? $student_name_row['name'] : 'Unknown';

            $report_data[] = [
                'student_id' => $student_id,
                'student_name' => $student_name, // Add student name to report data
                'total_presents' => $total_presents,
                'total_absences' => $total_absences,
                'percentage' => round($percentage),
                'qualified' => $qualified,
            ];
        }
        break;

    case 'lecture':
        $lecture_date = $_POST['scanned_date']; // Get selected date from user input
        $meta_data['start_date'] = $lecture_date; // Set start and end as the same date for a single lecture
        $meta_data['end_date'] = $lecture_date;
        $query = "SELECT student_id, COUNT(*) AS total_presents 
                  FROM $table_name 
                  WHERE scanned_Date = '$lecture_date' AND batch_id = '$batch_id' AND department_id = '$department_id' 
                  GROUP BY student_id";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            $student_id = $row['student_id'];
            $total_presents = $row['total_presents'];
            // Calculate absences if you have total lectures for that date
            $total_absences = 1 - $total_presents; // For simplicity; adjust as per your requirements
            $percentage = ($total_presents > 0) ? ($total_presents / 1) * 100 : 0; // Assuming 1 lecture
            $qualified = ($percentage >= 80) ? 'Yes' : 'No';

            // Fetch the student name
            $student_name_query = $conn->query("SELECT name FROM $student_table WHERE student_id = '$student_id'");
            $student_name_row = $student_name_query->fetch_assoc();
            $student_name = $student_name_row ? $student_name_row['name'] : 'Unknown';

            $report_data[] = [
                'student_id' => $student_id,
                'student_name' => $student_name, // Add student name to report data
                'total_presents' => $total_presents,
                'total_absences' => "-",
                'percentage' => "Not Available",
                'qualified' => "Not Available",
            ];
        }
        break;

    case 'time_period':
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $meta_data['start_date'] = $start_date;
        $meta_data['end_date'] = $end_date;
        $query = "SELECT student_id, COUNT(*) AS total_presents 
                  FROM $table_name 
                  WHERE scanned_Date BETWEEN '$start_date' AND '$end_date' AND batch_id = '$batch_id' AND department_id = '$department_id' 
                  GROUP BY student_id";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            $student_id = $row['student_id'];
            $total_presents = $row['total_presents'];
            // Total absences would depend on the total lectures in that period
            $total_absences = 0; // Adjust based on your logic
            $percentage = ($total_presents > 0) ? ($total_presents / ($total_presents + $total_absences)) * 100 : 0;
            $qualified = ($percentage >= 80) ? 'Yes' : 'No';

            // Fetch the student name
            $student_name_query = $conn->query("SELECT name FROM $student_table WHERE student_id = '$student_id'");
            $student_name_row = $student_name_query->fetch_assoc();
            $student_name = $student_name_row ? $student_name_row['name'] : 'Unknown';

            $report_data[] = [
                'student_id' => $student_id,
                'student_name' => $student_name, // Add student name to report data
                'total_presents' => $total_presents,
                'total_absences' => "-",
                'percentage' => "Not Available",
                'qualified' => "Not Available",
            ];
        }
        break;

    case 'student':
        $student_id = $_POST['student_id']; // Get selected student ID
        
        // Fetch total presents for the student
        $query = "SELECT COUNT(*) AS total_presents 
                FROM $table_name 
                WHERE student_id = ? AND batch_id = ? AND department_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $student_id, $batch_id, $department_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $total_presents = $row['total_presents'];
            // Calculate absences and percentage
            $total_absences = $total_lectures - $total_presents; // Calculate absences based on total lectures
            $percentage = ($total_lectures > 0) ? ($total_presents / $total_lectures) * 100 : 0; // Calculate percentage
            
            $qualified = ($percentage >= 80) ? 'Yes' : 'No';

            // Fetch the student name
            $student_name_query = $conn->query("SELECT name FROM $student_table WHERE student_id = '$student_id'");
            $student_name_row = $student_name_query->fetch_assoc();
            $student_name = $student_name_row ? $student_name_row['name'] : 'student is not exist';

            $report_data[] = [
                'student_id' => $student_id,
                'student_name' => $student_name, // Add student name to report data
                'total_presents' => $total_presents,
                'total_absences' => $total_absences,
                'percentage' => round($percentage),
                'qualified' => $qualified,
            ];
        }
        break;

    case 'event':
        $event_number = $_POST['event_number']; // Get event number
        // Adjust this query based on your event table structure
        // Example: SELECT * FROM event_attendance WHERE event_number = '$event_number'
        // ... Implement your logic here ...
        break;

    default:
        echo "Invalid report type.";
        exit();
}

// Return or display the report data
header('Content-Type: application/json');
$response = [
    'meta' => $meta_data,
    'data' => $report_data,
];
echo json_encode($response);
exit();

?>
