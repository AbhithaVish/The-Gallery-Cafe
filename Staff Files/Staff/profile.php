<?php
include_once('../connection.php');
include_once('navbar.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../welcome.php');
    exit;
}

$username = $_SESSION['username'];

// Fetch user profile data from the database
$query = "SELECT id, name, username, email, password FROM staff_tbl WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/style-profile.css">
</head>
<body>
    <div class="profile-container">
        <center>
             <h1>Edit Personal Details</h1>
        </center>
        <?php if ($user): ?>
            <form action="update_profile.php" method="post">
                <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                <p><strong>Name:</strong> <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"></p>
                <p><strong>Username:</strong> <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly></p>
                <p><strong>Email:</strong> <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"></p>
                <p><strong>Password:</strong> <input type="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>"></p>
                <p>Note : username can not be edited!</p>
                <div class="button-container">
                    <button type="submit" class="update-btn">Update Profile</button>
                    <button type="cancel" class="cancel-btn">
                        <a href="view_profile.php">Cancel</a>
                    </button>

                </div>
                
            </form>
        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
