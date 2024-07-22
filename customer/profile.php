<?php
include_once('../connection.php');
include_once('navbar.php');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../welcome.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    
</body>
</html>