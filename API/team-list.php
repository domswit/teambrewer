<?php
include("../config/connection.php");
include("../config/auth.php");

$output = Array('success'=>true, 'teams'=>null);

$search_string = getSearchString();

if(isset($_GET['max_per_page']) && $_GET['max_per_page'] != ''){
	$max_per_page = $_GET['max_per_page'];	
} else {
	$max_per_page = 10;	
}

$page = getPage();
$pagingVars = getPagingVars($page, $max_per_page);

$sql = "SELECT * FROM teams WHERE 1 " . $search_string . " LIMIT " . $pagingVars['offset_start'] . ", " . $pagingVars['max_per_page'];
$count_sql = "SELECT count(*) as total FROM teams WHERE 1 " . $search_string;

$result = $conn->query($sql);

$teams = Array();
if ($result ->num_rows > 0) {
   
    while($row = $result -> fetch_assoc()) {
      
		
    	$teams[$row["team_id"]] = $row;
    }
} else {
    //echo "0 results";
}

$output['teams'] = $teams;
$output['total_rows'] = getTotalPageCount($conn, $count_sql, $max_per_page);
echo json_encode ($output);

$conn->close();

function getSearchString(){
	$search_string = '';
	if(isset($_GET['search']) && $_GET['search'] != ''){
		$search_term = $_GET['search'];
		$search_string .= "AND ( ";
		$search_string .= "name LIKE '%" . $search_term . "%' ";
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