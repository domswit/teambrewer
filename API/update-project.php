<?php
include("../config/connection.php");
include("../config/auth.php");

$data = json_decode(file_get_contents("php://input"));
$project_id = mysql_real_escape_string($data->project_id);
$project_name = mysql_real_escape_string($data->project_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE projects SET name='" . $project_name .  "' WHERE project_id='" . $project_id . "'";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "Team has been updated.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>