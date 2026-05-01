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
            // Get user by email
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify name and password
                if ($user['name'] === $name && password_verify($password, $user['password'])) {

                    // Set session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect based on role
                    if ($user['role'] === 'admin') {
                        header("Location: admin/dashboard.php");
                        exit();
                    } else {
                        header("Location: user/dashboard.php");
                        exit();
                    }

                } else {
                    $message = "Invalid name or password.";
                }
            } else {
                $message = "User not found.";
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
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<div class="auth-container">

    <h2 class="page-title">Login</h2>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="" class="form-container">

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

        <button type="submit" class="btn">Login</button>

    </form>

    <!-- NEW REGISTER LINK -->
    <p class="auth-link">
        Don’t have an account?
        <a href="register.php" class="link-btn">Register here</a>
    </p>

</div>
<script src="assets/js/main.js"></script>
</body>
</html>