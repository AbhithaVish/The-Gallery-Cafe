<?php
include_once('../connection.php');

include_once('navbar.php');

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-profile.css">
</head>
<body>
    <div class="main-container">
    <div class="view-profiles">
            <div class="main-box">
                <h1>Staff</h1>
                <button  class="button-click"><a href="staff-view.php">View</a></button>
            </div>
        </div>

        <div class="add-reservations">
        <div class="main-box">
                <h1>Coustomers</h1>
                <button class="button-click"><a href="cus-view.php">View</a></button>
            </div>
        </div>
    </div>
    </body>
</html>