<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$data = json_decode(file_get_contents("php://input"));
$first_name = mysql_real_escape_string($data->first_name);
$last_name = mysql_real_escape_string($data->last_name);
$user_id = mysql_real_escape_string($data->user_id);
$birthdate = mysql_real_escape_string($data->birthdate);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE users SET first_name='" . $first_name . "', last_name='" . $last_name . "' WHERE user_id='" . $user_id . "'";

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