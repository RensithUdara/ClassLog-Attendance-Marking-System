<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/../db.php";

$sql = "SELECT * FROM lecturer
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}



$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE lecturer
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE lecturer_id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["lecturer_id"]);

$stmt->execute();

header("Location:Lecturer.html?stat=Password_updated._You_can_now_login.");
