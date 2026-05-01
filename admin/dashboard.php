<?php
$required_role = 'admin';
require_once '../includes/auth.php';
require_once '../config/db.php';

// Fetch data
$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$materials = $pdo->query("SELECT * FROM materials ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$tasks = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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

<h1 class="page-title">Admin Dashboard</h1>
<hr class="divider">
<!-- PROJECTS -->
<h2 class="section-title">Projects</h2>

<?php if ($projects): ?>
    <div class="card-grid">
        <?php foreach ($projects as $project): ?>
            <div class="card">
                <h3 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                <p class="card-text"><?php echo htmlspecialchars($project['description']); ?></p>
                <p class="card-text">Status: <?php echo $project['status']; ?></p>

                <?php if (!empty($project['image'])): ?>
                    <img class="card-image" src="../uploads/<?php echo $project['image']; ?>" width="150">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="message">No projects found.</p>
<?php endif; ?>

<hr class="divider">

<!-- MATERIALS -->
<h2 class="section-title">Materials</h2>

<?php if ($materials): ?>
    <div class="card-grid">
        <?php foreach ($materials as $material): ?>
            <div class="card">
                <h3 class="card-title"><?php echo htmlspecialchars($material['name']); ?></h3>
                <p class="card-text">Quantity: <?php echo $material['quantity']; ?></p>
                <p class="card-text">Project ID: <?php echo $material['project_id']; ?></p>

                <?php if (!empty($material['image'])): ?>
                    <img class="card-image" src="../uploads/<?php echo $material['image']; ?>" width="150">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="message">No materials found.</p>
<?php endif; ?>

<hr class="divider">

<!-- TASKS -->
<h2 class="section-title">Tasks</h2>

<?php if ($tasks): ?>
    <div class="card-grid">
        <?php foreach ($tasks as $task): ?>
            <div class="card">
                <h3 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h3>
                <p class="card-text">Status: <?php echo $task['status']; ?></p>
                <p class="card-text">Project ID: <?php echo $task['project_id']; ?></p>

                <?php
                $assignedName = "Unassigned";
                foreach ($users as $user) {
                    if ($user['id'] == $task['assigned_to']) {
                        $assignedName = $user['name'];
                        break;
                    }
                }
                ?>

                <p class="card-text">Assigned To: <?php echo htmlspecialchars($assignedName); ?></p>

                <?php if (!empty($task['image'])): ?>
                    <img class="card-image" src="../uploads/<?php echo $task['image']; ?>" width="150">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="message">No tasks found.</p>
<?php endif; ?>

</div>
<script src="../assets/js/main.js"></script>
</body>
</html>