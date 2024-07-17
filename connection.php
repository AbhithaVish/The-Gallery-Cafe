<?php
$server = 'localhost:3306';
$username = 'root';
$password = '';
$database = 'the_gallery_cafe';

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
