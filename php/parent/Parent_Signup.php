<?php
require_once('../../config/database.php');
require_once('../../config/language.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone']);
    $student_id = trim($_POST['student_id']);
    $relationship = $_POST['relationship'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = [];
    
    // Validation
    if (empty($name)) $errors[] = "Name is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($student_id)) $errors[] = "Student ID is required";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match";
    
    if (empty($errors)) {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT parent_id FROM parent_guardian WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errors[] = "Email already registered";
            }
            
            // Verify student exists
            $batch_year = '20' . substr($student_id, 0, 2) . '_' . substr($student_id, 2, 2);
            $student_stmt = $pdo->prepare("SELECT student_id FROM `{$batch_year}` WHERE student_id = ?");
            $student_stmt->execute([$student_id]);
            if (!$student_stmt->fetch()) {
                $errors[] = "Student ID not found";
            }
            
            if (empty($errors)) {
                // Hash password and insert
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $insert_stmt = $pdo->prepare("
                    INSERT INTO parent_guardian (name, email, phone, student_id, relationship, password) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                
                if ($insert_stmt->execute([$name, $email, $phone, $student_id, $relationship, $hashed_password])) {
                    header('Location: Parent.html?success=registered');
                    exit();
                } else {
                    $errors[] = "Registration failed. Please try again";
                }
            }
        } catch (PDOException $e) {
            error_log("Parent registration error: " . $e->getMessage());
            $errors[] = "System error. Please try again later";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent/Guardian Registration - ClassLog</title>
    <link rel="shortcut icon" href="../../img/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="../../index.html" class="logo">
                <img src="../../img/logo.png" alt="logo">
                <h2>Attendance Marking System</h2>
            </a>
        </nav>
    </header>
    
    <div class="container">
        <div class="signup-form">
            <div class="text">Parent/Guardian Registration</div>
            
            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="input-group">
                    <span class="material-symbols-rounded">person</span>
                    <input type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                </div>
                
                <div class="input-group">
                    <span class="material-symbols-rounded">email</span>
                    <input type="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>
                
                <div class="input-group">
                    <span class="material-symbols-rounded">phone</span>
                    <input type="tel" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
                </div>
                
                <div class="input-group">
                    <span class="material-symbols-rounded">badge</span>
                    <input type="text" name="student_id" placeholder="Student ID (e.g., 2019t01101)" value="<?php echo htmlspecialchars($student_id ?? ''); ?>" required>
                </div>
                
                <div class="input-group">
                    <span class="material-symbols-rounded">family_restroom</span>
                    <select name="relationship" required>
                        <option value="">Select Relationship</option>
                        <option value="Father" <?php echo (isset($relationship) && $relationship === 'Father') ? 'selected' : ''; ?>>Father</option>
                        <option value="Mother" <?php echo (isset($relationship) && $relationship === 'Mother') ? 'selected' : ''; ?>>Mother</option>
                        <option value="Guardian" <?php echo (isset($relationship) && $relationship === 'Guardian') ? 'selected' : ''; ?>>Guardian</option>
                        <option value="Other" <?php echo (isset($relationship) && $relationship === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
                <div class="input-group">
                    <span class="material-symbols-rounded">lock</span>
                    <input type="password" name="password" placeholder="Password (min 6 characters)" required>
                </div>
                
                <div class="input-group">
                    <span class="material-symbols-rounded">lock</span>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                
                <button type="submit" class="signup-btn">REGISTER</button>
            </form>
            
            <div class="login-link">
                <p>Already have an account? <a href="Parent.html">Login here</a></p>
            </div>
            
            <div class="back-link">
                <a href="../../index.html">
                    <span class="material-symbols-rounded">arrow_back</span>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
    
    <script src="../../js/script.js"></script>
</body>
</html>