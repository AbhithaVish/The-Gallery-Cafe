<?php
include_once('../connection.php');
include_once('navbar.php');

// Fetch all data from the menu table
$query = "SELECT * FROM menu";
$stmt = $conn->prepare($query);
$stmt->execute();
$resultMenu = $stmt->get_result();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Menu</title>
    <link rel="stylesheet" href="style/style-menu.css">
</head>
<body>
<div class="view-table">
    <table>
        <tr>
            <th>Item ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Cuisine Type</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($resultMenu->num_rows > 0) {
            while ($row = $resultMenu->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row["item_id"]) . "</td>
                          <td>" . htmlspecialchars($row["name"]) . "</td>
                          <td>" . htmlspecialchars($row["description"]) . "</td>
                          <td>" . htmlspecialchars($row["category"]) . "</td>
                          <td>" . htmlspecialchars($row["cousintype"]) . "</td>
                          <td>" . htmlspecialchars($row["price"]) . "</td>
                          <td>
                              <form method='post' action='edit_menu.php' style='display:inline-block;'>
                                  <input type='hidden' name='item_id' value='" . htmlspecialchars($row["item_id"]) . "'>
                                  <button type='submit'>Edit</button>
                              </form>
                              <form method='post' action='delete_menu.php' style='display:inline-block;'>
                                  <input type='hidden' name='item_id' value='" . htmlspecialchars($row["item_id"]) . "'>
                                  <button type='submit' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</button>
                              </form>
                          </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No items available</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
