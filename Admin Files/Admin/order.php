<?php
include_once('../connection.php');
include_once('../navbar.php');

$username = $_SESSION['username'];

// Fetch all orders from the orders table
$order_sql = "SELECT * FROM orders ORDER BY reference_number";
$order_result = $conn->query($order_sql);

// Group orders by reference number
$orders = [];
if ($order_result->num_rows > 0) {
    while ($row = $order_result->fetch_assoc()) {
        $reference_number = $row['reference_number'];
        if (!isset($orders[$reference_number])) {
            $orders[$reference_number] = [
                'reference_number' => $reference_number,
                'payment_date' => $row['payment_date'],
                'items' => []
            ];
        }
        $orders[$reference_number]['items'][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles/style-orders.css">
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>Orders</h1>
        </div>
        <div class="container">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $reference_number => $order): ?>
                    <div class="order-group">
                        <h2>Reference Number: <?php echo htmlspecialchars($reference_number); ?></h2>
                        <p>Payment Date: <?php echo htmlspecialchars($order['payment_date']); ?></p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Username</th>
                                    <th>Item ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Reference number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['order_id']); ?></td>
                                        <td><?php echo htmlspecialchars($item['username']); ?></td>
                                        <td><?php echo htmlspecialchars($item['item_id']); ?></td>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                                        <td><?php echo htmlspecialchars($item['reference_number']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
