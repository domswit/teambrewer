<?php
include("connection.php");

$output = Array('success'=>true, 'sched'=>null);

$max_per_page = 25;
$page = getPage();
$pagingVars = getPagingVars($page, $max_per_page);

$sql = "SELECT a.sched_id, a.user_id, b.fullname as name, a.fromdate, a.todate, a.allocation FROM sched as a LEFT JOIN users as b ON (a.user_id = b.user_id)LIMIT " . $pagingVars['offset_start'] . ", " . $pagingVars['max_per_page'];

$count_sql = "SELECT COUNT(*) as total FROM sched";
$result = $conn->query($sql);


$sched = Array();


if ($result ->num_rows > 0) {
   
    while($row = $result -> fetch_assoc()) {
      
		
    	$sched[$row["sched_id"]] = $row;
    }
} else {
    echo "0 results";
}

$output['sched'] = $sched;
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



