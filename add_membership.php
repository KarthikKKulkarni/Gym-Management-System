<?php
require 'config.php';
session_start();

// Handle membership addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_membership'])) {
    $membership_type = $_POST['membership_type'];
    $membership_price = $_POST['membership_price']; // Added price field

    $stmt = $pdo->prepare("INSERT INTO memberships (membership_type, price) VALUES (?, ?)");
    if ($stmt->execute([$membership_type, $membership_price])) {
        header("Location: add_membership.php");
        exit; // Ensure no further code is executed after redirection
    } else {
        echo "<p>Failed to add membership.</p>";
    }
}

// Handle membership deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_membership'])) {
    $membership_id = $_POST['membership_id'];

    $stmt = $pdo->prepare("DELETE FROM memberships WHERE id = ?");
    if ($stmt->execute([$membership_id])) {
        echo "<p>Membership deleted successfully!</p>";
    } else {
        echo "<p>Failed to delete membership.</p>";
    }
}

// Fetch current memberships
$stmt = $pdo->query("SELECT * FROM memberships");
$memberships = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Membership</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #4CAF50;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            margin: 5px;
            width: calc(100% - 22px);
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 80%;
            max-width: 600px;
            border-collapse: collapse;
            margin: 20px auto; /* Center the table */
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
        td {
            background-color: #fff;
        }
        .delete-button {
            background-color: #f44336;
            padding: 5px 8px; /* Smaller padding for the button */
            font-size: 12px; /* Smaller font size */
            width: auto; /* Fit the button to content */
            border: none;
            border-radius: 5px;
        }
        .delete-button:hover {
            background-color: #d32f2f;
        }
        .action-cell {
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Add Membership</h2>
        <input type="text" name="membership_type" placeholder="Membership Type" required>
        <input type="number" name="membership_price" placeholder="Price" required step="0.01"> <!-- Added price input -->
        <button type="submit" name="add_membership">Add Membership</button>
        <a class="button" href="admin_dashboard.php">Back to Dashboard</a>
    </form>

    <h2>Current Memberships</h2>
    <table>
        <tr>
            <th>Membership Type</th>
            <th>Price</th> <!-- New price column -->
            <th>Action</th>
        </tr>
        <?php foreach ($memberships as $membership): ?>
            <tr>
                <td><?php echo htmlspecialchars($membership['type']); ?></td>
                <td><?php echo htmlspecialchars($membership['price']); ?></td> <!-- Display price -->
                <td class="action-cell">
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="membership_id" value="<?php echo $membership['id']; ?>">
                        <button type="submit" name="delete_membership" class="delete-button" onclick="return confirm('Are you sure you want to delete this membership?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
