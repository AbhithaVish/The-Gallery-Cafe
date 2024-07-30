<?php
include_once('../connection.php');
include_once('navbar.php');
require __DIR__ . "/vendor/autoload.php";//file path for the stipe payment page


// Stripe API key
$stripe_secret_key = "sk_test_51PfklnDFvPyG4fvuUh6ZfPSa5LBwdmWSlgABfkzEjUZeJH5YHDpHoHzWRKDrjYt325wJZSXY4ip4TY4tYfZ9cYnZ00AkL5f2Zd";
\Stripe\Stripe::setApiKey($stripe_secret_key);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];

    $_SESSION['form_data'] = [
        'username' => $username,
        'name' => $name,
        'nic' => $nic,
        'phone_no' => $phone_no,
        'address' => $address
    ];

    try {
        // stripe Checkout Session
        $checkout_session = \Stripe\Checkout\Session::create([
            "payment_method_types" => ["card"],
            "line_items" => [[
                "price_data" => [
                    "currency" => "lkr",
                    "product_data" => [
                        "name" => "Loyalty Program Registration"
                    ],
                    "unit_amount" => 100000, 
                ],
                "quantity" => 1
            ]],
            "mode" => "payment",
            "success_url" => "http://localhost:3000/customer/success_card.php",
            "cancel_url" => "http://localhost:3000/customer/cancel.php"
        ]);

        header("Location: " . $checkout_session->url);
        exit;
    } catch (Exception $e) {
        echo "Error creating Stripe Checkout Session: " . $e->getMessage();
    }
} elseif (isset($_SESSION['form_data'])) {
    $username = $_SESSION['form_data']['username'];
    $name = $_SESSION['form_data']['name'];
    $nic = $_SESSION['form_data']['nic'];
    $phone_no = $_SESSION['form_data']['phone_no'];
    $address = $_SESSION['form_data']['address'];

    // generate a unique card number
    $isUnique = false;
    do {
        $card_no = uniqid('CARD-', true); // example card number generation
        $query = $conn->prepare("SELECT * FROM loyalty_card WHERE card_no = ?");
        $query->bind_param("s", $card_no);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows == 0) {
            $isUnique = true;
        }
    } while (!$isUnique);

    // expiry date set to one year from the payment date
    $expiry_date = date('Y-m-d', strtotime('+1 year'));

    $query = $conn->prepare("INSERT INTO loyalty_card (username, name, nic, phone_no, address, card_no, points, expiry_date) VALUES (?, ?, ?, ?, ?, ?, 0, ?)");
    $query->bind_param("sssssss", $username, $name, $nic, $phone_no, $address, $card_no, $expiry_date);

    if ($query->execute()) {
        $message = "Registration successful! Your card number is " . htmlspecialchars($card_no);
    } else {
        $message = "Error: " . $query->error;
    }

    // clear session form data
    unset($_SESSION['form_data']);

    // retrieve the inserted user data
    $query = $conn->prepare("SELECT * FROM loyalty_card WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user_data = $result->fetch_assoc();
} else {
    $message = "No form data found. Please register again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Program Registration</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-card.css">
    <style>
        body {
            margin-top: 150px;
        }
    </style>
    <script>
        window.onload = function() {
            alert("<?php echo addslashes($message); ?>");
        };
    </script>
</head>
<body>
    <?php if (isset($user_data)): ?>
        <h2>Welcome back, <?php echo htmlspecialchars($user_data['name']); ?>!</h2>
        <table border="1">
            <tr>
                <th>Card Number</th>
                <th>Expiry Date</th>
                <th>NIC</th>
                <th>Phone Number</th>
                <th>Address</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($user_data['card_no']); ?></td>
                <td><?php echo htmlspecialchars($user_data['expiry_date']); ?></td>
                <td><?php echo htmlspecialchars($user_data['nic']); ?></td>
                <td><?php echo htmlspecialchars($user_data['phone_no']); ?></td>
                <td><?php echo htmlspecialchars($user_data['address']); ?></td>
            </tr>
        </table>
    <?php else: ?>
        <h2>Register for the Loyalty Program</h2>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" required><br>

            <label for="phone_no">Phone Number:</label>
            <input type="text" id="phone_no" name="phone_no" required><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea><br>
            <button type="submit">Register</button>
        </form>
    <?php endif; ?>
</body>
</html>
