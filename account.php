<?php
include_once('connection.php');
$account = array();

$tableExistsQuery = "SHOW TABLES LIKE 'login_tbl'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult->num_rows == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        
        $checkUsernameQuery = "SELECT * FROM login_tbl WHERE username = ?";
        $stmt = $conn->prepare($checkUsernameQuery);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        // see whether username is available or not
        if ($result->num_rows > 0) {
            echo "Username already taken. Please choose a different username.";
        } else {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
            $profile = 'customer';

            $insertQuery = "INSERT INTO login_tbl (name, username, password, profile, email) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param('sssss', $name, $username, $password, $profile, $email);
            
            if ($stmt->execute()) {
                echo "New Account added successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
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
    <script src="script.js"></script>
</head>
<body>
<div class="container">
    <h2 class="text-topic">Create New Account</h2>
    <form method="post" action="" onsubmit="return validateForm()">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label><br>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label><br>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label><br>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label><br>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label><br>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <p style="color: black;">You are accepting <a href="conditions.php">Terms and Conditions</a> by creating this Account.</p>
        <button type="submit" class="btn-add">Create</button><br><br>
        <a href="welcome.php" class="btn-add2">Log In</a>
    </form>
</div>
</body>
</html>
