<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } else {
        try {
            // Check if email exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                $message = "Email already exists.";
            } else {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert user
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hashedPassword]);

                $message = "Registration successful. <a href='login.php'>Login here</a>";
            }

        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<div class="auth-container">

    <h2 class="page-title">Register</h2>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="register.php" class="form-container">

        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" class="input-field" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="input-field" required>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" class="input-field" required>
        </div>

        <button type="submit" class="btn">Register</button>

    </form>

</div>
<script src="assets/js/main.js"></script>
</body>
</html>