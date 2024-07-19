<?php
// session_start();

include_once('../connection.php');
include_once('navbar.php');

if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit;
}


$username = $_SESSION['username'];
$password = isset($_SESSION['password']) ? $_SESSION['password'] : ''; 

$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $quantity = 1; 

    $item_sql = "SELECT * FROM menu WHERE id = ?";
    $stmt = $conn->prepare($item_sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $item_result = $stmt->get_result();
    $item = $item_result->fetch_assoc();
    $stmt->close();

    if ($item) {
        $name = $item['name'];
        $cousintype = ''; 
        $price = $item['price'];

        $cart_sql = "INSERT INTO cart (username, password, item_id, quantity, cousintype, name, price) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($cart_sql);
        $stmt->bind_param("ssisssd", $username, $password, $item_id, $quantity, $cousintype, $name, $price);
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
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="style-menu.css">
    <style>
        
        .menu-item {
            border: 1px solid #ccc;
            padding: 16px;
            margin: 16px;
            border-radius: 8px;
            text-align: center;
        }
        .menu-item img {
            max-width: 100%;
            border-radius: 8px;
        }
        .add-to-cart {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body><br><br><br><br><br>
    <div class="container">
        <div class="menu">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="menu-item">
                        <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p>$<?php echo htmlspecialchars($row['price']); ?></p>
                        <form method="post">
                            <!-- <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>"> -->
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
