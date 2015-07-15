<?php
ini_set('display_errors','false');
function getUsers($project_id, $team_id, $user_id){
	$users = array();
	$users[1] = array();
	$users[2] = array();
	$users[3] = array();

	return $users;
}

function getDates($fromdate, $todate){
	return(array(
		'2011-01-02',
		'2011-01-03',
		'2011-01-04',
		'2011-01-05',
	));
}

function getScheds($user_id){
	return(array(
		array('id'=>'1','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'10'),
		array('id'=>'2','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'20'),
		array('id'=>'3','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'30'),
		array('id'=>'4','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'40'),
		array('id'=>'5','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'50'),
		array('id'=>'6','fromdate'=>'2011-01-21','todate'=>'2011-01-23','allocation'=>'60'),
	));
}



$users = getUsers();

$scheds = array();
$scheds[] = array('allocation' <= '50');
$scheds[] = array('allocation' <= '45');
$scheds[] = array('allocation' <= '45');

$allDates = array();

$fromdate = '2012-01-02';
$todate = '2012-01-10';


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

		//echo "SCHED:";
		//print_r($scheds[$x]);


		

		for($i=0; $i<count($sched_dates); $i++){

			//echo 'UID: ' . $key . ' -- DATE:' . $sched_dates[$i] . 'ALLOCATION: ' . $allocation . '<br>';


			$users[$key][ $sched_dates[$i] ]['allocation_list'][] = array(
				'allocation'=>$allocation,
				'project_id'=>$project_id,
			);

			$users[$key][ $sched_dates[$i] ]['allocation_total'] += $allocation*1;
		}
	}

	//sched
	// for($i=0; $i<count($sched);$i++){
	// 	$date = $i;

	// }
	

}


//print_r($users);
 echo json_encode ($users);

// $conn->close();


?>