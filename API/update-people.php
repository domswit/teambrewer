<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$data = json_decode(file_get_contents("php://input"));
$efirst_name = mysql_real_escape_string($data->first_name);
$elast_name = mysql_real_escape_string($data->last_name);
$user_id = mysql_real_escape_string($data->user_id);
$ebirthdate = mysql_real_escape_string($data->birthdate);
$eteam = mysql_real_escape_string($data->team_id);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE users SET first_name='" . $efirst_name . "', last_name='" . $elast_name . "' , birthdate='" . $ebirthdate . "' , team_id='" . $eteam . "' WHERE user_id='" . $user_id . "'";
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