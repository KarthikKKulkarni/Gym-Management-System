<?php
require 'config.php';
session_start();

// Handle class addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];
    $class_price = (int)$_POST['class_price']; // Cast to integer

    // Check if the price is a natural number
    if ($class_price <= 0) {
        echo "<p>Please enter a valid natural number for the price.</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO classes (class_name, price) VALUES (?, ?)");
        $stmt->execute([$class_name, $class_price]);

        echo "<p>Class added successfully!</p>";
    }
}

// Handle class deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_class'])) {
    $class_id = $_POST['class_id'];

    $stmt = $pdo->prepare("DELETE FROM classes WHERE id = ?");
    $stmt->execute([$class_id]);

    echo "<p>Class deleted successfully!</p>";
}

// Fetch current classes
$stmt = $pdo->query("SELECT id, class_name, price FROM classes");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Class</title>
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
            font-size: 1.5em; /* Smaller header size */
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"],
        input[type="number"] {
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
            width: 80%; /* Reduced table width */
            max-width: 600px; /* Set a maximum width */
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
            padding: 5px 10px;
            margin: 0 auto; /* Center the button in the cell */
            display: block; /* Allow centering */
        }
        .delete-button:hover {
            background-color: #d32f2f;
        }
        .button {
            margin-left: 10px;
        }
        /* Center align the Delete column */
        .action-cell {
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Add New Class</h2>
        <input type="text" name="class_name" placeholder="Name" required>
        <input type="number" name="class_price" placeholder="Price" min="1" required>
        <button type="submit" name="add_class">Add Class</button>
        <a class="button" href="admin_dashboard.php">Back to Dashboard</a>
    </form>

    <h2>Current Classes</h2> <!-- Smaller heading -->
    <table>
        <tr>
            <th>Class Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($classes as $class): ?>
            <tr>
                <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                <td>₹<?php echo htmlspecialchars(number_format($class['price'], 2)); ?></td>
                <td class="action-cell">
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                        <button type="submit" name="delete_class" class="delete-button" onclick="return confirm('Are you sure you want to delete this class?');">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>