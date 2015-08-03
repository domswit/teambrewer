<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$servername = "10.23.28.43";
$username = "redmine";
$password = "Passw0rd";
$dbname = "mydb";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 




?>