<?php

//START OF IMPLEMENTATION

ini_set('display_errors','true');

include("connection.php");

$users = getUsers();

$fromdate = $_POST['from_date'];
$todate = $_POST['to_date'];
$project_id = $_POST['project_id'];

$users = getUsers($project_id, $team_id);

$scheds = array();
$scheds[] = array('allocation' <= '50');
$scheds[] = array('allocation' <= '45');
$scheds[] = array('allocation' <= '45');

$allDates = array();

foreach($users as $key => $user){

	for($x=0; $x<count($dates); $x++){
		$date = $dates[$x];
		$users[$key][$date] = array();
	}

	$scheds = getScheds($key, $fromdate, $todate);

	if(count($scheds) > 0){


        
		for($x=0; $x<count($scheds); $x++){
			$fromdate = $scheds[$x]['fromdate'];
			$todate = $scheds[$x]['todate'];

            if (strtotime($fromdate) < strtotime($todate)){

                $sched_dates = getDates($fromdate , $todate);
                $allocation = $scheds[$x]['allocation'];
                $project_id = $scheds[$x]['project_id'];

                for($i=0; $i<count($sched_dates); $i++){

                    $sched_date = date('Y-m-d', strtotime($sched_dates[$i]));

                    if($sched_date != ''){

                        $users[$key][ $sched_date ]['allocation_list'][] = array(
                            'allocation'=>$allocation,
                            'project_id'=>$project_id,
                        );              

                        $users[$key][ $sched_date ]['allocation_total'] += $allocation*1;  
                    }
                    
                }                
            }


		}
	}
}

echo json_encode ($users);

$conn->close();

//END OF IMPLEMENTATION



/* FUNCTIONS */

function getUsers($project_id, $team_id, $user_id){

	global $conn;
		$sql = "SELECT a.user_id, c.team_id, a.project_id, a.fromdate, a.todate FROM `sched` as a, `projects` as b, `users` as c WHERE a.project_id = b.project_id AND a.user_id = c.user_id AND a.project_id = 11 AND c.team_id = 2";
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

function getScheds($user_id, $fromdate, $todate)
{

	global $conn;


	$sql = "SELECT a.sched_id, a.user_id, a.project_id , CONCAT(b.first_name, ' ', b.last_name) as name, a.fromdate, a.todate, a.allocation FROM sched as a LEFT JOIN users as b ON (a.user_id = b.user_id ) WHERE a.user_id = '{$user_id}' && ((a.fromdate >= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate <='$todate') or (a.fromdate <= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate <='$todate') or (a.fromdate >= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate >='$todate'))ORDER BY a.fromdate ASC";

//echo $sql . "<br><br>";
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




?>