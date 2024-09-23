<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle membership selection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['membership_id'])) {
    $membership_id = $_POST['membership_id'];
    
    // Logic to handle the membership selection (e.g., store the selection in the database)
    // You can create a table to track user memberships
    $stmt = $pdo->prepare("INSERT INTO user_memberships (user_id, membership_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $membership_id]);
    $message = "Membership selected successfully!";
}

// Fetch memberships from the database
$stmt = $pdo->query("SELECT * FROM memberships");
$memberships = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Select Membership</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Select a Membership</h2>

    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <ul>
            <?php foreach ($memberships as $membership): ?>
                <li>
                    <input type="radio" name="membership_id" value="<?php echo htmlspecialchars($membership['id']); ?>" required>
                    <?php echo htmlspecialchars($membership['type']); ?> - ₹<?php echo htmlspecialchars($membership['price']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <button type="submit">Select Membership</button>
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
