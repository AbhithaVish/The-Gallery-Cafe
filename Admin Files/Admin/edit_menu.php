<?php
include_once('../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];

    // get existing menu item data
    $query = "SELECT * FROM menu WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $cousintype = $_POST['cousintype'];
    $price = $_POST['price'];

    // edit the menu item in the database
    $query = "UPDATE menu SET name = ?, description = ?, category = ?, cousintype = ?, price = ? WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssdi", $name, $description, $category, $cousintype, $price, $item_id);

    if ($stmt->execute()) {
        echo "Menu item updated successfully.";
    } else {
        echo "Error updating menu item: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: view_menu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
</head>
<body>
<div class="form-container">
    <form method="post" action="edit_menu.php">
        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['item_id']); ?>">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
        <label for="description">Description</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($item['description']); ?></textarea>
        <label for="category">Category</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($item['category']); ?>" required>
        <label for="cousintype">Cuisine Type</label>
        <input type="text" id="cousintype" name="cousintype" value="<?php echo htmlspecialchars($item['cousintype']); ?>" required>
        <label for="price">Price</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" required>
        <button type="submit" name="update">Update</button>
    </form>
</div>
</body>
</html>
