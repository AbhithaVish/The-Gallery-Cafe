<?php
include_once('../connection.php');
include_once('navbar.php');

$card_sql = "SELECT * FROM loyalty_card";
$card_result = $conn->query($card_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Cards</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-promotions.css">
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>Loyalty Cards</h1>
        </div>
        <div class="container">
            <?php if ($card_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Card Number</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $card_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['card_no']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['nic']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone_no']); ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No loyalty cards found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
