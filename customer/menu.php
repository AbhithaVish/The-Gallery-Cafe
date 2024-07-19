<?php
// session_start();
include_once('../connection.php');

if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit;
}

$username = $_SESSION['username'];
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$contact = isset($_SESSION['contact']) ? $_SESSION['contact'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $quantity = 1; // Assuming quantity is fixed at 1 for simplicity

    // Fetch item details
    $item_sql = "SELECT * FROM menu WHERE item_id = ?";
    $stmt = $conn->prepare($item_sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $item_result = $stmt->get_result();
    $item = $item_result->fetch_assoc();
    $stmt->close();

    if ($item) {
        $name = $item['name'];
        $price = $item['price'];
        $order_date = date('Y-m-d');

        // Add to cart (order) table
        $cart_sql = "INSERT INTO `order` (item_id, name, price, username, order_date, address, contact) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($cart_sql);
        $stmt->bind_param("issssss", $item_id, $name, $price, $username, $order_date, $address, $contact);
        if ($stmt->execute()) {
            echo "Item added to cart.";
        } else {
            echo "Error adding item to cart.";
        }
        $stmt->close();
    } else {
        echo "Item not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="style-menu.css">
</head>
<body>
    <div class="container">
        <div class="menu">
            <?php
            $sql = "SELECT * FROM menu";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
            <div class="menu-item">
                <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p>Rs.<?php echo htmlspecialchars($row['price']); ?></p>
                <form method="post">
                    <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                    <button type="submit" class="add-to-cart">Add to Cart</button>
                </form>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <p>No menu items available.</p>
            <?php
            endif;
            ?>
        </div>
    </div>
</body>
</html>
