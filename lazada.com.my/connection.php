<?php
	
	function connection(){
		$host = "localhost";
		$user = "root";
		$pwd = "DA66504742ddy";
		$db = "Lazada";
		// Connect to database.
		$conn;
		try {
			$conn = new mysqli($host, $user, $pwd, $db);
			//$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			//$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
		}
		catch(Exception $e){
			//die($e->getMessage());
		}
		
		return $conn;
	}
	
	/*
	mysqli_report(MYSQLI_REPORT_OFF); //Turn off irritating default messages

	$mysqli = connection();
	
	if(!$mysqli){
		print("Error:");
	}else{
		print_r($mysqli);
	}
	//*/
	/*
	$sql = "SELECT * FROM tblAccounts ";
	$result = $mysqli->query($sql);

	if ($mysqli->error) {
		try {    
			throw new Exception("MySQL error $mysqli->error <br> Query:<br> $query", $msqli->errno);    
		} catch(Exception $e ) {
			echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
			echo nl2br($e->getTraceAsString());
		}
	}
	while($row = $result->fetch_assoc()){
		echo $row['accountName'];
	}
	//*/
	
	//var_dump(connection());
?>
