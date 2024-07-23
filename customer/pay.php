<?php
include_once('../connection.php');
include_once('navbar.php');


$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

$sqlCart = "SELECT * FROM `cart` WHERE username=?";
$stmtCart = $conn->prepare($sqlCart);
$stmtCart->bind_param('s', $username);
$stmtCart->execute();
$resultCart = $stmtCart->get_result();

require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = "sk_test_51PfklnDFvPyG4fvuUh6ZfPSa5LBwdmWSlgABfkzEjUZeJH5YHDpHoHzWRKDrjYt325wJZSXY4ip4TY4tYfZ9cYnZ00AkL5f2Zd";
\Stripe\Stripe::setApiKey($stripe_secret_key);

$line_items = [];
$cart_items = [];
while ($row = $resultCart->fetch_assoc()) {
    $cart_items[] = $row;
    $line_items[] = [
        "quantity" => 1,
        "price_data" => [
            "currency" => "lkr",
            "unit_amount" => $row['price'] * 100, // Stripe expects the amount in cents
            "product_data" => [
                "name" => $row['name']
            ]
        ]
    ];
}

if (count($line_items) > 0) {
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "success_url" => "http://localhost:3000/customer/success.php", // Update this URL
        "cancel_url" => "http://localhost:3000/customer/cancel.php",
        "line_items" => $line_items
    ]);

    $checkout_url = $checkout_session->url;
} else {
    $checkout_url = "#"; // No items in the cart
}

$stmtCart->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-live.css">
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>Pay Here</h1>
        </div>
        <div class="container">
            <div class="table-container">
                <h2>Your Cart Items</h2>
                <table>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Added Date</th>
                    </tr>
                    <?php
                    if (count($cart_items) > 0) {
                        foreach ($cart_items as $item) {
                            echo "<tr><td>" . htmlspecialchars($item['item_id']) . "</td><td>" . htmlspecialchars($item['name']) . "</td><td>" . number_format($item['price'], 2) . "</td><td>" . htmlspecialchars($item['added_date']) . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No items in cart</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="pay-button">
                <?php if (count($line_items) > 0): ?>
                    <a href="<?php echo htmlspecialchars($checkout_url); ?>" class="btn btn-primary">Checkout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
