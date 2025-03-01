<?php
require 'db.php'; // Database connection

$error = ''; // Initialize error message variable
$success = ''; // Initialize success message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if the form is submitted
    // Sanitize and validate user input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Get the entered password

    // Check if username already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data from the database

    if ($user) { // If username already exists
        $error = "Username '$username' is already taken. Please choose a different username.";
    } else {
        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Insert the new user into the database
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();

            // Success message
            $success = "Registration successful! You can now log in.";
        } catch (PDOException $e) { // Handle database errors
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
</head>
<body>
    <header>
        Secure Login System - Registration <!-- Page header -->
    </header>

    <div class="container">
        <h2>Register</h2>

        <!-- Display success or error message -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div> <!-- Show error message -->
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div> <!-- Show success message -->
        <?php endif; ?>

        <form method="POST" action=""> <!-- Registration form -->
            <input type="text" name="username" placeholder="Enter Username" required> <!-- Username input -->
            <input type="password" name="password" placeholder="Enter Password" minlength="6" required> <!-- Password input -->
            <button type="submit">Register</button> <!-- Register button -->
        </form>

        <p>Already have an account? <a href="index.php">Login here</a></p> <!-- Login link -->
    </div>

    <footer>
        &copy; 2025 Secure Login System. All Rights Reserved. <!-- Footer content -->
    </footer>
</body>
</html>
