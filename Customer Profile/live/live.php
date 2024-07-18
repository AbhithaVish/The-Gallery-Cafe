<?php
session_start();

include_once('..\..\connection.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit;
}

// Fetch the username from the session
$username = $_SESSION['username'];

// Fetch orders from the order table for the specific user
$sql = "SELECT order_id, item_id, name, price, order_date, address, contact FROM `order` WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live</title>
    <link rel="stylesheet" href="style-live.css">
</head>
<body>
    <br><br><br><br><br><br>
    
</body>
</html>
