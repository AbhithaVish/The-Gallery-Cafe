<?php
session_start();

include_once('..\..\connection.php');
include_once('..\nav bar - customer/navbar.php');


if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit;
}


$username = $_SESSION['username'];


$sql = "SELECT  item_id, name, price, order_date, address, contact FROM `order` WHERE username = ?";
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
    <title>View All Reservations</title>
    <link rel="stylesheet" href="style-reservations">
    <link rel="stylesheet" href="..\nav bar - customer\style.css">

</head>
<body>
    
</body>
</html>