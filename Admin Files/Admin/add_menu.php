<?php
include_once('../connection.php');
include_once('navbar.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $cousintype = $_POST['cousintype'];
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $image = basename($_FILES["image"]["name"]);

    $query = "INSERT INTO menu (item_id, name, description, price, category, cousintype, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssdsss", $item_id, $name, $description, $price, $category, $cousintype, $image);

    if (mysqli_stmt_execute($stmt)) {
        echo "Item added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
        echo "<br>Query: " . $query;
    }

    mysqli_stmt_close($stmt);
}

$query = "SELECT item_id, name, description, price, category, cousintype, image FROM menu";
$resultMenu = mysqli_query($conn, $query);

if (!$resultMenu) {
    echo "Error: " . mysqli_error($conn);
}

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
    <style>
        html {
            overflow-y: auto;
        }
        body{
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="item_id">Item ID:</label>
                <input type="text" name="item_id" required>

                <label for="name">Name:</label>
                <input type="text" name="name" required>

                <label for="description">Description:</label>
                <textarea name="description" required></textarea>

                <label for="price">Price:</label>
                <input type="number" name="price" step="0.01" required>

                <label for="category">Category:</label>
                <input type="text" name="category" required>

                <label for="cousintype">Cousin Type:</label>
                <input type="text" name="cousintype" required>

                <label for="image">Product Image:</label>
                <input type="file" name="image" required>

                <button type="submit">Add Item</button>
            </form>
        </div>
    </div>
</body>
</html>
