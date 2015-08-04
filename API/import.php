<style type="text/css">
	*{
		font-family: Arial;
		font-size: 12px;
	}
</style>
<?php

		include("connection.php");

		function getUserIdByName($name){

		global $conn;

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
 
		$sql = "SELECT `user_id` FROM `users` WHERE `fullname`= '".$name."'";
		$result = $conn->query($sql);
		$user = Array();
		
		if ($result ->num_rows > 0) {
		    while($row = $result -> fetch_assoc()) {
    			$user[] = $row;
		    }
		} 
		

	
		if( count($user) > 0 ){
			//if name was found, return its id
			$result_id = $user[0]['user_id'];
			echo "Existing User: ";
		
		} else {
			//if name was not found, add to database and return inserted id
			$sql = "INSERT INTO users (fullname) VALUES ('$name')";

			if ($conn->query($sql) === TRUE) {
				$result_id = $conn->insert_id;
				echo "New User Inserted: ";
			
			}
		}


		return $result_id;
	}

	function getProjectIdByName($project_name){

		global $conn;

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
 
		$sql = "SELECT `project_id` FROM `projects` WHERE `name`= '".$project_name."'";
			
		$result = $conn->query($sql);
		$project = Array();
		
		if ($result ->num_rows > 0) {
		    while($row = $result -> fetch_assoc()) {
    			$project[] = $row;
		    }
		} 

		

	
		if( count($project) > 0 ){
			//if name was found, return its id
			echo "Existing Project: ";
			$result_id = $project[0]['project_id'];
			
		
		} else {
			//if name was not found, add to database and return inserted id
			$sql = "INSERT INTO projects (name) VALUES ('$project_name')";

			if ($conn->query($sql) === TRUE) {
				echo " New Project Inserted: ";
				$result_id = $conn->insert_id;
				
			
			}
		}


		return $result_id;
	}


	//IMPLEMENTATION

	//echo "123";

	if(isset($_POST["submit"])){
		if(1)
		{
		$file = $_FILES['file']['tmp_name'];
		
		$handle = fopen($file, "r");
		$c = 0;
		$r = 0;
		//echo "234";

		while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
		{	
			if($r > 3){
				
				$fromdateArr = explode("/", $filesop[4]);
				$fromdate = $fromdateArr[2]. "-" . $fromdateArr[0] . "-" . $fromdateArr[1];
				$name = $filesop[8];

				
				
				$todateArr = explode("/", $filesop[5]);
				$todate = $fromdateArr[2]. "-" . $todateArr[0] . "-" . $todateArr[1];
				$allocation = $filesop[6];
				$project_name = $filesop[9];
				 

				$user_id = $alloc = str_replace($name, getUserIdByName($name), $name);
				
				// getUserIdByName($name);
				
				echo  "ID (". $user_id . ") " . $name. " "  ."<br>";
				$project_id = getProjectIdByName($project_name);
				echo "ID (" . $project_id. ") " . $project_name . "<br>";
				 $from_date = $fromdate;
				$to_date = $todate;
				$alloc = str_replace("%", "", $allocation);
				

				global $conn;

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
 
		$sql = "SELECT `sched_id` FROM `sched` WHERE `user_id`= '" .$user_id. "' AND  `fromdate` = '" .$from_date. "' AND `todate` = '" .$to_date . "'";
			
		$result = $conn->query($sql);
		$sched = Array();
		
		if ($result ->num_rows > 0) {
		    while($row = $result -> fetch_assoc()) {
    			$sched[] = $row;
		    }
		} 

		

	
		if( count($sched) > 0 ){
			//if name was found, return its id
			echo "Existing Schedule (".$result_id .") " . $name . " " .$from_date. " to " .$to_date. " " .$alloc."<br>" . "<br>" ;
			$result_id = $sched[0]['sched_id'];
			
		
		} else {
			//if name was not found, add to database and return inserted id
			$sql = "INSERT INTO `sched`(`user_id`, `project_id`, `fromdate`, `todate`, `allocation`) VALUES ('{$user_id}','{$project_id}','{$from_date}','{$to_date}','{$alloc}')";

			

				

				$c = $c + 1;

				if ($conn->query($sql) === TRUE) {
					$output['success'] = true;
					$output['message'] = "Schedule has been added.";
					echo "New Schedule Inserted For User (" . $user_id . "): " . $from_date . " to " . $to_date . ", " . $project_name . " " .$alloc. "% " ."<br>"."<br>";

				} else {
					$output['success'] = false;
					$output['message'] = $conn->error;
					echo $conn->error;
					}
		}


		
				}	
				$r = $r + 1;
			}
			
		}
	}
	echo "Import Complete"."<br>"."<br>";
?>



