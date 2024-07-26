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
    <title>Add Menu</title>
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/style-reservation.css">
    <style>
        html {
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="view-reservations">
            <div class="main-box">
                <h1>Add Menu Items</h1>
                <button  class="button-click"><a href="add_menu.php">Add</a></button>
            </div>
        </div>

        <div class="add-reservations">
        <div class="main-box">
                <h1>View All Menu</h1>
                <button class="button-click"><a href="view_menu.php">View</a></button>
            </div>
        </div>
    </div>
</body>
</html>
