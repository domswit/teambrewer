<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$data = json_decode(file_get_contents("php://input"));
$efirst_name = mysql_real_escape_string($data->efirst_name);
$elast_name = mysql_real_escape_string($data->elast_name);

$ebirthdate = mysql_real_escape_string($data->ebirthdate);
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO users(`first_name`, `last_name`, `birthdate`)VALUES('".$efirst_name."','".$elast_name."','".$ebirthdate."')";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "User has been added.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>