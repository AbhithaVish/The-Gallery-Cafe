<?php
include_once('../connection.php');
include_once('navbar.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../welcome.php');
    exit;
}

$username = $_SESSION['username'];

if (isset($_GET['category'])) {
    $category = htmlspecialchars($_GET['category']);

    // Fetch items by category
    $sql = "SELECT * FROM menu WHERE category = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
} else {
    echo "No category selected!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['qty']); // Ensure quantity is an integer

    // Fetch item details
    $item_sql = "SELECT * FROM menu WHERE item_id = ?";
    if ($stmt = $conn->prepare($item_sql)) {
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $item_result = $stmt->get_result();
        $item = $item_result->fetch_assoc();
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }

    if ($item) {
        $name = $item['name'];
        $price = $item['price'];
        $added_date = date('Y-m-d H:i:s');

        // Add to cart table
        $cart_sql = "INSERT INTO cart (item_id, name, price, quantity, username, added_date) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($cart_sql)) {
            $stmt->bind_param("ississ", $item_id, $name, $price, $quantity, $username, $added_date);
            if ($stmt->execute()) {
                $message = "Item added to cart.";
            } else {
                $message = "Error adding item to cart: " . $stmt->error;
                error_log("Error adding item to cart: " . $stmt->error);
            }
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
            error_log("Error preparing statement: " . $conn->error);
        }
    } else {
        $message = "Item not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category: <?= $category; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style/style-menu.css">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<section class="products">

    <h1 class="title">Category: <?= $category; ?></h1>

    <div class="box-container">

        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
        <form action="" method="post" class="box">
            <input type="hidden" name="item_id" value="<?= htmlspecialchars($row['item_id']); ?>">
            <input type="hidden" name="name" value="<?= htmlspecialchars($row['name']); ?>">
            <input type="hidden" name="price" value="<?= htmlspecialchars($row['price']); ?>">
            <input type="hidden" name="image" value="<?= htmlspecialchars($row['image']); ?>">
            <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
            <img src="uploaded_img/<?= htmlspecialchars($row['image']); ?>" alt="">
            <div class="name"><?= htmlspecialchars($row['name']); ?></div>
            <div class="flex">
                <div class="price"><span>Rs.</span><?= htmlspecialchars($row['price']); ?></div>
                <input type="number" name="qty" class="qty" value="1" min="1">
            </div>
        </form>
        <?php
            }
        } else {
            echo '<p class="empty">No products found in this category!</p>';
        }
        ?>

    </div>

</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>

<?php
$conn->close();
?>
