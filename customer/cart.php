<?php

include_once('../connection.php');
include_once('navbar.php');

if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit;
}
$username = $_SESSION['username'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-reservation.css">
</head>
<body>
    <div class="container">
    </div>
</body>
</html>