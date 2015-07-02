<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Users";

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