<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location:../../index.html?error=notloggedin');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="../../img/logo.png" alt="logo">
                <h2>Attendance Marking System</h2>
            </a>
            <div class="navbar-right">
                <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="#">Home</a></li>
                <li><a href="#" id="manageUserBtn">Manage User</a></li>
                <li><a href="#">Manage Batch Details</a></li>
                <li><a href="#">Manage Course Details</a></li>
                <li><a href="#">Manage Location</a></li>
                </ul>
            <div class="navbar-right">
                <span class="notification-btn material-symbols-rounded">notifications</span>
                <button class="logout-btn" id="logoutBtn">LOGOUT</button>
            </div>
        </nav>
    </header>
    
    
    
    <script src="../../js/script_2.js"></script>
    
    <script>
        document.getElementById("logoutBtn").addEventListener("click", function () {
            alert("You have been logged out!");
            window.location.href = "../logout.php";
        });

    </script>
</body>
</html>