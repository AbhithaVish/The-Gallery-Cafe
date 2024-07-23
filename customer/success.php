<?php
include_once('../connection.php');

session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (!empty($username)) {
    // Delete all items from the cart for the user
    $sqlDeleteCart = "DELETE FROM `cart` WHERE username=?";
    $stmtDeleteCart = $conn->prepare($sqlDeleteCart);
    $stmtDeleteCart->bind_param('s', $username);
    if ($stmtDeleteCart->execute()) {
        $message = "Payment successful and cart cleared.";
    } else {
        $message = "Error clearing cart: " . $stmtDeleteCart->error;
    }
    $stmtDeleteCart->close();
} else {
    $message = "No user logged in.";
}

$conn->close();

// Redirect to a success page or display a success message
header('Location: success_message.php'); // Redirect to a success message page
exit();
?>
