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


$checkUsername = getUserIdByUsername($username);
$check = getUserIdByUsername1($username);
if($user_id === $checkUsername && $check === $username){



	$sql = "UPDATE users SET username='" . $username . "', " . $password_str . " fullname='" . $efullname . "', birthdate='" . $ebirthdate . "' , team_id='" . $eteam . "' WHERE user_id='" . $user_id . "'";

		
	$output = Array();

	if ($conn->query($sql) === TRUE) {

		$last_id = $conn->insert_id;

		$access_token = md5($last_id . $password);

		$update_sql = "UPDATE users SET access_token='" . $access_token . "' WHERE user_id='" . $last_id . "'";

		if ($conn->query($update_sql) === TRUE) {
			//echo 'updated';
		}

		$output['success'] = true;
		$output['message'] = "User has been updated.";


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

function getUserIdByUsername($username){
		$username=substr($username , 0 , 60);
	global $conn;

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT `user_id`,`username` FROM `users` WHERE `username`= '".$username."'";
	$result = $conn->query($sql);
	$user = Array();
	
	if ($result ->num_rows > 0) {
	    while($row = $result -> fetch_assoc()) {
			$user[] = $row;
			$usern = $row['username'];
	    }
	} 
	


	if( $username === $usern ){
		//if name was found, return its id
		$result_id = $user[0]['user_id'];	
	} 

	return $result_id;
}
function getUserIdByUsername1($username){
		$username=substr($username , 0 , 60);
	global $conn;

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT `user_id`,`username` FROM `users` WHERE `username`= '".$username."'";
	$result = $conn->query($sql);
	$user = Array();
	
	if ($result ->num_rows > 0) {
	    while($row = $result -> fetch_assoc()) {
			$user[] = $row;
			$usern = $row['username'];
	    }
	} 
	return $usern;
}
?>