<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Users";

$result = $conn->query($sql);


$output = Array('success'=>true, 'users'=>null);
$users = Array();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      
		//echo "id: " . $row["user_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
		
		//array_push($users, $row);
    	$users[$row["user_id"]] = $row;
    }
} else {
    echo "0 results";
}

$output['users'] = $users;
echo json_encode ($output);

$conn->close();
?>