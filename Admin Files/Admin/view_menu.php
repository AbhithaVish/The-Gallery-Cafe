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

        $sqlAddItem = "INSERT INTO `menu` (`item_id`, `name`, `description`, `price`, `cousintype`, `category`) VALUES ('$item_id', '$name', '$description', '$price', '$cousintype', '$category')";
        $conn->query($sqlAddItem);
    } elseif (isset($_POST['edit_item'])) {
        $id = $_POST['id'];
        $item_id = $_POST['item_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $cousintype = $_POST['cousintype'];
        $category = $_POST['category'];

        $sqlEditItem = "UPDATE `menu` SET `item_id` = '$item_id', `name` = '$name', `description` = '$description', `price` = '$price', `cousintype` = '$cousintype', `category` = '$category' WHERE `item_id` = '$id'";
        $conn->query($sqlEditItem);
    } elseif (isset($_POST['delete_item'])) {
        $id = $_POST['id'];
        $sqlDeleteItem = "DELETE FROM `menu` WHERE `item_id` = '$id'";
        $conn->query($sqlDeleteItem);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['edit_item_id'])) {
        $id = $_GET['edit_item_id'];
        $sql = "SELECT * FROM `menu` WHERE `item_id` = '$id' LIMIT 1";
        $result = $conn->query($sql);
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
<body><center>
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
                            echo "<tr><td>" . $row["item_id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["description"] . "</td><td>" . $row["price"] . "</td><td>" . $row["cousintype"] . "</td><td>" . $row["category"] . "</td>";
                            echo "<td><a href='?edit_item_id=" . $row["item_id"] . "'>Edit</a></td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No data available</td></tr>";
                    }
                    ?>
                </table>
                <form method="post" enctype="multipart/form-data">
                    <h3><?php echo $editingItem ? 'Edit Item' : 'Add Item'; ?></h3>
                    <?php if ($editingItem): ?>
                        <input type="hidden" name="id" value="<?php echo $editingItem['item_id']; ?>">
                    <?php endif; ?>
                    <input type="text" name="item_id" placeholder="Item ID" value="<?php echo $editingItem['item_id'] ?? ''; ?>" required>
                    <input type="text" name="name" placeholder="Name" value="<?php echo $editingItem['name'] ?? ''; ?>" required>
                    <input type="text" name="description" placeholder="Description" value="<?php echo $editingItem['description'] ?? ''; ?>" required>
                    <input type="number" step="0.01" name="price" placeholder="Price" value="<?php echo $editingItem['price'] ?? ''; ?>" required>
                    <input type="text" name="cousintype" placeholder="Cuisine Type" value="<?php echo $editingItem['cousintype'] ?? ''; ?>" required>
                    <input type="text" name="category" placeholder="Category" value="<?php echo $editingItem['category'] ?? ''; ?>" required>
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
