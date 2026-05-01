<?php
$required_role = 'admin';
require_once '../includes/auth.php';
require_once '../config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    $imageName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    if (empty($title) || empty($description) || empty($status) || empty($imageName)) {
        $message = "All fields are required.";
    } else {
        $newImageName = time() . "_" . basename($imageName);
        $uploadPath = "../uploads/" . $newImageName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            $stmt = $pdo->prepare("INSERT INTO projects (title, description, status, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $description, $status, $newImageName]);

            $message = "Project uploaded successfully!";
        } else {
            $message = "Image upload failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Projects</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a class="nav-link" href="dashboard.php">Home</a>
    <a class="nav-link" href="projects.php">Projects</a>
    <a class="nav-link" href="materials.php">Materials</a>
    <a class="nav-link" href="tasks.php">Tasks</a>
    <a class="nav-link" href="post.php">View</a>
    <a class="nav-link logout" href="../logout.php">Logout</a>
</nav>

<div class="container">

    <h1 class="page-title">Add Project</h1>

    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="form-container">

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="input-field" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="input-field" required></textarea>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="input-field" required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="form-group">
            <label>Upload Image</label>
            <input type="file" name="image" class="input-field" accept="image/*" required>
        </div>

        <button type="submit" class="btn">Add Project</button>

    </form>

</div>
<script src="../assets/js/main.js"></script>
</body>
</html>