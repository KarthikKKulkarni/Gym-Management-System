<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch all payment details along with user details
$stmt = $pdo->query("SELECT p.*, u.username FROM payments p JOIN users u ON p.user_id = u.id");
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Payment Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        tr:hover {
            background-color: #f1f1f1;
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
    <div class="container">
        <h2>Payment Details</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Total Amount</th>
                <th>Date</th>
            </tr>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($payment['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($payment['username']); ?></td>
                    <td>₹<?php echo htmlspecialchars(number_format($payment['amount'], 2)); ?></td>
                    <td><?php echo htmlspecialchars($payment['date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="logout">
            <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
        </div>
    </div>
</body>
</html>
