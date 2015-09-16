<?php
include("../config/connection.php");
include("../config/auth.php");

$data = json_decode(file_get_contents("php://input"));
$efullname = mysql_real_escape_string($data->efullname);

$ebirthdate = mysql_real_escape_string($data->ebirthdate);
$eteam = mysql_real_escape_string($data->eteam);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$username = mysql_real_escape_string($data->username);
$password = mysql_real_escape_string($data->password);
$password = md5($password);

$created = date("Y-m-d h:i:s");

$checkUsername = getUserIdByUsername($username);

if(!$checkUsername){

	$sql = "INSERT INTO users(`fullname`, `birthdate`, `team_id`, `username` , `password`, `created`)VALUES('".$efullname."','".$ebirthdate."','".$eteam."','" . $username . "' ,'" . $password . "','" . $created . "')";

	$output = Array();

	if ($conn->query($sql) === TRUE) {

		$last_id = $conn->insert_id;

		$access_token = md5("thisisasecretteambrewerstring" . $password);

		$update_sql = "UPDATE users SET access_token='" . $access_token . "' WHERE user_id='" . $last_id . "'";

		if ($conn->query($update_sql) === TRUE) {
			//echo 'updated';
		}

		$output['success'] = true;
		$output['message'] = "User has been added.";


	} else {
		$output['success'] = false;
		$output['message'] = $conn->error;
	}
} else {
	$output['message'] = 'Existing Username';
	$output['success'] = false;
	$output['message_code'] = '2'; 
}

echo json_encode ($output);

$conn->close();




function getUserIdByUsername($name){
		$name=substr($name , 0 , 60);
	global $conn;

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT `user_id` FROM `users` WHERE `username`= '".$name."'";
	$result = $conn->query($sql);
	$user = Array();
	
	if ($result ->num_rows > 0) {
	    while($row = $result -> fetch_assoc()) {
			$user[] = $row;
	    }
	} 
	


	if( count($user) > 0 ){
		//if name was found, return its id
		$result_id = $user[0]['user_id'];	
	} 

	return $result_id;
}

?>