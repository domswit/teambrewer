<?php
include("connection.php");
$data = json_decode(file_get_contents("php://input"));

$id = mysql_real_escape_string($data->id);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "DELETE FROM `users` WHERE `user_id`='".$id."'"	;

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "User deleted!";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>