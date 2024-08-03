<?php
include_once('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-payment.css">
</head>
<body>
    <div class="main-container">
        <center>
        <div class="topic">
            <h1>Payment Successful!</h1>
        </div>
        <div class="container">
            <?php if (isset($_GET['reference'])): ?>
                <p>Your payment was successful and your cart has been cleared. Thank you for your purchase!</p><br>
                <p>Your payment reference number is: <h1><br> <strong><?php echo htmlspecialchars($_GET['reference']); ?></strong></h1></p><br>
            <?php else: ?>
                <p>Your payment was successful and your cart has been cleared. Thank you for your purchase!</p>
            <?php endif; ?>
            <button class="back-btn">
                <a href="menu.php" class="btn btn-primary">Back to Menu</a>
            </button>

        </div>
        </center>
    </div>
</body>
</html>
