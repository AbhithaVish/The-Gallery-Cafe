<?php
include_once('../connection.php');
include_once('navbar.php');

$editingUser = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sqlCheck = "SELECT 1 FROM `staff_tbl` WHERE `username` = ? LIMIT 1";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $username);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows == 0) {
            $sqlAddUser = "INSERT INTO `staff_tbl` (`name`, `username`, `email`, `password`) VALUES (?, ?, ?, ?)";
            $stmtAddUser = $conn->prepare($sqlAddUser);
            $stmtAddUser->bind_param("ssss", $name, $username, $email, $password);
            $stmtAddUser->execute();
        } else {
            echo "Error: Username already exists.";
        }
    } elseif (isset($_POST['edit_user'])) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $sqlEditUser = "UPDATE `staff_tbl` SET `name` = ?, `username` = ?, `email` = ?, `password` = ? WHERE `id` = ?";
        $stmtEditUser = $conn->prepare($sqlEditUser);
        $stmtEditUser->bind_param("ssssi", $name, $username, $email, $password, $id);
        $stmtEditUser->execute();
    } elseif (isset($_POST['delete_user'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $sqlDeleteUser = "DELETE FROM `staff_tbl` WHERE `id` = ?";
        $stmtDeleteUser = $conn->prepare($sqlDeleteUser);
        $stmtDeleteUser->bind_param("i", $id);
        $stmtDeleteUser->execute();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['edit_user_id'])) {
        $id = filter_input(INPUT_GET, 'edit_user_id', FILTER_SANITIZE_NUMBER_INT);
        $sql = "SELECT * FROM `staff_tbl` WHERE `id` = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
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
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style-live.css">
</head>
<body>
    <center>
    <div class="main-container">
        <div class="topic">
            <h1>Manage Staff Profiles</h1>
        </div>
        <div class="container">
            <div class="table-container">
                <h2>Users</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if ($resultUsers->num_rows > 0) {
                        while($row = $resultUsers->fetch_assoc()) {
                            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["username"]. "</td><td>" . $row["email"]. "</td>";
                            echo "<td><a href='?edit_user_id=" . $row["id"] . "'>Edit</a></td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data available</td></tr>";
                    }
                    ?>
                </table>
                <form method="post">
                    <h3><?php echo $editingUser ? 'Edit User' : 'Add User'; ?></h3>
                    <input type="text" name="name" placeholder="Name" value="<?php echo $editingUser['name'] ?? ''; ?>" required>
                    <input type="text" name="username" placeholder="Username" value="<?php echo $editingUser['username'] ?? ''; ?>" required>
                    <input type="email" name="email" placeholder="Email" value="<?php echo $editingUser['email'] ?? ''; ?>" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <?php if ($editingUser): ?>
                        <input type="hidden" name="id" value="<?php echo $editingUser['id']; ?>">
                        <button type="submit" name="edit_user" class="btn-class">Edit User</button>
                    <?php else: ?>
                        <button type="submit" name="add_user" class="btn-class">Add User</button>
                    <?php endif; ?>
                </form>
                <form method="post">
                    <h3>Delete User</h3>
                    <input type="text" name="id" placeholder="Enter id" required>
                    <button type="submit" name="delete_user" class="btn-delete">Delete User</button>
                </form>
            </div>
        </div>
    </div>
    </center>
</body>
</html>
