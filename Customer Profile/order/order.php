<?php
session_start();

include_once('..\..\connection.php');
include_once('..\nav bar - customer/navbar.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit;
}

// Fetch the username from the session
$username = $_SESSION['username'];

// Fetch orders from the order table for the specific user
$sql = "SELECT order_id, item_id, name, price, order_date, address, contact FROM `order` WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live</title>
    <link rel="stylesheet" href="..\nav bar - customer\style.css">
    <link rel="stylesheet" href="style-order.css">
</head>
<body>
    <br><br><br><br><br><br>
    <div class="order-container">
        <center><h1>Your Orders</h1></center>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>Address</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['item_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
