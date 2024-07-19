<?php
session_start();

include_once('../connection.php');
include_once('navbar.php');

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_item'])) {
        // Add item to the menu
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $cousintype = $_POST['cousintype'];

        $add_sql = "INSERT INTO menu (name, description, price, cousintype) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($add_sql);
        $stmt->bind_param("ssds", $name, $description, $price, $cousintype);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit_item'])) {
        // Edit item in the menu
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $cousintype = $_POST['cousintype'];

        $edit_sql = "UPDATE menu SET name = ?, description = ?, price = ?, cousintype = ? WHERE id = ?";
        $stmt = $conn->prepare($edit_sql);
        $stmt->bind_param("ssdsi", $name, $description, $price, $cousintype, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_item'])) {
        // Delete item from the menu
        $id = $_POST['id'];

        $delete_sql = "DELETE FROM menu WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch menu items
$sql = "SELECT id, name, description, price, cousintype FROM menu";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu Management</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-menu.css">
</head>
<body>
    <br><br><br><br><br>

    <div class="admin-menu-container">
        <center><h1>Admin Menu Management</h1></center>

        <h2>Add New Item</h2>
        <form method="post" action="">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="text" name="cousintype" placeholder="Cuisine Type" required>
            <button type="submit" name="add_item">Add Item</button>
        </form>

        <h2>Menu Items</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Cuisine Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['cousintype']); ?></td>
                            <td>
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                    <input type="text" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" required>
                                    <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required>
                                    <input type="text" name="cousintype" value="<?php echo htmlspecialchars($row['cousintype']); ?>" required>
                                    <button type="submit" name="edit_item">Edit</button>
                                </form>
                                <form method="post" action="" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_item">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No menu items available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
