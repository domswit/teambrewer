<?php
include("../config/connection.php");
include("../config/auth.php");

$data = json_decode(file_get_contents("php://input"));
$efullname = mysql_real_escape_string($data->fullname);

$user_id = mysql_real_escape_string($data->user_id);
$ebirthdate = mysql_real_escape_string($data->birthdate);
$username = mysql_real_escape_string($data->username);
$password = mysql_real_escape_string($data->password);

if($password != ''){
	$password = md5($password);
	$password_str = "password = '" . $password . "',";
}

$eteam = mysql_real_escape_string($data->team_id);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE users SET username='" . $username . "', " . $password_str . " fullname='" . $efullname . "', birthdate='" . $ebirthdate . "' , team_id='" . $eteam . "' WHERE user_id='" . $user_id . "'";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "User has been updated.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>