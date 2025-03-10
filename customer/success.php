<?php
include_once('../connection.php');

session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (!empty($username)) {
    $reference_number = uniqid('ref_', true);


    $sqlCart = "SELECT * FROM `cart` WHERE username=?";
    $stmtCart = $conn->prepare($sqlCart);
    $stmtCart->bind_param('s', $username);
    $stmtCart->execute();
    $resultCart = $stmtCart->get_result();

    if ($resultCart->num_rows > 0) {
        // insert items into the orders table
        $sqlInsertOrder = "INSERT INTO `orders` (username, item_id, name, price, added_date, reference_number) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsertOrder = $conn->prepare($sqlInsertOrder);

        while ($row = $resultCart->fetch_assoc()) {
            $stmtInsertOrder->bind_param('sissds', $username, $row['item_id'], $row['name'], $row['price'], $row['added_date'], $reference_number);
            $stmtInsertOrder->execute();
        }

        $stmtInsertOrder->close();


        $sqlDeleteCart = "DELETE FROM `cart` WHERE username=?";
        $stmtDeleteCart = $conn->prepare($sqlDeleteCart);
        $stmtDeleteCart->bind_param('s', $username);
        if ($stmtDeleteCart->execute()) {
            $message = "Payment successful, order saved, and cart cleared.";
        } else {
            $message = "Error clearing cart: " . $stmtDeleteCart->error;
        }
        $stmtDeleteCart->close();
    } else {
        $message = "No items in the cart.";
    }

    $stmtCart->close();
} else {
    $message = "No user logged in.";
}

$conn->close();

header('Location: success_message.php?reference=' . $reference_number); 
exit();
?>
