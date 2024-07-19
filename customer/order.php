<?php
// session_start();

include_once('../connection.php');
include_once('navbar.php');

if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit;
}

$username = $_SESSION['username'];

// Fetch cart items for the user
$sql = "SELECT c.item_id, m.name, m.price, c.quantity, c.added_at 
        FROM cart c 
        JOIN menu m ON c.item_id = m.id 
        WHERE c.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Handle order processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // Get order details
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    
    // Insert into orders table
    $order_sql = "INSERT INTO `order` (username, item_id, name, price, order_date, address, contact) 
                  SELECT username, item_id, name, price, CURRENT_TIMESTAMP, ?, ? 
                  FROM cart 
                  JOIN menu ON cart.item_id = menu.id 
                  WHERE cart.username = ?";
    $order_stmt = $conn->prepare($order_sql);
    $order_stmt->bind_param("sss", $address, $contact, $username);
    if ($order_stmt->execute()) {
        // Clear the cart after successful order
        $clear_cart_sql = "DELETE FROM cart WHERE username = ?";
        $clear_cart_stmt = $conn->prepare($clear_cart_sql);
        $clear_cart_stmt->bind_param("s", $username);
        $clear_cart_stmt->execute();

        echo "Order placed successfully!";
    } else {
        echo "Error placing order.";
    }
    $order_stmt->close();
    $clear_cart_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-order.css">
</head>
<body>
    <br><br><br><br><br><br>
    <div class="order-container">
        <center><h1>Your Cart</h1></center>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Added At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['item_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['added_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Order Form -->
            <form method="post">
                <h2>Order Details</h2>
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" required><br><br>
                <label for="contact">Contact:</label>
                <input type="text" name="contact" id="contact" required><br><br>
                <button type="submit" name="place_order">Place Order</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
