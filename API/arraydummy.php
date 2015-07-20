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
            $start = date('Y-m-d', strtotime($startDate.'+'.$a.' days'));
            $return[] = $start;
            $a++;
        }
    }

    return $return;
}


function getScheds($user_id, $fromdate, $todate){

	global $conn;

	$sql = "SELECT a.sched_id, a.user_id, a.project_id , CONCAT(b.first_name, ' ', b.last_name) as name, a.fromdate, a.todate, a.allocation FROM sched as a LEFT JOIN users as b ON (a.user_id = b.user_id ) WHERE a.user_id = '{$user_id}' && (a.fromdate >= '$fromdate' && a.fromdate <='$todate') && (a.fromdate >= '$fromdate' && a.todate <= '$todate')";

	$result = $conn->query($sql);

	$scheds = Array();

	if ($result ->num_rows > 0) {
	   
	    while($row = $result -> fetch_assoc()) {
	      
			
	    	$scheds[] = $row;
	    }
	} else {
	    // echo "0 results";
	}

	return $scheds;
}

$users = getUsers();

$scheds = array();
$scheds[] = array('allocation' <= '50');
$scheds[] = array('allocation' <= '45');
$scheds[] = array('allocation' <= '45');

$allDates = array();


$fromdate = '2015-07-01';
$todate = '2015-07-30';

$dates =  getDates($fromdate, $todate);

foreach($users as $key => $user){

	for($x=0; $x<count($dates); $x++){
		$date = $dates[$x];
		$users[$key][$date] = array();
	}


	$scheds = getScheds($key, $fromdate, $todate);

	if(count($scheds) > 0){


        
		for($x=0; $x<count($scheds); $x++){
			$sched_fromdate =  date('Y-m-d', strtotime($scheds[$x]['fromdate']));
			$sched_todate =  date('Y-m-d', strtotime($scheds[$x]['todate']));

            if (strtotime($fromdate) < strtotime($todate)){
                $sched_dates = getDates($sched_fromdate , $sched_todate);

              
                //$users[$e][$date] = array();

                $allocation = $scheds[$x]['allocation'];
                $project_id = $scheds[$x]['project_id'];





                for($i=0; $i<count($sched_dates); $i++){

                    //echo 'UID: ' . $key . ' -- DATE:' . $sched_dates[$i] . 'ALLOCATION: ' . $allocation . '<br>';

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

 // print_r($users);

$conn->close();


?>