<?php
include("connection.php");

$data = json_decode(file_get_contents("php://input"));
$efullname = mysql_real_escape_string($data->efullname);

$ebirthdate = mysql_real_escape_string($data->ebirthdate);
$eteam = mysql_real_escape_string($data->eteam);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$username = "tempusername";
$password = "temppassword";
$password = md5($password);

$created = date("Y-m-d h:i:s");

$sql = "INSERT INTO users(`fullname`, `birthdate`, `team_id`, `username` , `password`, `created`)VALUES('".$efullname."','".$ebirthdate."','".$eteam."','" . $username . "' ,'" . $password . "','" . $created . "')";

$output = Array();

if ($conn->query($sql) === TRUE) {

	$last_id = $conn->insert_id;

	$access_token = md5($last_id . $password);

	$update_sql = "UPDATE users SET access_token='" . $access_token . "' WHERE user_id='" . $last_id . "'";

	if ($conn->query($update_sql) === TRUE) {
		echo 'updated';
	}

	$output['success'] = true;
	$output['message'] = "User has been added.";


} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>