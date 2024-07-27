<?php
include_once('../connection.php');
require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = "sk_test_51PfklnDFvPyG4fvuUh6ZfPSa5LBwdmWSlgABfkzEjUZeJH5YHDpHoHzWRKDrjYt325wJZSXY4ip4TY4tYfZ9cYnZ00AkL5f2Zd";
\Stripe\Stripe::setApiKey($stripe_secret_key);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];

    // Store the form data in the session for later use
    session_start();
    $_SESSION['form_data'] = [
        'username' => $username,
        'name' => $name,
        'nic' => $nic,
        'phone_no' => $phone_no,
        'address' => $address
    ];

    // Create a Stripe Checkout Session
    $checkout_session = \Stripe\Checkout\Session::create([
        "payment_method_types" => ["card"],
        "line_items" => [[
            "price_data" => [
                "currency" => "lkr",
                "product_data" => [
                    "name" => "Loyalty Program Registration"
                ],
                "unit_amount" => 100000, // Rs. 100 in cents
            ],
            "quantity" => 1
        ]],
        "mode" => "payment",
        "success_url" => "http://localhost:3000/customer/success_card.php",
        "cancel_url" => "http://localhost:3000/customer/cancel.php"
    ]);

    header("Location: " . $checkout_session->url);
    exit;
}
?>
