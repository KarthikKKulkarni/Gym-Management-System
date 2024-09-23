<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$user_id = $_GET['id'] ?? null;
if ($user_id) {
    // Fetch user details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check for an active session
    $active_session_stmt = $pdo->prepare("SELECT * FROM time_tracking WHERE user_id = ? AND time_out IS NULL");
    $active_session_stmt->execute([$user_id]);
    $active_session = $active_session_stmt->fetch(PDO::FETCH_ASSOC);

    if ($active_session) {
        // Calculate the time since last login
        $time_in = new DateTime($active_session['time_in']);
        $current_time = new DateTime();
        $interval = $time_in->diff($current_time);
        $duration = $interval->h * 60 + $interval->i; // Duration in minutes

        // If the duration exceeds 90 minutes, end the session
        if ($duration >= 90) {
            $time_out = date('Y-m-d H:i:s');
            $update_stmt = $pdo->prepare("UPDATE time_tracking SET time_out = ?, duration = ? WHERE id = ?");
            $update_stmt->execute([$time_out, 90, $active_session['id']]);
        } else {
            // Update the duration for the current session
            $update_stmt = $pdo->prepare("UPDATE time_tracking SET duration = ? WHERE id = ?");
            $update_stmt->execute([$duration, $active_session['id']]);
        }
    }

    // Insert a new time tracking record for the current login
    $time_in = date('Y-m-d H:i:s');
    $insert_stmt = $pdo->prepare("INSERT INTO time_tracking (user_id, time_in) VALUES (?, ?)");
    $insert_stmt->execute([$user_id, $time_in]);

    // Fetch updated time tracking records
    $time_tracking_stmt = $pdo->prepare("SELECT * FROM time_tracking WHERE user_id = ?");
    $time_tracking_stmt->execute([$user_id]);
    $time_records = $time_tracking_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate total time in gym
    $total_time = 0;
    foreach ($time_records as $record) {
        if ($record['time_out']) {
            $time_in = new DateTime($record['time_in']);
            $time_out = new DateTime($record['time_out']);
            $total_time += $time_in->diff($time_out)->h * 60 + $time_in->diff($time_out)->i; // Total minutes
        }
    }
}

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
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
        .button {
            display: inline-block;
            padding: 10px 15px;
            color: white;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
    <style>
        body {
            background-image: url('user.jpeg');
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
    <div class="container">
        <h2>User Details</h2>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
        <p><strong>Total Time in Gym:</strong> <?php echo floor($total_time / 60) . ' hours ' . ($total_time % 60) . ' minutes'; ?></p>
        
        <h3>Time Tracking Records</h3>
        <table>
            <tr>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Duration (minutes)</th>
            </tr>
            <?php foreach ($time_records as $record): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['time_in']); ?></td>
                    <td><?php echo htmlspecialchars($record['time_out'] ?? ($record === end($time_records) ? 'Still in gym' : '')); ?></td>
                    <td><?php echo htmlspecialchars($record['duration'] ?? ''); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <a class="button" href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
