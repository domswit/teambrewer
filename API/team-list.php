<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM teams";

$result = $conn->query($sql);


$output = Array('success'=>true, 'teams'=>null);
$teams = Array();
if ($result ->num_rows > 0) {
   
    while($row = $result -> fetch_assoc()) {
      
		
    	$teams[$row["team_id"]] = $row;
    }
} else {
    echo "0 results";
}

$output['teams'] = $teams;
echo json_encode ($output);

$conn->close();
?>