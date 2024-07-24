<?php
include_once('../connection.php');
include_once('navbar.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../welcome.php');
    exit;
}

// Fetch user profile data from the database
$username = $_SESSION['username'];
$query = "SELECT id, name, username, email, password FROM staff_tbl WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="style/style-viewprofile.css">
</head>
<body>
    <div class="profile-container">
        <h1>User Profile</h1>
        <?php if ($user): ?>
            <center>
            <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Password:</strong> <?php echo htmlspecialchars($user['password']); ?></p>
            <button type="submit">
                <a href="profile.php">Edit Profile</a>
            </button>
        <?php else: ?>
            <p>User not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

