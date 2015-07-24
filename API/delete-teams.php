<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$data = json_decode(file_get_contents("php://input"));

$id = mysql_real_escape_string($data->id);
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "DELETE FROM `teams` WHERE `team_id`='".$id."'"	;

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "wew";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>