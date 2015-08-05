<?php
include("../config/connection.php");
$data = json_decode(file_get_contents("php://input"));
$name = mysql_real_escape_string($data->name);
$team_id = mysql_real_escape_string($data->team_id);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE teams SET name='" . $name . "' WHERE team_id='" . $team_id . "'";
$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "Team information has been updated.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>