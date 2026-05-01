<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$required_role = 'user';
require_once '../includes/auth.php';
require_once '../config/db.php';

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    $user_id = $_SESSION['user_id'] ?? null;

    // Image handling
    $imageName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    if (empty($title) || empty($description) || empty($status) || empty($imageName)) {
        $message = "All fields are required.";
    } else {
        try {
            // Get user email
            $stmtUser = $pdo->prepare("SELECT email FROM users WHERE id = ?");
            $stmtUser->execute([$user_id]);
            $userEmail = $stmtUser->fetchColumn();

            // Rename image
            $newImageName = time() . "_" . basename($imageName);
            $uploadPath = "../uploads/" . $newImageName;

            if (move_uploaded_file($tmpName, $uploadPath)) {

                // Insert into requests table
                $stmt = $pdo->prepare("
                    INSERT INTO requests 
                    (user_id, email, type, title, description, project_status, image, status)
                    VALUES (?, ?, 'project_post', ?, ?, ?, ?, 'pending')
                ");

                $stmt->execute([
                    $user_id,
                    $userEmail,
                    $title,
                    $description,
                    $status,
                    $newImageName
                ]);

                $message = "Project request sent successfully!";
            } else {
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                $message = "Image upload failed.";
            }

        } catch (PDOException $e) {
            $message = "DB ERROR: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Project Request</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a class="nav-link" href="dashboard.php">Home</a>
    <a class="nav-link" href="askmaterials.php">View Materials</a>
    <a class="nav-link" href="askprojects.php">View Projects</a>
    <a class="nav-link" href="ask.php">Post Request</a>
    <a class="nav-link logout" href="../logout.php">Logout</a>
</nav>

<div class="container">

<h1 class="page-title">Request to Post Project</h1>

<?php if ($message): ?>
    <p class="message"><?php echo $message; ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="form-container">

    <div class="form-group">
        <label>Title:</label>
        <input type="text" name="title" class="input-field" required>
    </div>

    <div class="form-group">
        <label>Description:</label>
        <textarea name="description" class="input-field" required></textarea>
    </div>

    <div class="form-group">
        <label>Status:</label>
        <select name="status" class="input-field" required>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>

    <div class="form-group">
        <label>Upload Image:</label>
        <input type="file" name="image" class="input-field" accept="image/*" required>
    </div>

    <button type="submit" class="btn">Submit Request</button>

</form>

</div>
<script src="../assets/js/main.js"></script>
</body>
</html>