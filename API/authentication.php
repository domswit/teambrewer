<?php
ini_set('display_errors','false');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$data = json_decode(file_get_contents("php://input"));

$form_username = mysql_real_escape_string($data->username);
$form_password = mysql_real_escape_string($data->password);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_id, username from users where  username = '" . $form_username . "' && password = '" . $form_password . "'";

$result = $conn->query($sql);


$output = Array();
$users = Array();

if ($result->num_rows > 0) {
    /
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