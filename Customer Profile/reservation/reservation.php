<?php
session_start();

include_once('..\..\connection.php');
include_once('..\nav bar - customer/navbar.php');

if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit;
}
$username = $_SESSION['username'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="..\nav bar - customer\style.css">
    <link rel="stylesheet" href="style-reservation.css">
</head>
<body>
    <div class="container">
        <div class="view-reservations">
            <div class="main-box">
                <h1>View All Reservations</h1>
                <button  class="button-click"><a href="viewReservations.php">View</a></button>
            </div>
        </div>

        <div class="add-reservations">
        <div class="main-box">
                <h1>Add Reservations</h1>
                <button class="button-click"><a href="viewReservations.php">View</a></button>
            </div>
        </div>
    </div>
</body>
</html>