<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT a.sched_id, a.user_id, CONCAT(b.first_name, ' ', b.last_name) as name, a.fromdate, a.todate, a.allocation FROM sched as a LEFT JOIN users as b ON (a.user_id = b.user_id)";

$result = $conn->query($sql);

$output = Array('success'=>true, 'sched'=>null);
$teams = Array();


if ($result ->num_rows > 0) {
   
    while($row = $result -> fetch_assoc()) {
      
		
    	$teams[$row["sched_id"]] = $row;
    }
} else {
    echo "0 results";
}

$output['sched'] = $teams;
echo json_encode ($output);

$conn->close();
?>