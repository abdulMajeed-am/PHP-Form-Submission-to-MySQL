<?php
// Include DB connection
// Include DB connection
// require_once 'config/db.php';
require_once '../config/db.php';

// Create table if it doesn't exist
$tableQuery = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$pdo->exec($tableQuery);

// Form data insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    // Basic validation to check if fields are empty
    if (empty($name) || empty($email) || empty($phone)) {
        echo "⚠️ Please fill in both the name, email and phone number fields.";
    } else {
        try {
            // Insert data into the database
            $stmt = $pdo->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $phone]);

            // Redirect to the view page to show all data after successful submission
            header('Location: view.php');
            exit();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
<br><br>
<a href="public/index.php">Go Back to Form</a>
