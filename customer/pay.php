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
$total_price = 0;

while ($row = $resultCart->fetch_assoc()) {
    $cart_items[] = $row;
    $total_price += $row['price'] * $row['quantity']; // Calculate total price
    $line_items[] = [
        "quantity" => $row['quantity'],
        "price_data" => [
            "currency" => "lkr",
            "unit_amount" => $row['price'] * 100, // Stripe expects the amount in cents
            "product_data" => [
                "name" => $row['name']
            ]
        ]
    ];
}

$discounted_total_price = $total_price;
$card_valid = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_card_no = $_POST['card_no'];
    if (!empty($entered_card_no)) {
        $query = $conn->prepare("SELECT * FROM loyalty_card WHERE card_no = ?");
        $query->bind_param("s", $entered_card_no);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            $card_valid = true;
            $discounted_total_price = $total_price * 0.85; // Apply 15% discount
        }
    }
}

if (count($line_items) > 0) {
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "success_url" => "http://localhost:3000/customer/success.php", // Update this URL
        "cancel_url" => "http://localhost:3000/customer/cancel.php",
        "line_items" => [[
            "quantity" => 1,
            "price_data" => [
                "currency" => "lkr",
                "unit_amount" => $discounted_total_price * 100, // Apply the discounted total price
                "product_data" => [
                    "name" => "Total Cart Items"
                ]
            ]
        ]]
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
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-live.css">
    <link rel="stylesheet" href="style/style-pay.css">
    <style>
        html {
            overflow-y: scroll;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>Pay Here</h1>
        </div>
        <div class="container123">
            <div class="table-container">
                <h2>Your Cart Items</h2>
                <table>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Added Date</th>
                    </tr>
                    <?php
                    if (count($cart_items) > 0) {
                        foreach ($cart_items as $item) {
                            echo "<tr><td>" . htmlspecialchars($item['item_id']) . "</td><td>" . htmlspecialchars($item['name']) . "</td><td>" . number_format($item['price'], 2) . "</td><td>" . htmlspecialchars($item['quantity']) . "</td><td>" . htmlspecialchars($item['added_date']) . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No items in cart</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="total-container">
                <h2>Total:
                <span><?php echo number_format($total_price, 2); ?> LKR</span>
                </h2>
            </div>
            <?php if ($card_valid): ?>
                <div class="discount-container">
                    <h2>Discounted Total:
                    <span><?php echo number_format($discounted_total_price, 2); ?> LKR</span>
                    </h2>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <br>
                <label for="card_no">Enter Card Number for Discount:</label>
                <input type="text" id="card_no" name="card_no"><br>
                <button type="submit" class="btn-pay">Apply Discount</button>
            </form>
            <br>
            <div class="pay-button">
                <center>
                <button class="btn-pay">
                    <?php if (count($line_items) > 0): ?>
                        <a href="<?php echo htmlspecialchars($checkout_url); ?>">Checkout</a>
                    <?php endif; ?>
                </button>
                </center>
            </div>
        </div>
    </div>
</body>
</html>
