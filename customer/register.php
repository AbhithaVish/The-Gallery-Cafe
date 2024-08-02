<?php
include_once('../connection.php');
include_once('navbar.php');
require __DIR__ . "/vendor/autoload.php";

// Stripe API key
$stripe_secret_key = "sk_test_51PfklnDFvPyG4fvuUh6ZfPSa5LBwdmWSlgABfkzEjUZeJH5YHDpHoHzWRKDrjYt325wJZSXY4ip4TY4tYfZ9cYnZ00AkL5f2Zd";
\Stripe\Stripe::setApiKey($stripe_secret_key);


// Handle form submission for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];

    // Store the form data in the session for later use
    $_SESSION['form_data'] = [
        'username' => $username,
        'name' => $name,
        'nic' => $nic,
        'phone_no' => $phone_no,
        'address' => $address
    ];

    try {
        // Create a Stripe Checkout Session
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
}

// Retrieve user data if already registered
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$query = $conn->prepare("SELECT * FROM loyalty_card WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$user_data = $result->fetch_assoc();

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
            <?php if (isset($message)): ?>
                alert("<?php echo addslashes($message); ?>");
            <?php endif; ?>
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
