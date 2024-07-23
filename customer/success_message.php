<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>Payment Successful</h1>
        </div>
        <div class="container">
            <?php if (isset($_GET['reference'])): ?>
                <p>Your payment was successful and your cart has been cleared. Thank you for your purchase!</p>
                <p>Your payment reference number is: <strong><?php echo htmlspecialchars($_GET['reference']); ?></strong></p>
            <?php else: ?>
                <p>Your payment was successful and your cart has been cleared. Thank you for your purchase!</p>
            <?php endif; ?>
            <a href="menu.php" class="btn btn-primary">Back to Menu</a>
        </div>
    </div>
</body>
</html>
