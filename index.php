<?php
require 'db.php'; // Database connection

$error = ''; // Initialize error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if the form is submitted
    // Sanitize and validate user input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Get the entered password

    // Check if username exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data from the database

    if ($user && password_verify($password, $user['password'])) { // Verify the password
        // Password matches, start the session
        session_start();
        $_SESSION['username'] = $username; // Store the username in the session

        // Redirect to MFA page
        header("Location: mfa.php");
        exit(); // Stop further execution after redirect
    } else {
        // Invalid credentials, show an error message
        $error = "Invalid credentials! Please try again.";
    }
}/////////////////////////////////////dic button///////////////////////////////////////

if (isset($_POST['attack_btn'])) {
    $username = $_POST['username'];
    include('dictionary_attack.php'); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <header>
        Secure Login System <!-- Page header -->
    </header>

    <div class="container">
        <h2>Login</h2>

        <!-- Display error message if credentials are invalid -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div> <!-- Show error message -->
        <?php endif; ?>

        <form method="POST" action=""> <!-- Login form -->
            <input type="text" name="username" placeholder="Enter Username" > <!-- Username input -->
            <input type="password" name="password" placeholder="Enter Password" minlength="6" > <!-- Password input -->
            <button type="submit">Login</button> <!-- Login button -->
            <button type="submit" id="attack_btn"  name="attack_btn">Start Dictionary Attack</button>
        </form>
        

        <p>Don't have an account? <a href="register.php">Register here</a></p> <!-- Registration link -->
    </div>

    <footer>
        &copy; 2025 Secure Login System. All Rights Reserved. <!-- Footer content -->
    </footer>
</body>
</html>
