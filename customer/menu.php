<?php
// session_start();
include_once('../connection.php');
include_once('navbar.php');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../welcome.php');
    exit;
}

$username = $_SESSION['username'];
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$contact = isset($_SESSION['contact']) ? $_SESSION['contact'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']); // Ensure item_id is an integer
    error_log("Received item_id: " . $item_id); // Debugging

    // Fetch item details
    $item_sql = "SELECT * FROM menu WHERE item_id = ?";
    if ($stmt = $conn->prepare($item_sql)) {
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $item_result = $stmt->get_result();
        $item = $item_result->fetch_assoc();
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }

    if ($item) {
        $name = $item['name'];
        $price = $item['price'];
        $order_date = date('Y-m-d');

        // Add to orders table
        $order_sql = "INSERT INTO orders (item_id, name, price, username, order_date, address, contact) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($order_sql)) {
            $stmt->bind_param("issssss", $item_id, $name, $price, $username, $order_date, $address, $contact);
            if ($stmt->execute()) {
                $message = "Item added to cart.";
            } else {
                $message = "Error adding item to cart: " . $stmt->error;
                error_log("Error adding item to cart: " . $stmt->error); // Debugging
            }
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
            error_log("Error preparing statement: " . $conn->error); // Debugging
        }
    } else {
        $message = "Item not found.";
    }
}

// Fetch menu items
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
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
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <div class="menu">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="menu-item">
                    <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Rs.<?php echo htmlspecialchars($row['price']); ?></p>
                    <form method="post">
                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($row['item_id']); ?>">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No menu items available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
