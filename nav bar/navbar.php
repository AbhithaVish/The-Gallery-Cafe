<?php
include_once('connection.php');

if(isset($_SESSION['username'])) {
    // Sanitize the username to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    
    // Prepare and execute the SQL query to fetch user's name
    $sql = "SELECT * FROM login_tbl WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    // Check if query executed successfully and user exists
    if($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $password = $row['password'];
        $name = $row['name'];
        
    } else {
        // Redirect to login page if user does not exist
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to login page if user is not logged in
    header("Location: index.php");
    exit();

}

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
        <div class="nav__data">
            <a href="index.html" class="nav__logo">
                <i class="ri-planet-line"></i> The Gallery Cafe
            </a>
            <div class="nav__toggle">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li><a href="index.php" class="nav__link">Home</a></li>
                <li><a href="index.php" class="nav__link">Menu</a></li>
                <li><a href="index.php" class="nav__link">Live</a></li>
                <li><a href="index.php" class="nav__link">Order</a></li>
                <li><a href="index.php" class="nav__link">Reservation</a></li>
                <li><a href="../About/about.php" class="nav__link">About Us</a></li>
                <li>
                    <a href="../welcome.php" class="login" id="loginbutton">Log In</a>
                </li>
            </ul>
        </div>
    </nav>

    </header>
    
</body>
</html>