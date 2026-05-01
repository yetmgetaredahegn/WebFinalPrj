<?php
$required_role = 'admin';
require_once '../includes/auth.php';
require_once '../config/db.php';

$message = "";

// HANDLE "ADD PROJECT" ACTION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_id'])) {

    $request_id = $_POST['request_id'];

    try {
        // Get request data
        $stmt = $pdo->prepare("SELECT * FROM requests WHERE id = ? AND type = 'project_post'");
        $stmt->execute([$request_id]);
        $request = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($request) {

            // Insert into projects table
            $insert = $pdo->prepare("
                INSERT INTO projects (title, description, status, image)
                VALUES (?, ?, ?, ?)
            ");

            $insert->execute([
                $request['title'],
                $request['description'],
                $request['project_status'],
                $request['image']
            ]);

            // OPTIONAL: update request status (recommended)
            $update = $pdo->prepare("UPDATE requests SET status = 'seen' WHERE id = ?");
            $update->execute([$request_id]);

            $message = "Project added successfully!";
        } else {
            $message = "Request not found.";
        }

    } catch (PDOException $e) {
        $message = "DB ERROR: " . $e->getMessage();
    }
}

// FETCH PROJECT POST REQUESTS
$requests = $pdo->query("
    SELECT * FROM requests 
    WHERE type = 'project_post' 
    ORDER BY created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Requests</title>
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

<h1 class="page-title">Project Post Requests</h1>

<?php if ($message): ?>
    <p class="message"><?php echo $message; ?></p>
<?php endif; ?>

<?php if ($requests): ?>
    <div class="card-grid">

        <?php foreach ($requests as $req): ?>
            <div class="card">

                <h3 class="card-title">
                    <?php echo htmlspecialchars($req['title']); ?>
                </h3>

                <p class="card-text">
                    <?php echo htmlspecialchars($req['description']); ?>
                </p>

                <p class="card-text">
                    Status: <?php echo htmlspecialchars($req['project_status']); ?>
                </p>

                <p class="card-text">
                    Requester Email: <?php echo htmlspecialchars($req['email']); ?>
                </p>

                <?php if (!empty($req['image'])): ?>
                    <img class="card-image"
                         src="../uploads/<?php echo $req['image']; ?>"
                         width="150">
                <?php endif; ?>

                <!-- ADD BUTTON -->
                <form method="POST">
                    <input type="hidden" name="request_id" value="<?php echo $req['id']; ?>">
                    <button type="submit" class="btn">
                        Add to Projects
                    </button>
                </form>

            </div>
        <?php endforeach; ?>

    </div>
<?php else: ?>
    <p class="message">No project requests found.</p>
<?php endif; ?>

</div>
<script src="../assets/js/main.js"></script>
</body>
</html>