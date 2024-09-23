<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$total_classes_amount = 0;
$total_membership_amount = 0;
$final_amount = 0;

// Handle Time In/Out and Selections
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Time Tracking
    if (isset($_POST['time_in'])) {
        $time_in = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("INSERT INTO time_tracking (user_id, time_in) VALUES (?, ?)");
        $stmt->execute([$user_id, $time_in]);
    } elseif (isset($_POST['time_out'])) {
        $time_out = date('Y-m-d H:i:s');
        $stmt = $pdo->prepare("UPDATE time_tracking SET time_out = ? WHERE user_id = ? AND time_out IS NULL ORDER BY time_in DESC LIMIT 1");
        $stmt->execute([$time_out, $user_id]);
    }

    // Selection of Classes and Membership
    if (isset($_POST['select_combined'])) {
        // Clear previous selections
        $stmt = $pdo->prepare("DELETE FROM user_classes WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $stmt = $pdo->prepare("DELETE FROM user_memberships WHERE user_id = ?");
        $stmt->execute([$user_id]);

        // Process Classes Selection
        if (isset($_POST['classes'])) {
            foreach ($_POST['classes'] as $class_id) {
                $stmt = $pdo->prepare("INSERT INTO user_classes (user_id, class_id) VALUES (?, ?)");
                $stmt->execute([$user_id, $class_id]);
            }
        }

        // Process Membership Selection
        if (isset($_POST['membership'])) {
            $membership_id = $_POST['membership'];
            $stmt = $pdo->prepare("INSERT INTO user_memberships (user_id, membership_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $membership_id]);
        }
    }
}

// Fetch classes and memberships
$stmt = $pdo->query("SELECT * FROM classes");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->query("SELECT * FROM memberships");
$memberships = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total amounts
foreach ($classes as $class) {
    if (isset($_POST['classes']) && in_array($class['id'], $_POST['classes'])) {
        $total_classes_amount += $class['price'];
    }
}

if (isset($_POST['membership'])) {
    $stmt = $pdo->prepare("SELECT price FROM memberships WHERE id = ?");
    $stmt->execute([$_POST['membership']]);
    $membership = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_membership_amount += $membership['price'] ?? 0;
}

// Calculate final amount
$final_amount = $total_classes_amount + $total_membership_amount;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('dashboard.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
            padding: 20px;
            margin: 0;
        }
        h2, h3 {
            text-align: center;
            color: #4CAF50;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-left: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Welcome to Your Dashboard</h2>

    <div class="form-container">
        <h3>Select Classes and Membership</h3>

        <h4>Classes</h4>
        <form method="POST" action="">
            <table>
                <tr>
                    <th>Class Name</th>
                    <th>Price</th>
                    <th>Select</th>
                </tr>
                <?php foreach ($classes as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['name']); ?></td>
                        <td>₹<?php echo htmlspecialchars(number_format($class['price'], 2)); ?></td>
                        <td><input type="checkbox" name="classes[]" value="<?php echo $class['id']; ?>"></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h4>Membership</h4>
            <table>
                <tr>
                    <th>Membership Type</th>
                    <th>Price</th>
                    <th>Select</th>
                </tr>
                <?php foreach ($memberships as $membership): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($membership['type']); ?></td>
                        <td>₹<?php echo htmlspecialchars(number_format($membership['price'], 2)); ?></td>
                        <td><input type="radio" name="membership" value="<?php echo $membership['id']; ?>"></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <button type="submit" name="select_combined">Select Classes & Membership</button>
        </form>
    </div>

    <div class="form-container">
        <h3>Total Amounts</h3>
        <p>Classes Total: ₹<?php echo htmlspecialchars(number_format($total_classes_amount, 2)); ?></p>
        <p>Membership Total: ₹<?php echo htmlspecialchars(number_format($total_membership_amount, 2)); ?></p>
        <p><strong>Final Amount: ₹<?php echo htmlspecialchars(number_format($final_amount, 2)); ?></strong></p>
        <button type="submit">  <a href="payment.php" </a> <strong> Proceed to Payment </strong></button>
           </div>

    <h3>Time Tracking</h3>
    <form method="POST" action="">
        <button type="submit" name="time_in">Time In</button>
        <button type="submit" name="time_out">Time Out</button>
    </form>

    <div class="logout">
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
