<?php
session_start();
include_once('config.php');

if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    $pqty = $_POST['pqty'];

    $username = $_SESSION['username'];
    $password = isset($_SESSION['password']) ? $_SESSION['password'] : ''; 

    // Fetch product details
    $stmt = $conn->prepare('SELECT * FROM product WHERE id = ?');
    $stmt->bind_param('i', $pid);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($item) {
        $pname = $item['product_name'];
        $pprice = $item['product_price'];
        $pimage = $item['product_image'];
        $pcode = $item['product_code'];

        // Add to cart
        $cart_sql = "INSERT INTO cart (username, password, item_id, quantity, product_name, product_price, product_image, product_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($cart_sql);
        $stmt->bind_param('ssisssss', $username, $password, $pid, $pqty, $pname, $pprice, $pimage, $pcode);
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

if (isset($_GET['cartItem']) && $_GET['cartItem'] === 'cart_item') {
    $username = $_SESSION['username'];
    
    $stmt = $conn->prepare('SELECT COUNT(*) AS count FROM cart WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    echo $data['count'];
    $stmt->close();
}

$conn->close();
?>
