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
	// $users = array();
	// $users[1] = array();
	// $users[2] = array();
	// $users[3] = array();

	

	global $conn;
		$sql = "SELECT a.user_id, c.team_id, a.project_id, a.fromdate, a.todate FROM `sched` as a, `projects` as b, `users` as c WHERE a.project_id = b.project_id AND a.user_id = c.user_id AND a.project_id = 2 AND c.team_id = 2";
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
function getScheds($user_id, $fromdate, $todate){

	global $conn;

	$sql = "SELECT a.sched_id, a.user_id, a.project_id , CONCAT(b.first_name, ' ', b.last_name) as name, a.fromdate, a.todate, a.allocation FROM sched as a LEFT JOIN users as b ON (a.user_id = b.user_id ) WHERE a.user_id = '{$user_id}' && ((a.fromdate >= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate <='$todate') or (a.fromdate <= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate <='$todate') or (a.fromdate >= '{$fromdate}' && a.fromdate <='$todate') && (a.todate >= '{$fromdate}' && a.todate >='$todate'))";

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

$fromdate = $_POST['from_date'];
$todate = $_POST['to_date'];
$project_id = $_POST['project_id'];

$users = getUsers($project_id, $team_id);

$scheds = array();
$scheds[] = array('allocation' <= '50');
$scheds[] = array('allocation' <= '45');
$scheds[] = array('allocation' <= '45');

$allDates = array();




//echo $fromdate;




$dates =  getDates($fromdate, $todate);


// print_r($dates);
// die(); 



foreach($users as $key => $user){

	// echo $e;
	// echo "<br>";
	//preparation

	//echo "<BR><BR>USER " . $key . "<BR>" ;
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

//print_r($users);

echo json_encode ($users);

$conn->close();


?>