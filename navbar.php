<?php
session_start(); 
include_once('connection.php');

$activePage = basename($_SERVER['PHP_SELF'], "index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/2.5.0/remixicon.css">
</head>
<body>
<header class="header">
    <center>
    <nav class="nav container">
        <div class="nav__data">
            <a href="index.php" class="nav__logo">
                <i class="ri-planet-line"></i> The Gallery Cafe
            </a>
            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li><a href="index.php" class="nav__link">Home</a></li>
                <li><a href="welcome.php" class="nav__link">Menu</a></li>
                <li><a href="welcome.php" class="nav__link">Live</a></li>
                <li><a href="welcome.php" class="nav__link">Cart</a></li>
                <li><a href="welcome.php" class="nav__link">Reservation</a></li>
                <li><a href="about.php" class="nav__link">About Us</a></li>
                <li>
                    <a href="welcome.php" class="login" id="loginbutton">Log In</a>
                </li>
            </ul>
        </div>
    </nav>
    </center>
</header>

<!-- Add JavaScript to toggle the menu -->
<script>
    document.getElementById('nav-toggle').addEventListener('click', function () {
        document.getElementById('nav-menu').classList.toggle('show-menu');
    });
</script>

</body>
</html>
