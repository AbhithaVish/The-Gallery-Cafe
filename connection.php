<?php
$server = 'localhost:3306';
$username = 'root';
$password = '';
$database = 'the_gallery_cafe'; //adding the database name to connect

if (isset($_POST)){
    $conn = new mysqli($server, $username , $password , $database);

    if ($conn-> connect_error){
        die('Connection failed: ' . $conn->connect_error);
    }else {

    }
} else {
    echo "No POST Data Recived.";
}
?>