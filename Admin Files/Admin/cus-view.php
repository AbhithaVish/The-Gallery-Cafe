<?php
include_once('../connection.php');
include_once('navbar.php');

$editingUser = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $profile = $_POST['profile'];
        $sqlCheck = "SELECT 1 FROM `login_tbl` WHERE `username` = '$username' LIMIT 1";
        $result = $conn->query($sqlCheck);
        if ($result->num_rows == 0) {
            $sqlAddUser = "INSERT INTO `login_tbl` ( `name`, `username`, `email`, `password`, `profile`) VALUES ( '$name', '$username', '$email', '$password', '$profile')";
            $conn->query($sqlAddUser);
        } else {
            echo "Error: Username already exists.";
        }
    } elseif (isset($_POST['edit_user'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $profile = $_POST['profile'];
        $sqlEditUser = "UPDATE `login_tbl` SET `name` = '$name', `email` = '$email', `password` = '$password', `profile` = '$profile' WHERE `id` = '$id'";
        $conn->query($sqlEditUser);
    } elseif (isset($_POST['delete_user'])) {
        $id = $_POST['id'];
        $sqlDeleteUser = "DELETE FROM `login_tbl` WHERE `id` = '$id'";
        $conn->query($sqlDeleteUser);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['edit_user_id'])) {
        $id = $_GET['edit_user_id'];
        $sql = "SELECT * FROM `login_tbl` WHERE `id` = '$id' LIMIT 1";
        $result = $conn->query($sql);
        $editingUser = $result->fetch_assoc();
    }
}

$sqlUsers = "SELECT * FROM `login_tbl`";
$resultUsers = $conn->query($sqlUsers);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-live.css">
</head>
<body>
    <div class="main-container">
        <div class="topic">
            <h1>Manage Customer Profiles</h1>
        </div>
        <div class="container">
            <div class="table-container">
                <h2>Users</h2>
                
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Profile</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($resultUsers->num_rows > 0) {
                        while($row = $resultUsers->fetch_assoc()) {
                            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["username"]. "</td><td>" . $row["email"]. "</td><td>" . $row["profile"]. "</td>";
                            echo "<td><a href='?edit_user_id=" . $row["id"] . "'>Edit</a></td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data available</td></tr>";
                    }
                    ?>
                </table>
                <form method="post">
                    <h3><?php echo $editingUser ? 'Edit User' : 'Add User'; ?></h3>
                    <input type="text" name="name" placeholder="Name" value="<?php echo $editingUser['name'] ?? ''; ?>" required>
                    <input type="text" name="username" placeholder="Username" value="<?php echo $editingUser['username'] ?? ''; ?>" required>
                    <input type="email" name="email" placeholder="Email" value="<?php echo $editingUser['email'] ?? ''; ?>" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="text" name="profile" placeholder="Profile" value="<?php echo $editingUser['profile'] ?? ''; ?>" required>
                    <?php if ($editingUser): ?>
                        <button type="submit" name="edit_user" class="btn-class">Edit User</button>
                    <?php else: ?>
                        <button type="submit" name="add_user" class="btn-class">Add User</button>
                    <?php endif; ?>
                </form>
                <form method="post">
                    <h3>Delete User</h3>
                    <input type="text" name="id" placeholder="ID" required>
                    <button type="submit" name="delete_user" class="btn-delete">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
