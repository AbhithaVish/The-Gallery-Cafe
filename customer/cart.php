<?php
include_once('../connection.php');
include_once('navbar.php');

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$reservations = array();

function showCartItems($conn, $username) {
    $query = "SELECT * FROM cart WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $reservations = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    }
    $stmt->close();
    
    return $reservations;
}

function addToQuantity($conn, $username, $item_id, $quantity) {
    $query = "UPDATE cart SET quantity = quantity + ? WHERE username = ? AND item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isi', $quantity, $username, $item_id);
    $stmt->execute();
    $stmt->close();
}

function deleteFromCart($conn, $username, $item_id) {
    $query = "DELETE FROM cart WHERE username = ? AND item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $username, $item_id);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            addToQuantity($conn, $username, $_POST['item_id'], $_POST['quantity']);
        } elseif ($_POST['action'] == 'delete') {
            deleteFromCart($conn, $username, $_POST['item_id']);
        }
    }
}

$tableExistsQuery = "SHOW TABLES LIKE 'cart'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 1) {
    $reservations = showCartItems($conn, $username);
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
    <title>Cart</title>
    <link rel="stylesheet" href="style/style-Vreservation.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            overflow-y: scroll;
        }
        .cancel-btn {
            padding: 10px 20px;
            background-color: #f30202;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .cancel-btn:hover {
            background-color: #000000a9;
        }
        .add-btn {
            padding: 10px 20px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-btn:hover {
            background-color: #45a049;
        }
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .container1-fluid {
            padding-top: 60px;
        }
    </style>
</head>
<body>
    <div class="container1-fluid">
        <br><br><br><br><br><br>
        <div class="container-cart">
            <div class="row">
                <?php foreach ($reservations as $reservation): ?>
                    <div class="col-md-3">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($reservation['name']); ?></h5>
                                <p class="card-text"><strong>Item_ID:</strong> <?php echo htmlspecialchars($reservation['item_id']); ?></p>
                                <p class="card-text"><strong>Price:</strong> <?php echo htmlspecialchars($reservation['price']); ?></p>
                                <p class="card-text"><strong>Quantity:</strong> <?php echo htmlspecialchars($reservation['quantity']); ?></p>
                                <p class="card-text"><strong>Added_date:</strong> <?php echo htmlspecialchars($reservation['added_date']); ?></p>
                                <form method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $reservation['item_id']; ?>">
                                    <input type="hidden" name="action" value="add">
                                    <input type="number" name="quantity" value="1" min="1">
                                    <br>
                                    <button type="submit" class="add-btn">Add Quantity</button>
                                </form>
                                <form method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $reservation['item_id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <br>
                                    <button type="submit" class="cancel-btn">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <center>
            <br><br><br><br><br><br><br><br><br>
            <button class="add-btn">
                <a href="pay.php" style="color: white;">Order Now</a>
            </button>
        </center>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
