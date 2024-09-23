<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Check if the user already has a time_in record
        $time_stmt = $pdo->prepare("SELECT * FROM time_tracking WHERE user_id = ? AND time_out IS NULL");
        $time_stmt->execute([$user['id']]);
        $current_time_record = $time_stmt->fetch(PDO::FETCH_ASSOC);

        if ($current_time_record) {
            // Mark the current time_in as time_out
            $update_stmt = $pdo->prepare("UPDATE time_tracking SET time_out = ? WHERE id = ?");
            $update_stmt->execute([date('Y-m-d H:i:s'), $current_time_record['id']]);
        }

        // Start a new time tracking session
        $insert_stmt = $pdo->prepare("INSERT INTO time_tracking (user_id, time_in) VALUES (?, ?)");
        $insert_stmt->execute([$user['id'], date('Y-m-d H:i:s')]);

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
    } else {
        echo "Invalid credentials.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('login.jpg');
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
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>
</body>
</html>
