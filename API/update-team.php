<?php
include("../config/connection.php");
include("../config/auth.php");

$output = Array();
$output['success'] = true;
$output['message'] = "Team information has been updated.";

$data = json_decode(file_get_contents("php://input"));
$name = mysql_real_escape_string($data->name);
$team_id = mysql_real_escape_string($data->team_id);
$members = mysql_real_escape_string($data->members);
$members = explode(',',$members);

removeMembers($conn, $team_id);

if(!setMembers($conn, $members, $team_id)){
	$output['success'] = false;
	$output['message'] = "Members not set. Reason: " . $conn->error;
}

$updated = date("Y-m-d h:i:s");
$sql = "UPDATE teams SET name='" . $name . "',updated='" . $updated . "' WHERE team_id='" . $team_id . "'";

if (!$conn->query($sql) === TRUE) {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);
$conn->close();



function removeMembers($conn, $team_id){
	$sql = "UPDATE users SET team_id='' WHERE team_id = '" . $team_id . "'";

	if ($conn->query($sql) === TRUE) {
			return true;
		} else {
			return false;
		}
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

?>