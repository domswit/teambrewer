<?php
include("connection.php");
$data = json_decode(file_get_contents("php://input"));
$eproject_name = mysql_real_escape_string($data->eproject_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$created = date("Y-m-d h:i:s");

$sql = "INSERT INTO projects(`name`, `created`)VALUES('".$eproject_name."','" . $created . "')";

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