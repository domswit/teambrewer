<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
/*
$servername = "localhost";
$username = "redmine";
$password = "Passw0rd";
$dbname = "mydb";
*/

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 




?>