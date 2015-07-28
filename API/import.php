<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

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
		} else {
		    echo "0 results";
		}
		

	
		if( count($user) > 0 ){
			//if name was found, return its id
			$result_id = $user[0]['user_id'];
			echo "exist: ";
		
		} else {
			//if name was not found, add to database and return inserted id
			$sql = "INSERT INTO users (fullname) VALUES ('$name')";

			if ($conn->query($sql) === TRUE) {
				$result_id = $conn->insert_id;
				echo "inser: ";
			
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
		} else {
		    echo "0 results";
		}


		

	
		if( count($project) > 0 ){
			//if name was found, return its id
			echo "exist: ";
			$result_id = $project[0]['project_id'];
			
		
		} else {
			//if name was not found, add to database and return inserted id
			$sql = "INSERT INTO projects (name) VALUES ('$project_name')";

			if ($conn->query($sql) === TRUE) {
				echo " insert: ";
				$result_id = $conn->insert_id;
				
			
			}
		}


		return $result_id;
	}

	//IMPLEMENTATION

	//echo "123";

	//if(isset($_POST["submit"]))
	if(1)
	{
	//	$file = $_FILES['file']['tmp_name'];
		$file = "../spreadsheet/sample-import-excel.csv";
		$handle = fopen($file, "r");
		$c = 0;
		$r = 0;
		//echo "234";

		while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
		{	
			if($r > 3){
				echo "asd";
				$fromdateArr = explode("/", $filesop[4]);
				$fromdate = $fromdateArr[2]. "-" . $fromdateArr[0] . "-" . $fromdateArr[1];
				$name = $filesop[8];

				echo "fromdate:" . $fromdate;
				echo "todate:" . $todate;
				echo "<br>";
				
				$todateArr = explode("/", $filesop[5]);
				$todate = $fromdateArr[2]. "-" . $todateArr[0] . "-" . $todateArr[1];
				$allocation = $filesop[6];
				$project_name = $filesop[9];
				

				$user_id = $alloc = str_replace($name, getUserIdByName($name), $name);
				
				// getUserIdByName($name);
				
				echo "userID: " . $user_id;
				$project_id = getProjectIdByName($project_name);
				echo "projectID: " . $project_id;
				 $from_date = $fromdate;
				$to_date = $todate;
				$alloc = str_replace("%", "", $allocation);
				

				$insertsql =  "INSERT INTO `sched`(`user_id`, `project_id`, `fromdate`, `todate`, `allocation`) VALUES ('{$user_id}','{$project_id}','{$from_date}','{$to_date}','{$alloc}')";

				echo $insertsql . "<br><br>";

				$c = $c + 1;

				if ($conn->query($insertsql) === TRUE) {
					$output['success'] = true;
					$output['message'] = "User has been added.";
				} else {
					$output['success'] = false;
					$output['message'] = $conn->error;
					echo $conn->error;
				}
			}
			$r = $r + 1;
		}
	}

?>



