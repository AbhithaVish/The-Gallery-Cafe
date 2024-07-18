<?php

session_start();

include_once('..\..\connection.php');
include_once('..\nav bar - customer/navbar.php');

//menu table from the database
$sql = "SELECT id, name, description, price, cousintype FROM menu";
$result = $conn->query($sql);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (!in_array($item_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $item_id;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="..\nav bar - customer\style.css">
    <link rel="stylesheet" href="style-menu.css">
</head>
<body>
    <br><br><br><br><br>

    <div class="menu-container">
        <center>
            <h1>Menu</h1>
        </center>
        <?php if ($result->num_rows > 0): ?>
            <table>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Cuisine Type</th>
                        <th>Action</th>
                    </tr>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['cousintype']); ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="add_to_cart">Add to Cart</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No menu items available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
