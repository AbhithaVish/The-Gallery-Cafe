<?php
// Start the session 
session_start();

// Include the database connection
include_once('connection.php');

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="nav-bar">
        <ul>
            <li><a href=""></a></li>
            <li>Menu</li>
            <li>Live</li>
            <li>Order</li>
            <li>Reservation</li>
            <li>About</li>
        </ul>

    </div>
</body>
</html>
