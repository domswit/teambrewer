<?php
include("../config/connection.php");
include("../config/auth.php");

ini_set('max_execution_time', 0);
set_time_limit(0);

$output = Array('success'=>true, 'users'=>null);


$search_string = getSearchString();

if(isset($_GET['max_per_page']) && $_GET['max_per_page'] != ''){
	$max_per_page = $_GET['max_per_page'];	
} else {
	$max_per_page = 10;
}

$page = getPage();
$pagingVars = getPagingVars($page, $max_per_page);

$sql = "SELECT  a.user_id, a.fullname, a.first_name, a.last_name, a.fullname, a.birthdate, b.name, a.username, a.password, a.team_id FROM users as a LEFT JOIN teams as b ON (a.team_id = b.team_id) WHERE 1 " . $search_string . " LIMIT " . $pagingVars['offset_start'] . ", " . $pagingVars['max_per_page'];
$count_sql = "SELECT  count(*) as total FROM users as a LEFT JOIN teams as b ON (a.team_id = b.team_id) WHERE 1 " . $search_string;

$result = $conn->query($sql);

$users = Array();
if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
      
		
   $users[$row["user_id"]] = $row;
    }
} else {
    //echo "0 results";
}

$output['users'] = $users;
$output['total_rows'] = getTotalPageCount($conn, $count_sql, $max_per_page);
echo json_encode ($output);

$conn->close();


function getSearchString(){
	$search_string = '';
	if(isset($_GET['search']) && $_GET['search'] != ''){
		$search_term = $_GET['search'];
		$search_string .= "AND ( ";
		$search_string .= "a.fullname LIKE '%" . $search_term . "%' ";
		$search_string .= "OR b.name LIKE '%" . $search_term . "%' ";
		$search_string .= "OR a.username LIKE '%" . $search_term . "%' ";
		$search_string .= "OR a.birthdate LIKE '%" . $search_term . "%' ";
		$search_string .= ") ";
	}

	return $search_string;
}

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



