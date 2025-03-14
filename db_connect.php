<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$database = "sales_management"; 

$conn = new mysqli($host, $user, $password, $database);
$conn->query("SET time_zone = '+08:00'"); 



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
