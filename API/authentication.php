<?php

include("../config/connection.php");

$data = json_decode(file_get_contents("php://input"));

$form_username = mysql_real_escape_string($data->username);
$form_password = md5("thisisasecretteambrewerstring" . mysql_real_escape_string($data->password));

$b = "";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_id, username, access_token from users where  username = '" . $form_username . "' && password = '" . $form_password . "' && access_token != '" .$b ."'" ;

$result = $conn->query($sql);


$output = Array();
$users = Array();


if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
      
		
    	array_push($users, $row);

    	$output['success'] = true;
    	$output['message'] = 'User has been authenticated';
    	$output['user'] = $row;
    }
} else {
    $output['success'] = false;
    $output['message'] = 'User does not exist';
}

echo json_encode ($output);


$conn->close();
?>