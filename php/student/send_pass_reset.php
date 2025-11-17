<?php

$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

require_once '../db.php';

$sql = "SHOW TABLES LIKE '20%'";
$result = $conn->query($sql);

$isUpdated = false;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_array()) {
        $table = $row[0];
        $query = "UPDATE $table
                  SET reset_token_hash = ?,
                      reset_token_expires_at = ?
                  WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $token_hash, $expiry, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $isUpdated = true;
            break;
        }

        $stmt->close();
    }
}

if ($isUpdated) {
    $mail = require __DIR__ . "/../mailer.php";

    $mail->setFrom("qrbasedattendancesystem@gmail.com", 'QR Based Attendance Marking System');
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END
    Click <a href="localhost/QR/php/Student/reset_pass.php?token=$token">here</a> 
    to reset your password.
    END;

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }

    header("Location: Student.php?stat=Verification_Email_Sent_Successfully");
    exit();
} else {
    header("Location: Student.php?stat=Email_Not_Found");
    exit();
}

$conn->close();
?>
