<?php
session_start();

// Include the database connection
include_once('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Include navbar
include_once('nav bar/navbar.php');

// Close the database connection
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
            <h1>Our Newly</h1>
            <h1>Introduced</h1>
            <h1>Item</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione nobis cumque aspernatur dolore tempora earum nihil quas expedita, magni, deserunt, molestias doloremque. Illo odio maiores vel vitae laudantium. Pitiis est hic, inventore ab officia numquam perspiciatis?</p>
            <button class="order">Order Now</button>
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

    <script>
        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');

        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('show-menu');
            navToggle.classList.toggle('show-icon');
        });
    </script>
</body>
</html>
