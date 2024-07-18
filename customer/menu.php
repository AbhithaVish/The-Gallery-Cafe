<?php
session_start();

include_once('../connection.php');
include_once('navbar.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];

    // Fetch the username from the session
    $username = $_SESSION['username'];

    // Fetch item details from the menu table
    $item_sql = "SELECT id, name, price FROM menu WHERE id = ?";
    $stmt = $conn->prepare($item_sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $item_result = $stmt->get_result();
    $item = $item_result->fetch_assoc();
    
    if ($item) {
        $item_id = $item['id'];
        $name = $item['name'];
        $price = $item['price'];
        
        // Insert item into the order table
        $order_sql = "INSERT INTO `order` (item_id, name, price, username, order_date, address, contact) VALUES (?, ?, ?, ?, NOW(), '', '')";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bind_param("isds", $item_id, $name, $price, $username);
        $order_stmt->execute();
    }

    $stmt->close();
    $order_stmt->close();
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
    <title>Menu</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-menu.css">
</head>
<body>
    <br><br><br><br><br>

    <div class="cart"></div>

    <div class="menu-container">
        <center><h1>Menu</h1></center>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Cuisine Type</th>
                        <th>Order</th>
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
                                <form method="post" action="">
                                    <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="add_to_cart">Add to Order</button>
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
