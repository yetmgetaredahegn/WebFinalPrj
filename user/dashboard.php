<?php
$required_role = 'user';
require_once '../includes/auth.php';
require_once '../config/db.php';

// Fetch projects and materials
$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$materials = $pdo->query("SELECT * FROM materials ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
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

<h1 class="page-title">User Dashboard</h1>
<hr class="divider">
<!-- PROJECTS SECTION -->
<h2 class="section-title">Available Projects</h2>

<?php if ($projects): ?>
    <div class="card-grid">
        <?php foreach ($projects as $project): ?>
            <div class="card">
                <h3 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                <p class="card-text"><?php echo htmlspecialchars($project['description']); ?></p>
                <p class="card-text">Status: <?php echo htmlspecialchars($project['status']); ?></p>

                <?php if (!empty($project['image'])): ?>
                    <img class="card-image" src="../uploads/<?php echo $project['image']; ?>" width="150">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="message">No projects available.</p>
<?php endif; ?>

<hr class="divider">

<!-- MATERIALS SECTION -->
<h2 class="section-title">Available Materials</h2>

<?php if ($materials): ?>
    <div class="card-grid">
        <?php foreach ($materials as $material): ?>
            <div class="card">
                <h3 class="card-title"><?php echo htmlspecialchars($material['name']); ?></h3>
                <p class="card-text">Quantity: <?php echo htmlspecialchars($material['quantity']); ?></p>
                <p class="card-text">Project ID: <?php echo htmlspecialchars($material['project_id']); ?></p>

                <?php if (!empty($material['image'])): ?>
                    <img class="card-image" src="../uploads/<?php echo $material['image']; ?>" width="150">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="message">No materials available.</p>
<?php endif; ?>

</div>
<script src="../assets/js/main.js"></script>
</body>
</html>