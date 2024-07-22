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
    <title>Profile View</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-profile.css">
</head>
<body>
    <div class="container">
        <div class="main-box">
            <h1>Staff</h1>
            <button class="button-click"><a href="staff-view.php">View</a></button>
        </div>
        <div class="main-box">
            <h1>Customers</h1>
            <button class="button-click"><a href="cus-view.php">View</a></button>
        </div>
    </div>
</body>
</html>
