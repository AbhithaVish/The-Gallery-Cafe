<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../connection.php');
include_once('navbar.php');

function getCount($tableName) {
    global $conn;

    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM $tableName");
    $stmt->execute();
    $result = $stmt->get_result();

    // getting the result and return the count
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalCount = $row['count'];
        return $totalCount;
    } else {
        return 0; 
    }
}

$loginCount = getCount('login_tbl');
$orderCount = getCount('orders');
$reservationCount = getCount('reservation');


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .round-banner img {
            margin-top: 400px;
            width: 100vw;
            height: auto;
            max-width: 350px; 
        }
        @media screen and (max-width: 600px) {
            .round-banner img {
                width: 40vw; 
                max-width: 150px;
            }
        }
    </style>
</head>
<body>   
    
<video autoplay muted loop id="myVideo">
  <source src="Videos/background video.mp4" type="video/mp4">
</video>

    

    <div class="container1">
    <div class="counter-wrapper">
        <div class="counter-box colored">
            <i class="fa fa-thumbs-o-up"></i>
            <span class="counter"><?= $loginCount ?></span>
            <p>Customers</p>
        </div>

        <div class="counter-box colored">
            <i class="fa fa-thumbs-o-up"></i>
            <span class="counter"><?= $orderCount ?></span>
            <p>Orders</p>
        </div>

        <div class="counter-box colored">
            <i class="fa fa-thumbs-o-up"></i>
            <span class="counter"><?= $reservationCount ?></span>
            <p>Reservations</p>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    $('.counter').each(function() {
        var $this = $(this);
        var countTo = parseInt($this.text(), 10);
        
        $({ countNum: 0 }).animate({ countNum: countTo }, {
            duration: 4000,
            easing: 'swing',
            step: function() {
                $this.text(Math.ceil(this.countNum));
            },
            complete: function() {
                $this.text(countTo);
            }
        });
    });
});
</script>

</body>
</html>
