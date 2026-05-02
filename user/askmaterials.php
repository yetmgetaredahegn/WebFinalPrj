<?php
$required_role = 'user';
require_once '../includes/auth.php';
require_once '../config/db.php';

$message = "";

// Handle request submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['material_id'])) {

    $material_id = $_POST['material_id'];
    $user_id = $_SESSION['user_id'];
    $stmtUser = $pdo->prepare("SELECT email FROM users WHERE id = ?");
    $stmtUser->execute([$user_id]);
    $userEmail = $stmtUser->fetchColumn();

    try {
        $stmt = $pdo->prepare("
        INSERT INTO requests (user_id, email, type, item_id, status)
        VALUES (?, ?, 'material', ?, 'pending')
    ");

    $stmt->execute([$user_id, $userEmail, $material_id]);

        $message = "Request sent to Admin. Will receive an answer shortly in your email address!";
    } catch (PDOException $e) {
         $message = "DB ERROR: " . $e->getMessage();
    }
}

// Fetch materials
$materials = $pdo->query("SELECT * FROM materials ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ask Materials</title>
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

<h1 class="page-title">Available Materials</h1>

<?php if ($message): ?>
    <p class="message"><?php echo $message; ?></p>
<?php endif; ?>

<?php if ($materials): ?>
    <div class="card-grid">

        <?php foreach ($materials as $material): ?>
            <div class="card">

                <h3 class="card-title">
                    <?php echo htmlspecialchars($material['name']); ?>
                </h3>

                <p class="card-text">
                    Quantity: <?php echo htmlspecialchars($material['quantity']); ?>
                </p>

                <?php if (!empty($material['image'])): ?>
                    <img class="card-image"
                         src="../uploads/<?php echo $material['image']; ?>"
                         width="150">
                <?php endif; ?>

                <!-- SIMPLE PHP FORM BUTTON -->
                <form method="POST">
                    <input type="hidden" name="material_id" value="<?php echo $material['id']; ?>">
                    <button type="submit" class="btn ask-btn">
                        Ask to Buy
                    </button>
                </form>

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