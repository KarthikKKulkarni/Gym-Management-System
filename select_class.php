<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle class selection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    
    // Logic to handle the class selection (e.g., store the selection in the database)
    // You can create a table to track user class enrollments
    $stmt = $pdo->prepare("INSERT INTO user_classes (user_id, class_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $class_id]);
    $message = "Class selected successfully!";
}

// Fetch classes from the database
$stmt = $pdo->query("SELECT * FROM classes");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Select Class</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Select a Class</h2>

    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <ul>
            <?php foreach ($classes as $class): ?>
                <li>
                    <input type="radio" name="class_id" value="<?php echo htmlspecialchars($class['id']); ?>" required>
                    <?php echo htmlspecialchars($class['name']); ?> - ₹<?php echo htmlspecialchars($class['price']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <button type="submit">Select Class</button>
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
