<?php
include_once('../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];

    $query = "DELETE FROM menu WHERE item_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $item_id);

    if ($stmt->execute()) {
        echo "Menu item deleted successfully.";
    } else {
        echo "Error deleting menu item: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: view_menu.php");
    exit();
}
?>
