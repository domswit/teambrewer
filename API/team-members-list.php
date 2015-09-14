<?php
include("../config/connection.php");
include("../config/auth.php");

$output = Array('success'=>true, 'teams'=>null);
$data = json_decode(file_get_contents("php://input"));

if(isset($_GET['team_id']) && $_GET['team_id'] != ''){
	$team_id = $_GET['team_id'];	
}

$sql = "SELECT user_id FROM users WHERE team_id = '" . $team_id . "' ";

$result = $conn->query($sql);

$members = Array();
if ($result ->num_rows > 0) {
   
    while($row = $result -> fetch_assoc()) {
      
    	$members[]= $row;
    }
} else {
    //echo "0 results";
}

$output['members'] = $members;
echo json_encode ($output);

$conn->close();
?>