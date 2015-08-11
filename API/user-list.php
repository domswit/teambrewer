<?php
include("../config/connection.php");
include("../config/auth.php");

ini_set('max_execution_time', 0);
set_time_limit(0);

$output = Array('success'=>true, 'users'=>null);

if(isset($_GET['max_per_page']) && $_GET['max_per_page'] != ''){
	$max_per_page = $_GET['max_per_page'];	
} else {
	$max_per_page = 20;	
}

$page = getPage();
$pagingVars = getPagingVars($page, $max_per_page);

$sql = "SELECT  a.user_id, a.fullname, a.first_name, a.last_name, a.fullname, a.birthdate, b.name, a.username, a.password, a.team_id FROM users as a LEFT JOIN teams as b ON (a.team_id = b.team_id) LIMIT " . $pagingVars['offset_start'] . ", " . $pagingVars['max_per_page'];
$count_sql = "SELECT COUNT(*) as total FROM users";

$result = $conn->query($sql);



$users = Array();
if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
      
		
   $users[$row["user_id"]] = $row;
    }
} else {
    echo "0 results";
}

$output['users'] = $users;
$output['total_rows'] = getTotalPageCount($conn, $count_sql, $max_per_page);
echo json_encode ($output);

$conn->close();


function getTotalPageCount($conn, $count_sql, $max_per_page){
	$result = $conn->query($count_sql);
	$row = $result -> fetch_assoc();
	return ceil($row['total'] / $max_per_page);	
}

function getPage(){

	if(!empty($_GET['page']) && $_GET['page'] != 'undefined') {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	return $page;
}

function getPagingVars($page, $max_per_page = 2){
	$offset_start = $page * $max_per_page - $max_per_page;

	return array(
		'offset_start' => $offset_start,
		'max_per_page' => $max_per_page
	);
}
?>



