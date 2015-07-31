<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$data = json_decode(file_get_contents("php://input"));
$efullname = mysql_real_escape_string($data->fullname);

$user_id = mysql_real_escape_string($data->user_id);
$ebirthdate = mysql_real_escape_string($data->birthdate);
$eteam = mysql_real_escape_string($data->team_id);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE users SET fullname='" . $efullname . "', birthdate='" . $ebirthdate . "' , team_id='" . $eteam . "' WHERE user_id='" . $user_id . "'";
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