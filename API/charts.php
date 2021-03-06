<?php
// ini_set('display_errors','false');
include("../config/connection.php");
include("../config/auth.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$output = Array('success'=>true, 'users'=>null);

function getUsers($project_id, $team_id, $people){

	//echo $project_id . ":" . $team_id . ":" . $people;

	$user_str = '';
	$user_str_array = array();

	if(is_array($people) && count($people) > 0){
		foreach($people as $person){
			array_push($user_str_array, " c.user_id = {$person} ");			
		}
		$user_str = ' AND (' . implode(' OR ', $user_str_array) . ') ';
	}

	$team_str = '';
	if($team_id != ''){
		$team_str = " AND c.team_id = '{$team_id}'";
	}

	global $conn;

	$sql = "SELECT c.user_id, c.fullname, c.team_id FROM users as c WHERE 1 ". $user_str . $team_str;
		 
	$result = $conn->query($sql);

	$users = Array();

	if ($result ->num_rows > 0) {
	   
	    while($row = $result -> fetch_assoc()) {
	      
			
	    	$users[$row['user_id']] = $row;
	    }
	} else {
	    //echo "0 results";
	}
	
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
            $start = date('Y-m-d', strtotime($startDate.'+'.$a.' days'));
            $return[] = $start;
            $a++;
        }
    }

    return $return;
}

function getScheds($user_id, $fromdate, $todate, $project_id)
{

	global $conn;

	$project_str = '';
	if($project_id != ''){
		$project_str = " AND a.project_id = '{$project_id}' ";
	}

	$sql = "SELECT a.sched_id, a.user_id, a.project_id, c.name as project_name , b.fullname, a.fromdate, a.todate, a.allocation FROM sched as a LEFT JOIN users as b ON (a.user_id = b.user_id ) INNER JOIN projects as c ON(a.project_id = c.project_id) WHERE a.user_id = '{$user_id}' " . $project_str . " && ((a.fromdate >= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate <='$todate') or (a.fromdate <= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate <='$todate') or (a.fromdate >= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate >='$todate')) ORDER BY a.project_id ASC, a.fromdate ASC";


	$result = $conn->query($sql);

	$scheds = Array();

	if ($result ->num_rows > 0) {
	   
	    while($row = $result -> fetch_assoc()) {
	      
			
	    	$scheds[] = $row;
	    }
	} else {
	    //echo "0 results";
	}

	return $scheds;
}

$people = null;
if($_POST['people'] != ''){
	$people = explode(',',urldecode($_POST['people'])); 	
}

$form_fromdate = $_POST['from_date'];
$form_todate = $_POST['to_date'];
$project_id = $_POST['project_id'];
$team_id = $_POST['team_id'];

if($form_fromdate != '' && $form_todate == ''){
	$form_todate = $form_fromdate;
}

if($form_fromdate == '' && $form_todate != ''){
	$form_fromdate = $form_todate;
}

$users = [];

$dates =  getDates($form_fromdate, $form_todate);

if($form_fromdate != '' || $form_todate != ''){
	$users = getUsers($project_id, $team_id, $people);

	$scheds = array();
	$scheds[] = array('allocation' <= '50');
	$scheds[] = array('allocation' <= '45');
	$scheds[] = array('allocation' <= '45');

	$allDates = array();

	foreach($users as $key => $user){

		for($x=0; $x<count($dates); $x++){
			$date = $dates[$x];
			$users[$key][$date] = array(
				'allocation_total' => 0
			);
		}

		$scheds = getScheds($key, $form_fromdate, $form_todate, $project_id);

		if(count($scheds) > 0){


	        
			for($x=0; $x<count($scheds); $x++){
				$fromdate = $scheds[$x]['fromdate'];
				$todate = $scheds[$x]['todate'];

	            if (strtotime($fromdate) < strtotime($todate)){
	                $sched_dates = getDates($fromdate , $todate);
	                $allocation = $scheds[$x]['allocation'];
	                $project_id = $scheds[$x]['project_id'];
	                $project_name = $scheds[$x]['project_name'];


	                for($i=0; $i<count($sched_dates); $i++){

	                    $sched_date = date('Y-m-d', strtotime($sched_dates[$i]));

	                    if($sched_date != '' && ( strtotime($sched_dates[$i]) >= strtotime($form_fromdate) && strtotime($sched_dates[$i])<= strtotime($form_todate))){

	                        $users[$key][ $sched_date ]['allocation_list'][] = array(
	                            'allocation'=>$allocation,
	                            'project_id'=>$project_id,
	                            'project_name'=>$project_name
	                        );              

	                        $users[$key][ $sched_date ]['allocation_total'] += $allocation*1;  
	                    }
	                    
	                }                
	            }
			}
		}

	}
}

$output['users'] = $users;

echo json_encode ($output);

$conn->close();