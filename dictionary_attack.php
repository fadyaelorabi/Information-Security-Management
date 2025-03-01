<?php
// Secure Database Connection Using PDO
$host = 'localhost';
$dbname = 'secure_app';
$db_username = 'root';
$db_password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if username is provided via POST request
if (!isset($_POST['username']) || empty($_POST['username'])) {
    die("<p style='color:red;'>No username provided.</p>");
}

$username = $_POST['username'];

// Get the stored password hash securely
$sql = "SELECT password FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("<p style='color:red;'>User not found.</p>");
}

$stored_hash = $row['password'];

// Check if the dictionary file exists before reading
$dictionary_file = "100k-most-used-passwords-NCSC.txt";
if (!file_exists($dictionary_file)) {
    die("<p style='color:red;'>Dictionary file not found.</p>");
}

$dictionary = file($dictionary_file, FILE_IGNORE_NEW_LINES);

echo "<p>Starting Dictionary Attack...</p>";
flush();
ob_flush();

foreach ($dictionary as $word) {
    if (password_verify($word, $stored_hash)) {
        echo "<p style='color:green;'>Password Found: $word</p>";
        exit;
    }
}


$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$max_length = 5;

for ($a = 0; $a < strlen($characters); $a++) {
    for ($b = 0; $b < strlen($characters); $b++) {
        for ($c = 0; $c < strlen($characters); $c++) {
            for ($d = 0; $d < strlen($characters); $d++) {
                for ($e = 0; $e < strlen($characters); $e++) {
                    $guess = $characters[$a] . $characters[$b] . $characters[$c] . $characters[$d] . $characters[$e];
                    echo "<p style='color:blue;'>Trying : $guess</p>";
                    if (password_verify($guess, $stored_hash)) {
                        die("<p style='color:green;'>Password Found: $guess</p>");
                    }
                }
            }
        }
    }
}
// If no match is found
echo "<p style='color:red;'>Password not found in dictionary.</p>";
echo "<p style='color:red;'>Dictionary attack failed. Starting Brute Force Attack...</p>"

?>
