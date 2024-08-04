<?php
include_once('../connection.php');
include_once('navbar.php');

$editingItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_item'])) {
        $item_id = $_POST['item_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $cousintype = $_POST['cousintype'];
        $category = $_POST['category'];

        // Insert item without image
        $sqlAddItem = "INSERT INTO `menu` (`item_id`, `name`, `description`, `price`, `cousintype`, `category`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtAddItem = $conn->prepare($sqlAddItem);
        $stmtAddItem->bind_param("ssssss", $item_id, $name, $description, $price, $cousintype, $category);
        $stmtAddItem->execute();
    } elseif (isset($_POST['edit_item'])) {
        $id = $_POST['id'];
        $item_id = $_POST['item_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $cousintype = $_POST['cousintype'];
        $category = $_POST['category'];

        // Update item without image
        $sqlEditItem = "UPDATE `menu` SET `item_id` = ?, `name` = ?, `description` = ?, `price` = ?, `cousintype` = ?, `category` = ? WHERE `item_id` = ?";
        $stmtEditItem = $conn->prepare($sqlEditItem);
        $stmtEditItem->bind_param("sssssss", $item_id, $name, $description, $price, $cousintype, $category, $id);
        $stmtEditItem->execute();
    } elseif (isset($_POST['delete_item'])) {
        $id = $_POST['id'];
        $sqlDeleteItem = "DELETE FROM `menu` WHERE `item_id` = ?";
        $stmtDeleteItem = $conn->prepare($sqlDeleteItem);
        $stmtDeleteItem->bind_param("s", $id);
        $stmtDeleteItem->execute();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['edit_item_id'])) {
        $id = $_GET['edit_item_id'];
        $sql = "SELECT * FROM `menu` WHERE `item_id` = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $editingItem = $result->fetch_assoc();
    }
}

$sqlItems = "SELECT * FROM `menu`";
$resultItems = $conn->query($sqlItems);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu Items</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-live.css">
    <style>
        body {
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <center>
    <div class="main-container">
        <div class="topic">
            <h1>Manage Menu Items</h1>
        </div>
        <div class="container">
            <div class="table-container">
                <h2>Menu Items</h2>
                
                <table>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Cuisine Type</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($resultItems->num_rows > 0) {
                        while ($row = $resultItems->fetch_assoc()) {
                            echo "<tr><td>" . htmlspecialchars($row["item_id"]) . "</td><td>" . htmlspecialchars($row["name"]) . "</td><td>" . htmlspecialchars($row["description"]) . "</td><td>" . htmlspecialchars($row["price"]) . "</td><td>" . htmlspecialchars($row["cousintype"]) . "</td><td>" . htmlspecialchars($row["category"]) . "</td>";
                            echo "<td><a href='?edit_item_id=" . htmlspecialchars($row["item_id"]) . "'>Edit</a></td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No data available</td></tr>";
                    }
                    ?>
                </table>
                <form method="post">
                    <h3><?php echo $editingItem ? 'Edit Item' : 'Add Item'; ?></h3>
                    <?php if ($editingItem): ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($editingItem['item_id']); ?>">
                    <?php endif; ?>
                    <input type="text" name="item_id" placeholder="Item ID" value="<?php echo htmlspecialchars($editingItem['item_id'] ?? ''); ?>" required>
                    <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($editingItem['name'] ?? ''); ?>" required>
                    <input type="text" name="description" placeholder="Description" value="<?php echo htmlspecialchars($editingItem['description'] ?? ''); ?>" required>
                    <input type="number" step="0.01" name="price" placeholder="Price" value="<?php echo htmlspecialchars($editingItem['price'] ?? ''); ?>" required>
                    <input type="text" name="cousintype" placeholder="Cuisine Type" value="<?php echo htmlspecialchars($editingItem['cousintype'] ?? ''); ?>" required>
                    <input type="text" name="category" placeholder="Category" value="<?php echo htmlspecialchars($editingItem['category'] ?? ''); ?>" required>
                    <?php if ($editingItem): ?>
                        <button type="submit" name="edit_item" class="btn-class">Edit Item</button>
                    <?php else: ?>
                        <button type="submit" name="add_item" class="btn-class">Add Item</button>
                    <?php endif; ?>
                </form>
                <form method="post">
                    <h3>Delete Item</h3>
                    <input type="text" name="id" placeholder="Item ID" required>
                    <button type="submit" name="delete_item" class="btn-delete">Delete Item</button>
                </form>
            </div>
        </div>
    </div>
    </center>
</body>
</html>
