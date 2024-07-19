<?php
// session_start();

include_once('../connection.php');

// if (!isset($_SESSION['username'])) {
//     echo "You need to log in first.";
//     exit;
// }

$username = $_SESSION['username'];
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';

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
} else {
    echo "Invalid request.";
}

$conn->close();
?>
