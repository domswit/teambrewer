<?php
$data = json_decode(file_get_contents("php://input"));
$access_token = mysql_real_escape_string($_REQUEST['access_token']);

$sql = "SELECT * FROM users WHERE access_token = '{$access_token}' AND access_token != ''";

$result = $conn->query($sql);

$user = Array();
if ($result ->num_rows > 0) {
   
    while($row = $result -> fetch_assoc()) {
      
		
    	$user[] = $row;
    }
} else {
}

$auth = false;

if(count($user) > 0){
	$auth = true;
} else {
	$auth = false;
}

if(!$auth){
	$output = Array('success'=>false, 'message'=>'User was not authenticated.');
	echo json_encode ($output);
	die();
}

?>