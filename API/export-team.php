<?php

include("../config/connection.php");

//include("../config/auth.php");

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=teams.csv');

$sql = "SELECT * FROM teams";
$result = $conn->query($sql);

$teams = Array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $teams[] = $row;
    }
}

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
$max_rows = 0;

for($i=0; $i<count($teams); $i++){
	$teams[$i]['members'] = getMembers($conn, $teams[$i]['team_id']);
	if(count($teams[$i]['members']) > $max_rows){
		$max_rows = count($teams[$i]['members']);
	}
}

$heading = array();
for($i=0; $i<count($teams); $i++){
	array_push($heading, $teams[$i]['name']);
}

fputcsv($output, $heading);

for($i=0; $i<$max_rows; $i++){

	$row = array();
	for($x=0; $x<count($teams); $x++){
		array_push($row, $teams[$x]['members'][$i]['fullname']);
	}

	fputcsv($output, $row);
}

function getMembers($conn, $team_id){
	$sql = "SELECT * FROM users WHERE team_id = '{$team_id}'";
	$result = $conn->query($sql);

	$members = Array();
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	      $members[] = $row;
	    }
	}

	return $members;
}

?>