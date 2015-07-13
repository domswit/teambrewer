<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$data = json_decode(file_get_contents("php://input"));
$efirst_name = mysql_real_escape_string($data->efirst_name);
$elast_name = mysql_real_escape_string($data->elast_name);
$ebirthdate = mysql_real_escape_string($data->ebirthdate);
$eteam = mysql_real_escape_string($data->eteam);
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$username = "tempusername";
$password = "temppassword";
$password = md5($password);

$sql = "INSERT INTO users(`first_name`, `last_name`, `birthdate`, `team_id`, `username` , `password`)VALUES('".$efirst_name."','".$elast_name."','".$ebirthdate."','".$eteam."','" . $username . "' ,'" . $password . "')";

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