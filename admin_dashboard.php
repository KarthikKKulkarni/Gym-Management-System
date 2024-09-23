<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch users
$users_stmt = $pdo->query("SELECT id, username, role FROM users");
$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .button-container {
            margin: 20px 0;
            text-align: center;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .view-details-button {
            background-color: yellow;
            color: black;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .view-details-button:hover {
            background-color: #e6e600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
<style>
        body {
            background-image: url('admin.jpg');
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
<!-- Admin Dashboard -->
<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="button-container">
        <a class="button" href="add_class.php">Add Class</a>
        <a class="button" href="add_membership.php">Add Membership</a>
        <a class="button" href="admin_payment_details.php">View Payment Details</a>
        <a class="button" href="logout.php">Logout</a>
    </div>

    <h3>Manage Users</h3>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a class="view-details-button" href="user_details.php?id=<?php echo htmlspecialchars($user['id']); ?>">View Details</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
