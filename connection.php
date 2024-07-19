<?php
$server = 'localhost:3306'; 
$username = 'root';
$password = '';
$database = 'the_gallery_cafe'; 

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
