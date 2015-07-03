<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM projects";

$result = $conn->query($sql);


$output = Array('success'=>true, 'projects'=>null);
$projects = Array();
if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
      
    
      $projects[$row["project_id"]] = $row;
    }
} else {
    echo "0 results";
}

$output['projects'] = $projects;
echo json_encode ($output);

$conn->close();
?>