<?php
session_start(); // Start the session to access session variables
if (!isset($_SESSION['username'])) { // Check if the user is logged in
    header("Location: index.php"); // Redirect to login page if not logged in
    exit(); // Stop further script execution
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <header>
        Secure Login System - Dashboard <!-- Page header -->
    </header>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2> <!-- Display logged-in username -->
        <p>You have successfully logged in and completed Multi-Factor Authentication.</p> <!-- Inform the user of successful login -->
        <p>This is your secure dashboard.</p> <!-- Dashboard description -->
        <a href="index.php" style="display: inline-block; margin-top: 20px;">
            <button>Logout</button> <!-- Logout button -->
        </a>
    </div>

    <footer>
        &copy; 2024 Secure Login System. All Rights Reserved. <!-- Footer content -->
    </footer>
</body>
</html>
