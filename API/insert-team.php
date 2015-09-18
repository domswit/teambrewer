<?php
include("../config/connection.php");
include("../config/auth.php");

$data = json_decode(file_get_contents("php://input"));
$name = mysql_real_escape_string($data->name);
$members = mysql_real_escape_string($data->members);
$members = explode(',',$members);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$created = date("Y-m-d h:i:s");

$sql = "INSERT INTO teams(`name`,`created`)VALUES('".$name."','" . $created . "')";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "New team has been added.";

	$team_id = $conn->insert_id;

	if(!setMembers($conn, $members, $team_id)){
		$output['success'] = false;
		$output['message'] = "Members not set. Reason: " . $conn->error;
	}

} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

function setMembers($conn, $members, $team_id){
	//print_r($members);

	for($x=0; $x<count($members); $x++){
		$member_id = $members[$x];

		$sql = "UPDATE users SET team_id='" . $team_id . "' WHERE user_id='" . $member_id . "'";

		if (!$conn->query($sql) === TRUE) { 
			echo $conn->error;
			return false;
		}
	}
	return true;
}

echo json_encode ($output);

$conn->close();


?>