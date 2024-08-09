<?php
include_once('../connection.php');
include_once('navbar.php');


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$sqlOrders = "SELECT * FROM `orders` WHERE username = ?";

$stmt = $conn->prepare($sqlOrders);
$stmt->bind_param('s', $username);
$stmt->execute();
$resultOrders = $stmt->get_result();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Data</title>
    <link rel="stylesheet" href="style/style-live.css">
    <style>
        .filter-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="topic">
        </div>
        <div class="container">
            
            <div class="table-container">
                <h2>Orders Data</h2>
                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Reference Number</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    if ($resultOrders->num_rows > 0) {
                        while($row = $resultOrders->fetch_assoc()) {
                            $statusClass = $row["status"] === 'cancel' ? 'cancel' : ($row["status"] === 'picked' ? 'picked' : 'ready-to-pick-up');
                            echo "<tr>
                                <td>" . htmlspecialchars($row["order_id"]) . "</td>
                                <td>" . htmlspecialchars($row["item_id"]) . "</td>
                                <td>" . htmlspecialchars($row["name"]) . "</td>
                                <td>" . htmlspecialchars($row["price"]) . "</td>
                                <td>" . htmlspecialchars($row["reference_number"]) . "</td>
                                <td class='" . htmlspecialchars($statusClass) . "'>" . htmlspecialchars($row["status"]) . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data available</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
