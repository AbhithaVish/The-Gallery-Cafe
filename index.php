<?php

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
    </style>
</head>
<body>   
    
<video autoplay muted loop id="myVideo">
  <source src="Videos/background video.mp4" type="video/mp4">
</video>

    <div class="main-banner">
        <center>
        <div class="background">
        <div class="text-overlay">
            <img src="Images/logo.png" alt="">
            <h1>The_Best_Tasting_Experience</h1>
            <h2>Cuisine and Drinks beyond the boundries of taste</h2>
            <p class="tagline">Food is Ready.</p>
        </div>
    </div>
        </center>
    </div>
<!-- 
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
    </div> -->
</body>
</html>
