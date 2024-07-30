<?php
include_once('connection.php');
$account = array();

$tableExistsQuery = "SHOW TABLES LIKE 'login_tbl'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {//initializing the post method
        $name = $_POST['name'];//creating and initizializing variables
        $username = $_POST['username'];
        $password = $_POST['password'];
        $profile = 'customer';
        $email = $_POST['email'];

        $insertQuery = "INSERT INTO login_tbl (name, username, password, profile, email) VALUES (?, ?, ?, ?, ?)";//data inserting into the database
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param('sssss', $name, $username, $password, $profile, $email);
        
        if ($stmt->execute()) {
            echo "New Account added successfully.";//if user creating sucess, this massage will print on the top of the page
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Creation</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-new.css">
</head>
<body>
<div class="container">
    <h2 class="text-topic">Create New Account</h2>
    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label><br>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label><br>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Email</label><br>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label><br>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn-add">Create</button><br> <br>
        <a href="welcome.php" class="btn-add2">Log In</a>
        <!-- <button type="submit" class="btn-add"></button><br> <br> -->
    </form>
</div>
</body>
</html>
