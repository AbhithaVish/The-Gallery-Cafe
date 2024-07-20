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
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            margin-top: 150px
        }
        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }
        .main-banner {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
        }
        .main-banner__content {
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }
        .mini-boxes {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }
        .box {
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>
<body>   
    
<video autoplay muted loop id="myVideo">
  <source src="Videos/background video.mp4" type="video/mp4">
</video>
    <div class="main-banner">
        <div class="main-banner__content">
            <p>This is not a login page, it is a welcome first page</p>
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
