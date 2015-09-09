
<?php

include("../config/connection.php");

		include("../config/auth.php");

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
			echo "Existing User: " . $name."<br>";

		
		} else{
			//if name was not found, add to database and return inserted id
			$sql = "INSERT INTO users (fullname) VALUES ('$name')";

			if ($conn->query($sql) === TRUE) {
				$result_id = $conn->insert_id;
				echo "New User Inserted: ".$name."<br>";
			
			}
		}
		


		return $result_id;
	}

function getTeamId($team_name){
 		
		global $conn;

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
 
		$sql = "SELECT `team_id` FROM `teams` WHERE `name`= '".$team_name."'";
		$result = $conn->query($sql);
		$team = Array();
		
		if ($result ->num_rows > 0) {
		    while($row = $result -> fetch_assoc()) {
    			$team[] = $row;
		    }
		} 
		

	
		if( count($team) > 0 ){
			//if name was found, return its id
			$result_id = $team[0]['team_id'];
			echo "Existing Team: ".$team_name."<br>"."<br>";
			
		} else{
			//if name was not found, add to database and return inserted id
			$created = date("Y-m-d h:i:s");
			if(trim($team_name) != '' ){
				$sql = "INSERT INTO teams (name,created) VALUES ('$team_name','$created')";

				if ($conn->query($sql) === TRUE) {
					echo " New Team Inserted: " . $team_name."<br>"."<br>";
					$result_id = $conn->insert_id;
					

				}
			}

		}


		return $result_id;
	} 
	
function getcolumnCount(){
	$r=1;
		$file = $_FILES['file']['tmp_name'];
		$handle = fopen($file, "r");	

		while(($filesop = fgetcsv($handle, 1000, ",")) !== false){ 
				if($r == 1){
				
				 return count($filesop);

			}
		
}
return count($filesop);
}

if(isset($_POST["submit"])){

	$colCount = getcolumnCount();



	for( $i=0; $i<$colCount; $i++){
	
		$teamID = null;
		

		$r = 1;

		$file = $_FILES['file']['tmp_name'];
		$handle = fopen($file, "r");	

		while(($filesop = fgetcsv($handle, 1000, ",")) !== false){ 
			
			
			
			if($r == 1){
				$teamID = getTeamId($filesop[$i]);
				$team_name = $filesop[$i];
			}
			
			if($r > 1){

				$userId = getUserIdByName($filesop[$i]);
				$name = $filesop[$i];


				

				global $conn;

				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				} 
		 
				
				$sql = "UPDATE users SET  team_id='" . $teamID . "' WHERE user_id='" . $userId. "'";
				$result = $conn->query($sql);
				$user = Array();
				
				if ($conn->query($sql) === TRUE) {
							$output['success'] = true;
							$output['message'] = "User has been Updated.";
							echo "team_id:". $teamID ."<br>"."<br>";

				} else {
					$output['success'] = false;
					$output['message'] = $conn->error;
					echo $conn->error;
				}
			}

			$r = $r + 1;		
		}					
	}
		

		
			
	} 




?>