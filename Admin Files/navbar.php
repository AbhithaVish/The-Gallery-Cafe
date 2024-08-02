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
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<header class="header">
    <nav class="nav container">
        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li><a href="index.php" class="nav__link">Dashboard</a></li>
                <li><a href="welcome.php" class="nav__link">Menu</a></li>
                <li><a href="welcome.php" class="nav__link">Live</a></li>
                <li><a href="welcome.php" class="nav__link">Orders</a></li>
                <li><a href="welcome.php" class="nav__link">Reservation</a></li>
                <li><a href="about.php" class="nav__link">About Us</a></li>
                <li><a href="welcome.php" class="nav__link">Profile</a></li>
                <li>
                    <a href="welcome.php" class="login" id="loginbutton">Log In</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

</body>
</html>
