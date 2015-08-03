<?php
include("connection.php");
$data = json_decode(file_get_contents("php://input"));
$ename = mysql_real_escape_string($data->name);
$ealloc = mysql_real_escape_string($data->allocation);
$efromdate = mysql_real_escape_string($data->fromdate);
$etodate = mysql_real_escape_string($data->todate);
$sched_id = mysql_real_escape_string($data->sched_id);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



$sql = "UPDATE sched SET user_id='" . $ename . "', fromdate='" . $efromdate . "', todate='" . $etodate . "', allocation='" . $ealloc . "' WHERE sched_id='" . $sched_id . "'";

$output = Array();

if ($conn->query($sql) === TRUE) {
	$output['success'] = true;
	$output['message'] = "Team information has been updated.";
} else {
	$output['success'] = false;
	$output['message'] = $conn->error;
}

echo json_encode ($output);

$conn->close();


?>
