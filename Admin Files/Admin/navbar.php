<?php
session_start(); // Ensure sessions are started

include_once('../connection.php');
$activePage = basename($_SERVER['PHP_SELF'], "index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header class="header">
    <nav class="nav container">
        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li><a href="index.php" class="nav__link">Home</a></li>
                <li><a href="menu.php" class="nav__link">Menu</a></li>
                <li><a href="live.php" class="nav__link">Live</a></li>
                <li><a href="order.php" class="nav__link">Orders</a></li>
                <li><a href="promotion.php" class="nav__link">loyalty card</a></li>
                <li><a href="reservation.php" class="nav__link">Reservation</a></li>
                <li><a href="profiles.php" class="nav__link">Profile</a></li>
                <li><a href="about.php" class="nav__link">About Us</a></li>
                <li>
                    <a href="../index.php" class="login" id="loginbutton">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

</body>
</html>
