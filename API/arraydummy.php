<?php
ini_set('display_errors','false');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


function getUsers($project_id, $team_id, $user_id){
	$users = array();
	$users[1] = array();
	$users[2] = array();
	$users[3] = array();

	return $users;
}


function getDates($startDate, $endDate)
{
    $return = array($startDate);
    $start = $startDate;
    $a=1;
    if (strtotime($startDate) < strtotime($endDate))
    {
       while (strtotime($start) < strtotime($endDate))
        {
            $start = date('YYYY-mm-dd', strtotime($startDate.'+'.$a.' days'));
            $return[] = $start;
            $a++;
        }
    }

    return $return;
}


// function getScheds($user_id){
// 	return(array(
// 		array('id'=>'1','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'10'),
// 		array('id'=>'2','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'20'),
// 		array('id'=>'3','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'30'),
// 		array('id'=>'4','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'40'),
// 		array('id'=>'5','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'50'),
// 		array('id'=>'6','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'60'),
// 	));
// }
function getScheds($user_id){

	global $conn;

	$sql = "SELECT a.sched_id, a.user_id, a.project_id , CONCAT(b.first_name, ' ', b.last_name) as name, a.fromdate, a.todate, a.allocation FROM sched as a LEFT JOIN users as b ON (a.user_id = b.user_id )";

	$result = $conn->query($sql);

	$scheds = Array();

	if ($result ->num_rows > 0) {
	   
	    while($row = $result -> fetch_assoc()) {
	      
			
	    	$scheds[$row["sched_id"]] = $row;
	    }
	} else {
	    echo "0 results";
	}

	return $scheds;
}

$users = getUsers();

$scheds = array();
$scheds[] = array('allocation' <= '50');
$scheds[] = array('allocation' <= '45');
$scheds[] = array('allocation' <= '45');

$allDates = array();



$fromdate = '2011-01-01';
$todate = '2012-01-01';


$dates =  getDates($fromdate, $todate);



foreach($users as $key => $user){

	// echo $e;
	// echo "<br>";
	//preparation

	//echo "<BR><BR>USER " . $key . "<BR>" ;
	for($x=0; $x<count($dates); $x++){
		$date = $dates[$x];
	}


	$scheds = getScheds($key);

	for($x=0; $x<count($scheds); $x++){
		$fromdate = $scheds[$x]['fromdate'];
		$todate = $scheds[$x]['todate'];



		$sched_dates = getDates($fromdate , $todate);

		
		//$users[$e][$date] = array();

		$allocation = $scheds[$x]['allocation'];
		$project_id = $scheds[$x]['id'];




		

		for($i=0; $i<count($sched_dates); $i++){

			//echo 'UID: ' . $key . ' -- DATE:' . $sched_dates[$i] . 'ALLOCATION: ' . $allocation . '<br>';


			$users[$key][ $sched_dates[$i] ]['allocation_list'][] = array(
				'allocation'=>$allocation,
				'project_id'=>$project_id,
			);

			$users[$key][ $sched_dates[$i] ]['allocation_total'] += $allocation*1;
		}
	}

}


 //echo json_encode ($users);

 print_r($users);

$conn->close();


?>