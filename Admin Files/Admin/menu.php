<?php
include ('../connection.php');
include_once('navbar.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO menu (item_id, name, description, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $item_id, $name, $description, $price);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New menu item added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item</title>
    <link rel="stylesheet" href="style-menu.css">
</head>
<body>
    <div class="form-container">
        <h1>Add Menu Item</h1>
        <form action="add_menu_item.php" method="post">
            <label for="item_id">Item ID:</label>
            <input type="text" id="item_id" name="item_id"><br>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required><br>

            <button type="submit">Add Item</button>
        </form>
    </div>
</body>
</html>
