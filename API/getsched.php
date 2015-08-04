<?php
include("../config/connection.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT  a.user_id, a.first_name, a.last_name, a.birthdate, b.name, a.username, a.password, a.team_id FROM users as a LEFT JOIN teams as b ON (a.team_id = b.team_id)";

$result = $conn->query($sql);


$output = Array('success'=>true, 'users'=>null);
$users = Array();
if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
      
		
   $users[$row["user_id"]] = $row;
    }
} else {
    echo "0 results";
}

$output['users'] = $users;
echo json_encode ($output);

$conn->close();
?>