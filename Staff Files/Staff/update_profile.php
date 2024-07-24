<?php
include_once('../connection.php');

// Check if user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../welcome.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update user profile data in the database
    $query = "UPDATE staff_tbl SET name = ?, email = ?, password = ? WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $email, $password, $username);
    if ($stmt->execute()) {
        header('Location: profile.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
