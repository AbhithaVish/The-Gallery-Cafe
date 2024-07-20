<?php
// session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('connection.php');
include_once('navbar.php');

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>   
    <div class="main-banner">
        <div class="main-banner__content">
            <p>This is not a admin login page, it is a admin welcome first page</p>
            <h1>Our Newly</h1>
            <h1>Introduced</h1>
            <h1>Item</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione nobis cumque aspernatur dolore tempora earum nihil quas expedita, magni, deserunt, molestias doloremque. Illo odio maiores vel vitae laudantium. Pitiis est hic, inventore ab officia numquam perspiciatis?</p>
            <br><button class="order">Order Now</button>
        </div>
        <img src="Images/steak.png" alt="image">
    </div>

    <div class="mini-boxes">
        <div class="box">
            <h2>Reservation</h2>
            <button>Book Now</button>
        </div>
        <div class="box">
            <h2>Order Now</h2>
            <button>Order</button>
        </div>
        <div class="box">
            <h2>Tables</h2>
            <button>View Tables</button>
        </div>
        <div class="box">
            <h2>Menu</h2>
            <button>See Menu</button>
        </div>
    </div>
</body>
</html>
