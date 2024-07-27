<?php
include_once('../connection.php');
include_once('navbar.php');

if (isset($_SESSION['form_data'])) {
    $username = $_SESSION['form_data']['username'];
    $name = $_SESSION['form_data']['name'];
    $nic = $_SESSION['form_data']['nic'];
    $phone_no = $_SESSION['form_data']['phone_no'];
    $address = $_SESSION['form_data']['address'];

    // Generate a unique card number
    $isUnique = false;
    do {
        $card_no = uniqid('CARD-', true); // Example card number generation
        $query = $conn->prepare("SELECT * FROM loyalty_card WHERE card_no = ?");
        $query->bind_param("s", $card_no);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows == 0) {
            $isUnique = true;
        }
    } while (!$isUnique);

    // Set the expiry date to one year from today
    $expiry_date = date('Y-m-d', strtotime('+1 year'));

    $query = $conn->prepare("INSERT INTO loyalty_card (username, name, nic, phone_no, address, card_no, points, expiry_date) VALUES (?, ?, ?, ?, ?, ?, 0, ?)");
    $query->bind_param("sssssss", $username, $name, $nic, $phone_no, $address, $card_no, $expiry_date);

    if ($query->execute()) {
        $message = "Registration successful! Your card number is " . htmlspecialchars($card_no);
    } else {
        $message = "Error: " . $query->error;
    }

    // Clear session form data
    unset($_SESSION['form_data']);
} else {
    $message = "No form data found. Please register again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script>
        window.onload = function() {
            alert("<?php echo addslashes($message); ?>");
        };
    </script>
</head>
<body>
</body>
</html>
