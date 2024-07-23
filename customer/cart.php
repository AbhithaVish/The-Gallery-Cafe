<?php
include_once('../connection.php');
include_once('navbar.php');

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';


$reservations = array();


$tableExistsQuery = "SHOW TABLES LIKE 'reservation'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 1) {
    $query = "SELECT * FROM cart WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    } else {
        echo "No cart found.";
    }
    $stmt->close();
} else {
    echo "Table 'cart' does not exist.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-Vreservation.css">
    <style>
        html{
            overflow-x: scroll;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Cart</h2>
        <div class="row">
            <?php foreach ($reservations as $reservation): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($reservation['name']); ?></h5>
                            <p class="card-text"><strong>Item_ID:</strong> <?php echo htmlspecialchars($reservation['item_id']); ?></p>
                            <p class="card-text"><strong>Price:</strong> <?php echo htmlspecialchars($reservation['price']); ?></p>
                            <p class="card-text"><strong>Added_date:</strong> <?php echo htmlspecialchars($reservation['added_date']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <center>
        <button class="btn-add" style="color:azure;">
            <a href="pay.php">Order Now</a>
        </button>
        </center>
    </div>
</body>
</html>
