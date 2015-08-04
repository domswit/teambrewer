<?php
ini_set('display_errors','false');
include("../config/connection.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


function getUsers($project_id, $team_id, $user_id){
	// $users = array();
	// $users[1] = array();
	// $users[2] = array();
	// $users[3] = array();

	
$user_str = '';
	if($user_id != ''){

		$user_str = "AND c.user_id = {$user_id}";

	} else {

		$project_str = '';
		
		if($project_id != ''){

			$project_str = "AND a.project_id = {$project_id}";
		}
		
		$team_str = '';

		if($team_id != ''){

			$team_str = "AND c.team_id = {$team_id}";
		}
	}

	global $conn;

		$sql = "SELECT a.user_id, c.fullname, c.team_id, a.project_id,  a.fromdate, a.todate FROM sched as a, projects as b, users as c WHERE a.project_id = b.project_id AND a.user_id = c.user_id " . $project_str . " " . $team_str. " " . $user_str;

		 // echo $sql;
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
function getScheds($user_id, $fromdate, $todate)
{

	global $conn;

	$sql = "SELECT a.sched_id, a.user_id, a.project_id, c.name as project_name , b.fullname, a.fromdate, a.todate, a.allocation FROM sched as a LEFT JOIN users as b ON (a.user_id = b.user_id ) INNER JOIN projects as c ON(a.project_id = c.project_id) WHERE a.user_id = '{$user_id}' && ((a.fromdate >= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate <='$todate') or (a.fromdate <= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate <='$todate') or (a.fromdate >= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate >='$todate')) ORDER BY a.project_id ASC, a.fromdate ASC";

//zecho $sql . "<br><br>";
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




//$users = getUsers();
$user_id = $_POST['user_id']; 
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

if($form_fromdate != '' || $form_todate != ''){
	$users = getUsers($project_id, $team_id,$user_id);  

	$scheds = array();
	$scheds[] = array('allocation' <= '50');
	$scheds[] = array('allocation' <= '45');
	$scheds[] = array('allocation' <= '45');

	$allDates = array();


	//echo $fromdate;



	//$dates =  getDates($fromdate, $todate);


	// print_r($dates);
	// die(); 



	foreach($users as $key => $user){

		// echo $e;
		// echo "<br>";
		//preparation

		//echo "<BR><BR>USER " . $key . "<BR>" ;
		for($x=0; $x<count($dates); $x++){
			$date = $dates[$x];
			$users[$key][$date] = array(
				'allocation_total' => 0
			);
		}


		$scheds = getScheds($key, $form_fromdate, $form_todate);

		if(count($scheds) > 0){


	        
			for($x=0; $x<count($scheds); $x++){
				$fromdate = $scheds[$x]['fromdate'];
				$todate = $scheds[$x]['todate'];

	            if (strtotime($fromdate) < strtotime($todate)){
	                $sched_dates = getDates($fromdate , $todate);

	                
	                //$users[$e][$date] = array();

	                $allocation = $scheds[$x]['allocation'];
	                $project_id = $scheds[$x]['project_id'];
	                $project_name = $scheds[$x]['project_name'];


	                for($i=0; $i<count($sched_dates); $i++){

	                    //echo 'UID: ' . $key . ' -- DATE:' . $sched_dates[$i] . 'ALLOCATION: ' . $allocation . '<br>';

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



//print_r($users);

echo json_encode ($users);

$conn->close();