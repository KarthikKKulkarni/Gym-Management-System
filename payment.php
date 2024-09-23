<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's selected classes and memberships
$stmt = $pdo->prepare("SELECT c.name, c.price FROM user_classes uc JOIN classes c ON uc.class_id = c.id WHERE uc.user_id = ?");
$stmt->execute([$user_id]);
$selected_classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT m.type, m.price FROM user_memberships um JOIN memberships m ON um.membership_id = m.id WHERE um.user_id = ?");
$stmt->execute([$user_id]);
$selected_memberships = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($selected_classes as $class) {
    $total += $class['price'];
}
foreach ($selected_memberships as $membership) {
    $total += $membership['price'];
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert payment details into the database
    $stmt = $pdo->prepare("INSERT INTO payments (user_id, amount) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);

    echo "<script>alert('Payment Successful! Total Amount: ₹$total'); window.location.href = 'dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('payment.jpeg');
            background-size: cover; /* Make it cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            opacity: 0.9; /* Make the background slightly transparent */
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        /* Other styles can go here */
    </style>
</head>
<body>
    <h2>Payment Details</h2>
    <h3>Selected Classes</h3>
    <ul>
        <?php foreach ($selected_classes as $class): ?>
            <li><?php echo htmlspecialchars($class['name']); ?> - ₹<?php echo htmlspecialchars($class['price']); ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Selected Memberships</h3>
    <ul>
        <?php foreach ($selected_memberships as $membership): ?>
            <li><?php echo htmlspecialchars($membership['type']); ?> - ₹<?php echo htmlspecialchars($membership['price']); ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Total Amount: ₹<?php echo $total; ?></h3>

    <form method="POST" action="">
        <button type="submit">Proceed to Payment</button>
    </form>

    <div class="logout">
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
