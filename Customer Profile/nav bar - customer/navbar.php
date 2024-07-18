<?php

if(isset($_SESSION['username'])) {
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);

    $sql = "SELECT * FROM login_tbl WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $password = $row['password'];
        $name = $row['name'];

    } else {
        
        header("Location: index.php");
        exit();
    }
} else {
    
    header("Location: ../index.php");
    exit();

}

$activePage = basename($_SERVER['PHP_SELF'], ".php");
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
                <li><a href="../index.php" class="nav__link">Home</a></li>
                <li><a href="../../menu/menu.php" class="nav__link">Menu</a></li>
                <li><a href="../index.php" class="nav__link">Live</a></li>
                <li><a href="../order/order.php" class="nav__link">Order</a></li>
                <li><a href="../Customer Profile\reservation\reservation.phpindex.php" class="nav__link">Reservation</a></li>
                <li><a href="../../About/about.php" class="nav__link">About Us</a></li>
                <li>
                    <a href="../index.php" class="login" id="loginbutton">Log out</a>
                </li>
            </ul>
        </div>
    </nav>
</header>


</body>
</html>
