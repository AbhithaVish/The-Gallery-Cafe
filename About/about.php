<?php
// Start the session 
session_start();

// Include the database connection
include_once('../connection.php');

include_once('../nav bar/navbar.php');

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br><br><br><br><br><br>
    <p>hi there</p>
</body>
</html>