<?php

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

require_once '../db.php';

$sql = "SHOW TABLES LIKE '20%'";
$result = $conn->query($sql);

$user = null;

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Marking System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="#" class="logo">
                <img src="../../img/logo.png" alt="logo">
                <h2>Attendance Marking System</h2>
            </a>
        </nav>
    </header>
    <div class="container">
        <div class="content">
            <div id="form-message" class="form-message"></div>

            <form id="password-reset-form" method="post" action="process_reset_pass.php" class="modal">
                <div class="modal-content">
                    <h2>Reset Password</h2><br>

                    <div id="reset-form-message" class="form-message"></div>
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <div class="field">
                        <input type="password" name="password" id="password" placeholder="New Password" required>
                    </div>
                    <div class="field">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-Enter Password" required>
                    </div>
                    <div class="show-password">
                        <input type="checkbox" id="reset-show-password">
                        <label for="reset-show-password">Show Password</label>
                    </div>
                    <div id="password-validation-message" class="validation-message"></div>
                    <button type="submit">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/script.js"></script>
    <script>
        document.getElementById('reset-show-password').addEventListener('change', function() {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');
            if (this.checked) {
                passwordField.type = 'text';
                confirmPasswordField.type = 'text';
            } else {
                passwordField.type = 'password';
                confirmPasswordField.type = 'password';
            }
        });
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');
        const validationMessage = document.getElementById('password-validation-message');

        const showValidationMessage = (message, color = 'red') => {
            validationMessage.innerHTML = message;
            validationMessage.style.color = color;
        };

        const validatePassword = () => {
            if (passwordField.value.length < 8) {
                showValidationMessage('Password must be at least 8 characters long.');
                return false;
            }

            if (!/[a-z]/i.test(passwordField.value)) {
                showValidationMessage('Password must contain at least one letter.');
                return false;
            }

            if (!/[0-9]/.test(passwordField.value)) {
                showValidationMessage('Password must contain at least one number.');
                return false;
            }

            if (passwordField.value !== confirmPasswordField.value) {
                showValidationMessage('Passwords must match.');
                return false;
            }

            showValidationMessage('Password is valid.', 'green');
            return true;
        };

        passwordField.addEventListener('input', validatePassword);
        confirmPasswordField.addEventListener('input', validatePassword);

        document.getElementById('password-reset-form').addEventListener('submit', function(event) {
            if (!validatePassword()) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
