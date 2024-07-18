<?php
$server = 'localhost:3306'; // MySQL server address and port
$username = 'root'; // MySQL username
$password = ''; // MySQL password
$database = 'the_gallery_cafe'; // Database name

// Create a new MySQLi object for database connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    // If connection fails, output error message and terminate script
    die('Connection failed: ' . $conn->connect_error);
}
?>
