<?php

include_once('connection.php');

include_once('navbar.php');

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style-about.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
      
    </style>
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>The Gallery Cafe</h1>
        </div>

        <div class="history">
            <h3>At The Gallery Café, we are dedicated to enhancing your dining experience through the latest technological advancements. Nestled in the heart of Colombo, our restaurant combines culinary excellence with state-of-the-art web solutions. Our newly launched interactive web-based application allows you to explore our diverse menu, make reservations, and even pre-order your favorite dishes before arriving. Designed with a user-friendly interface, the application offers detailed information about our table capacities, parking availability, special promotions, and upcoming events. Whether you're in the mood for Sri Lankan, Chinese, or Italian cuisine, our platform ensures a seamless and satisfying experience from the moment you visit our site to the time you leave our café. Join us at The Gallery Café, where tradition meets innovation, and every meal is an occasion to remember.</h3>
        </div>


        <div class="directions">
            <center>
                <button class="direction-btn">
                    <a href="https://www.google.com/maps/place/The+Gallery+Caf%C3%A9/@6.898777,79.8548722,15z/data=!4m6!3m5!1s0x3ae259602cb3bc09:0x677419394138f674!8m2!3d6.898777!4d79.8548722!16s%2Fg%2F1tg7_xfn?entry=ttu">Directions</a>
                </button>
            </center>
        </div>
    </div>
    </body>
</html>
