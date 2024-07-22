<?php
include_once('../connection.php');

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../welcome.php');
    exit;
}

$username = $_SESSION['username'];
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$contact = isset($_SESSION['contact']) ? $_SESSION['contact'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']); // Ensure item_id is an integer
    error_log("Received item_id: " . $item_id); // Debugging

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
        $order_date = date('Y-m-d');

        // Add to orders table
        $order_sql = "INSERT INTO orders (item_id, name, price, username, order_date, address, contact) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($order_sql)) {
            $stmt->bind_param("issssss", $item_id, $name, $price, $username, $order_date, $address, $contact);
            if ($stmt->execute()) {
                $message = "Item added to cart.";
            } else {
                $message = "Error adding item to cart: " . $stmt->error;
                error_log("Error adding item to cart: " . $stmt->error); // Debugging
            }
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
            error_log("Error preparing statement: " . $conn->error); // Debugging
        }
    } else {
        $message = "Item not found.";
    }
}

// Fetch menu items
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>menu</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
    <h3>our menu</h3>
    <p><a href="home.php">home</a> <span> / menu</span></p>
</div>

<!-- menu section starts  -->

<section class="products">

    <h1 class="title">latest dishes</h1>

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
            <a href="quick_view.php?pid=<?= htmlspecialchars($row['item_id']); ?>" class="fas fa-eye"></a>
            <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
            <img src="uploaded_img/<?= htmlspecialchars($row['image']); ?>" alt="">
            <a href="category.php?category=<?= htmlspecialchars($row['cousintype']); ?>" class="cat"><?= htmlspecialchars($row['cousintype']); ?></a>
            <div class="name"><?= htmlspecialchars($row['name']); ?></div>
            <div class="flex">
                <div class="price"><span>Rs.</span><?= htmlspecialchars($row['price']); ?></div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
            </div>
        </form>
        <?php
            }
        } else {
            echo '<p class="empty">no products added yet!</p>';
        }
        ?>

    </div>

</section>

<!-- menu section ends -->

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>

<?php
$conn->close();
?>
