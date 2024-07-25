<?php
include_once('../connection.php');
include_once('navbar.php');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the user input from the form
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $cousintype = $_POST['cousintype'];

    // Insert user data into the database
    $query = "INSERT INTO menu (item_id, name, description, price, category, cousintype) VALUES (?, ?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssds", $item_id, $name, $description, $category, $price, $cousintype);

    if (mysqli_stmt_execute($stmt)) {
        echo "User added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu</title>
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/style-menu.css">

</head>
<body>
    <h1>Add Menu</h1>
    <form action="" method="POST">
        <label for="item_id">Item ID:</label>
        <input type="text" name="item_id" required><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="description">Description:</label>
        <input type="text" name="description" required><br>

        <label for="category">Category:</label>
        <input type="text" name="category" required><br>
        
        <label for="cousintype">cousintype:</label>
        <input type="text" name="cousintype" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required><br>

        <input type="submit" value="Add User">
    </form>
</body>
</html>
