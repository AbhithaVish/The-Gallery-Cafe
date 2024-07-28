<?php
include_once('../connection.php');
include_once('navbar.php');

// Handle form submission for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];

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
        // Redirect to register.php after successful registration
        header('Location: register.php');
        exit();
    } else {
        $message = "Error: " . $query->error;
    }
} else {
    // Retrieve user data if already registered
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $query = $conn->prepare("SELECT * FROM loyalty_card WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user_data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Program</title>
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
