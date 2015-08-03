<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";
$data = json_decode(file_get_contents("php://input"));
$ename = mysql_real_escape_string($data->ename);
$ealloc = mysql_real_escape_string($data->ealloc);
$efromdate = mysql_real_escape_string($data->efromdate);
$etodate = mysql_real_escape_string($data->etodate);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$created = date("Y-m-d h:i:s");

$sql = "INSERT INTO sched(`user_id`, `fromdate`, `todate`, `allocation`,`created`)VALUES('".$ename."','".$efromdate."','".$etodate."','".$ealloc."','" . $created . "')";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "User has been added.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>