<?php

include_once('../connection.php');

include_once('navbar.php');

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style-about.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>

    <style>
      
    </style>
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>The Gallery Cafe</h1>
        </div>

        <div class="history">
            <div class="big-boxes">
                <div class="shape">
                    <h3>At The Gallery Café, we are dedicated to enhancing your dining experience through the latest technological advancements. Nestled in the heart of Colombo, our restaurant combines culinary excellence with state-of-the-art web solutions. Our newly launched interactive web-based application allows you to explore our diverse menu, make reservations, and even pre-order your favorite dishes before arriving. Designed with a user-friendly interface, the application offers detailed information about our table capacities, parking availability, special promotions, and upcoming events. Whether you're in the mood for Sri Lankan, Chinese, or Italian cuisine, our platform ensures a seamless and satisfying experience from the moment you visit our site to the time you leave our café. Join us at The Gallery Café, where tradition meets innovation, and every meal is an occasion to remember.</h3>
                </div>
            </div>
        </div>

        <div class="gallery">
            <div class="title-image">
                <p>The Image Gallery</p>
            </div>
            <div class="image-section">
                <div class="images">
                    <a href="Images/image 1.jpg">
                        <img src="Images/image 1.jpg" alt="Restuarant Image" style="width: auto; height: 290px;">
                    </a>
                </div>
                <div class="images">
                    <a href="Images/image 2.jpg">
                        <img src="Images/image 2.jpg" alt="Restuarant Image" style="width: auto; height: 290px;">
                    </a>
                </div>
                <div class="images">
                    <a href="Images/image 3.png">
                        <img src="Images/image 3.png" alt="Restuarant Image" style="width: auto; height: 290px;">                   
                    </a>
                </div>
            </div>
        </div>

<div class="mission-vision-container">
    <div class="mission">
        <div class="big-box">
            <div class="shapes">
                <br>
                <h1>Our Mission</h1>
                <h3>To be Sri Lanka’s best quick service restaurant by providing outstanding food, unique experiences and being the preferred dining and drinking place of the customers</h3>
            </div>
        </div>
    </div>
    
    <div class="vision">
        <div class="big-box">
            <div class="shapes">
                <br>
                <h1>Our Vision</h1>
                <h3>To be recognized as one of the ten best dining experiences in our city and to become a better place for customers with delicious food</h3>
            </div>
        </div>
    </div>
</div>

        
        <div class="directions">
            <center>
                <button class="direction-btn">
                    <a href="https://www.google.com/maps/place/The+Gallery+Caf%C3%A9/@6.898777,79.8548722,15z/data=!4m6!3m5!1s0x3ae259602cb3bc09:0x677419394138f674!8m2!3d6.898777!4d79.8548722!16s%2Fg%2F1tg7_xfn?entry=ttu">Directions</a>
                </button>
            </center>
        </div>

        <div class="Contact">
            <div class="contact-boxes">
                <div class="contact-d">
                    <h1>Contact us</h1>
                    <i class="fa-solid fa-phone"></i> <a href="tel:+94 114 777 888">114 777 888</a><br>
                    <i class="fa-solid fa-location-dot"></i> Location : De Krester Road, Colombo 4.<br>
                    <i class="fa-solid fa-envelope"></i> <a href="mailto:thegallerycafe@gmail.com">E-mail : thegallerycafe@gmail.com </a><br>
            </div>
        </div>
    </div>
</body>
</html>
