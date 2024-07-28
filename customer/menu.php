<?php
include_once('../connection.php');
include_once('navbar.php');

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
        $added_date = date('Y-m-d H:i:s');

        // Add to cart table
        $cart_sql = "INSERT INTO cart (item_id, name, price, username, added_date) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($cart_sql)) {
            $stmt->bind_param("issss", $item_id, $name, $price, $username, $added_date);
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

// Fetch distinct categories
$category_sql = "SELECT DISTINCT category FROM menu";
$category_result = $conn->query($category_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style/style-menu.css">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<section class="categories">

    <h1 class="title">Categories</h1>

    <div class="box-container">
        <center>
        <?php
        if ($category_result && $category_result->num_rows > 0) {
            while ($row = $category_result->fetch_assoc()) {
                $category = htmlspecialchars($row['category']);
        ?>
        <form action="category.php" method="get" class="box">
            <input type="hidden" name="category" value="<?= $category; ?>">
            <button type="submit" class="btn"><?= $category; ?></button>
        </form>
        <?php
            }
        } else {
            echo '<p class="empty">No categories available!</p>';
        }
        ?>
        </center>


    </div>

</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>

<?php
$conn->close();
?>
