<?php

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

require_once '../db.php';

$sql = "SHOW TABLES LIKE '20%'";
$result = $conn->query($sql);

$user = null;
$tableWithUser = null;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_array()) {
        $table = $row[0];
        $query = "SELECT * FROM $table WHERE reset_token_hash = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $token_hash);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user !== null) {
            $tableWithUser = $table;
            break;
        }

        $stmt->close();
    }
}

if ($user === null) {
    die("Token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE $tableWithUser
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE student_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $password_hash, $user["student_id"]);
$stmt->execute();

header("Location: Student.php?stat=Password_updated._You_can_now_login.");
exit();

?>
