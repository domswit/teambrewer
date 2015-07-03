<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$data = json_decode(file_get_contents("php://input"));
$eproject_name = mysql_real_escape_string($data->eproject_name);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO projects(`project_name`)VALUES('".$eproject_name."')";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "Team has been added.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>