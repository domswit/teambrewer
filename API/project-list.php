<?php
include("connection.php");

$output = Array('success'=>true, 'projects'=>null);

if(isset($_GET['max_per_page']) && $_GET['max_per_page'] != ''){
	$max_per_page = $_GET['max_per_page'];	
} else {
	$max_per_page = 5;	
}

$page = getPage();
$pagingVars = getPagingVars($page, $max_per_page);

$sql = "SELECT * FROM projects  LIMIT " . $pagingVars['offset_start'] . ", " . $pagingVars['max_per_page'];
$count_sql = "SELECT COUNT(*) as total FROM projects";
$result = $conn->query($sql);



$projects = Array();
if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
      
    
      $projects[$row["project_id"]] = $row;
    }
} else {
    echo "0 results";
}

$output['projects'] = $projects;
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






