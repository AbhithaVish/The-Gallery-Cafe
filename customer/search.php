<?php
include_once('navbar.php');
include_once('../connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="style-search.css">
</head>
<body>
    <form method="post">
        <label>Search</label>
        <input type="text" name="search" required>
        <input type="submit" name="submit" value="Search">
    </form>
</body>
</html>

<?php
    if (isset($_POST["submit"])) {
        $str = $_POST["search"];
        $str = $conn->real_escape_string($str);  
        $sql = "SELECT * FROM menu WHERE name = '$str'";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <br><br><br>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><img src="path_to_images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>"></td>
                </tr>
            </table>
            <?php
        } else {
            echo "That item does not exist.";
        }
    }
?>