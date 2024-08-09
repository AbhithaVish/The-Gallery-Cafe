<?php
session_start();
include_once('connection.php');

if (isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Please fill in both username and password';
        header('Location: welcome.php');
        exit;
    }

    $sql = "SELECT * FROM `staff_tbl` WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) { // check the password
            $_SESSION['name'] = $row['name'];
            $_SESSION['username'] = $row['username'];
            header('Location: Staff/index.php');
            exit;
        }
    }

    $_SESSION['error'] = 'Invalid username or password';
    header('Location: welcome.php');
    exit;
}
?>
