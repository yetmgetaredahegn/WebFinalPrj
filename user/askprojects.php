<?php
$required_role = 'user';
require_once '../includes/auth.php';
require_once '../config/db.php';

$message = "";

// Handle project request submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['project_id'])) {

    $user_id = $_SESSION['user_id'] ?? null;
    $project_id = $_POST['project_id'] ?? null;

    if (!$user_id || !$project_id) {
        $message = "Invalid session or project.";
    } else {
        try {
            // get user email
            $stmtUser = $pdo->prepare("SELECT email FROM users WHERE id = ?");
            $stmtUser->execute([$user_id]);
            $userEmail = $stmtUser->fetchColumn();

            // insert request
            $stmt = $pdo->prepare("
                INSERT INTO requests (user_id, email, type, item_id, status)
                VALUES (?, ?, 'project', ?, 'pending')
            ");

            $stmt->execute([$user_id, $userEmail, $project_id]);

            $message = "Request sent to Admin. Will receive an answer shortly in your email address!";
        } catch (PDOException $e) {
            $message = "DB ERROR: " . $e->getMessage();
        }
    }
}

// Fetch projects
$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ask Projects</title>
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

<h1 class="page-title">Available Projects</h1>

<?php if ($message): ?>
    <p class="message"><?php echo $message; ?></p>
<?php endif; ?>

<?php if ($projects): ?>
    <div class="card-grid">

        <?php foreach ($projects as $project): ?>
            <div class="card">

                <h3 class="card-title">
                    <?php echo htmlspecialchars($project['title']); ?>
                </h3>

                <p class="card-text">
                    <?php echo htmlspecialchars($project['description']); ?>
                </p>

                <p class="card-text">
                    Status: <?php echo htmlspecialchars($project['status']); ?>
                </p>

                <?php if (!empty($project['image'])): ?>
                    <img class="card-image"
                         src="../uploads/<?php echo $project['image']; ?>"
                         width="150">
                <?php endif; ?>

                <!-- REQUEST BUTTON -->
                <form method="POST">
                    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                    <button type="submit" class="btn ask-btn">
                        Ask About Project
                    </button>
                </form>

            </div>
        <?php endforeach; ?>

    </div>
<?php else: ?>
    <p class="message">No projects available.</p>
<?php endif; ?>

</div>
<script src="../assets/js/main.js"></script>
</body>
</html>