<?php
include("connection.php");
$data = json_decode(file_get_contents("php://input"));
$ename = mysql_real_escape_string($data->name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$created = date("Y-m-d h:i:s");

$sql = "INSERT INTO teams(`name`,`created`)VALUES('".$ename."','" . $created . "')";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "New team has been added.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>