<?php
include_once('../connection.php');
include_once('navbar.php');

$editingUser = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $profile = $_POST['profile'];
        $sqlCheck = "SELECT 1 FROM `staff_tbl` WHERE `username` = '$username' LIMIT 1";
        $result = $conn->query($sqlCheck);
        if ($result->num_rows == 0) {
            $sqlAddUser = "INSERT INTO `staff_tbl` ( `name`, `username`, `email`, `password`, `profile`) VALUES ( '$name', '$username', '$email', '$password', '$profile')";
            $conn->query($sqlAddUser);
        } else {
            echo "Error: Username already exists.";
        }
    } elseif (isset($_POST['edit_user'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $profile = $_POST['profile'];
        $sqlEditUser = "UPDATE `staff_tbl` SET `name` = '$name', `username` = '$username', `email` = '$email', `password` = '$password', `profile` = '$profile' WHERE `id` = '$id'";
        $conn->query($sqlEditUser);
    } elseif (isset($_POST['delete_user'])) {
        $id = $_POST['id'];
        $sqlDeleteUser = "DELETE FROM `staff_tbl` WHERE `id` = '$id'";
        $conn->query($sqlDeleteUser);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['edit_user_id'])) {
        $id = $_GET['edit_user_id'];
        $sql = "SELECT * FROM `staff_tbl` WHERE `id` = '$id' LIMIT 1";
        $result = $conn->query($sql);
        $editingUser = $result->fetch_assoc();
    }
}

$sqlUsers = "SELECT * FROM `staff_tbl`";
$resultUsers = $conn->query($sqlUsers);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style/style-menu.css">
    <link rel="stylesheet" href="style/style-profile.css">
</head>
<body>
<div class="container">
    <div class="main-box">
        <h1>Manage Staff Profiles</h1>
        <div class="view-table">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Profile</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($resultUsers->num_rows > 0) {
                    while($row = $resultUsers->fetch_assoc()) {
                        echo "<tr><td>" . htmlspecialchars($row["id"]) . "</td>
                                  <td>" . htmlspecialchars($row["name"]) . "</td>
                                  <td>" . htmlspecialchars($row["username"]) . "</td>
                                  <td>" . htmlspecialchars($row["email"]) . "</td>
                                  <td>" . htmlspecialchars($row["profile"]) . "</td>
                                  <td>
                                      <a href='?edit_user_id=" . htmlspecialchars($row["id"]) . "'>Edit</a>
                                      <form method='post' action='' style='display:inline-block;'>
                                          <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                                          <button type='submit' name='delete_user' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</button>
                                      </form>
                                  </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data available</td></tr>";
                }
                ?>
            </table>
        </div>
        <div class="form-container">
            <form method="post">
                <h3><?php echo $editingUser ? 'Edit User' : 'Add User'; ?></h3>
                <?php if ($editingUser): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editingUser['id']); ?>">
                <?php endif; ?>
                <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($editingUser['name'] ?? ''); ?>" required>
                <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($editingUser['username'] ?? ''); ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($editingUser['email'] ?? ''); ?>" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="text" name="profile" placeholder="Profile" value="<?php echo htmlspecialchars($editingUser['profile'] ?? ''); ?>" required>
                <?php if ($editingUser): ?>
                    <button type="submit" name="edit_user" class="btn-class">Edit User</button>
                <?php else: ?>
                    <button type="submit" name="add_user" class="btn-class">Add User</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>
