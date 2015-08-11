<?php
include("../config/connection.php");
include("../config/auth.php");

$data = json_decode(file_get_contents("php://input"));
$eproject_name = mysql_real_escape_string($data->eproject_name);
$project_id = mysql_real_escape_string($data->project_id);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$updated = date("Y-m-d h:i:s");

$sql = "UPDATE projects SET name='" . $eproject_name .  "', updated='" . $updated . "'  WHERE project_id='" . $project_id . "'";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "Team has been updated.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);
echo $sql;
$conn->close();


?>