<?php
	
	
	
			 
	Function SendNotification($deviceID, $message){
		///*
		//Getting api key 
		$api_key = 'AIzaSyBOwD7A0naPKbEqZTPxrKuoK9wUT-WnIF8';//$_POST['apikey'];	
		
		//Variable getting registered token 
		$reg_token = array($deviceID);
		
		//var_dump($reg_token);
		
		
		//Creating a message array 
		$msg = array
		(
			'message' 	=> $message,
			'title'		=> 'Message from Just-In-Time',
			'subtitle'	=> 'Android Push Notification using GCM Demo',
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon'
		);
		
		//Creating a new array fileds and adding the msg array and registration token array here 
		$fields = array
		(
			'registration_ids' 	=> $reg_token,
			'data'			=> $msg
		);
		
		//Adding the api key in one more array header 
		$headers = array
		(
			'Authorization: key=' . $api_key,
			'Content-Type: application/json'
		); 
		
		//Using curl to perform http request 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		//Getting the result 
		$result = curl_exec($ch );
		curl_close( $ch );
		
		//Decoding json from result 
		$res = json_decode($result);

		
		//Getting value from success 
		$flag = $res->success;
		
		
		//print( "FLAG: ".$flag);
		/*
		//if success is 1 means message is sent 
		if($flag == 1){
			//Redirecting back to our form with a request success 
			header('Location: indexSendNotification.php?success');
		}else{
			//Redirecting back to our form with a request failure 
			header('Location: indexSendNotification.php?failure');
		}
		//*/
		
	
	}
	
	
	
	
	Function RegisterDevice($params){
		
		include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
	
			//	 AIzaSyBOwD7A0naPKbEqZTPxrKuoK9wUT-WnIF8
		 //API KEY : AIzaSyBOwD7A0naPKbEqZTPxrKuoK9wUT-WnIF8
		 /*
		 $cardNumber = $_GET['cardNumber'];
		 $expiryMonth = $_GET['expiryMonth'];
		 $expiryYear = $_GET['expiryYear'];
		 $cardCVC = $_GET['cardCVC'];
		 $cardHolderName= $_GET['cardHolderName'];
		 $cardPin = $_GET['cardPin'];
		 $uniqueID = $_GET['uniqueID'];
		 */
		
		
		//From the cardType and cardNumber, we are able to know if there exist an account Number with such associated cardNumber
		
		// $params = $_GET['params'];
		$status = "";
		$output = explode("^^",$params);
		 
		 //print(count($output));
		// for($i = 0; $i < count($output); $i++){
		//	print($output[$i] .'<br />');
		// }	
		 //generatedID+" "+cardNumber+" "+expiryMonth+" "+expiryYear+" "+cardCVC+" "+cardPin+" "+ cardHolderName;
		 
		 //escape strings with mysqli
		 $deviceUniqueID = trim($output[0]);
		 $cardNumber = trim($output[1]);
		 $expiryMonth = trim($output[2]);
		 $expiryYear = trim($output[3]);
		 $cardCVC = trim($output[4]);
		 $cardPin = trim($output[5]);
		 $cardHolderName= trim($output[6]);
		 $cardType = trim($output[7]);
		 
		 
		 $cardHolderName = str_replace("**"," ",$cardHolderName);
		 
		/*
		$han = fopen("trace.txt", "w");

		fwrite($han, "cardNumber: ". $cardNumber);
		fwrite($han, "expiryMonth: ". $expiryMonth);
		fwrite($han, "expiryYear: ". $expiryYear);
		fwrite($han, "cardCVC: ". $cardCVC);
		fwrite($han, "cardPin: ". $cardPin);
		fwrite($han, "cardHolderName: ". $cardHolderName);
		fwrite($han, "cardType: ". $cardType);
		fclose($han);
		//*/
		
			 
		$mysqli = connection();
		
		 if($deviceUniqueID =='' || $cardNumber == '' || $expiryMonth == '' || $expiryYear == '' || $cardCVC == '' || $cardPin == '' || $cardHolderName == ''){
			$status ="5"; // 'Could Not Be Registered - Missing Values!!!';
		 }else{
		 
				//Vallidate User Card
			 $sql = "SELECT * FROM tblCards WHERE cardNumber = '$cardNumber' AND cardType ='$cardType' 
					AND cardExperyMonth ='$expiryMonth' AND cardExperyYear ='$expiryYear' 
					AND cardCVC = '$cardCVC' AND cardPin = '$cardPin'";
			 
			 
			$result = $mysqli->query($sql);
			/*
			$han = fopen("trace.txt", "w");
			fwrite($han, "SQL: ". $sql);
			fclose($han);
			//*/
			
			$accountID = "";
			if($result->num_rows == 1){
			
				//User Card Is Valid
				while($row = $result->fetch_assoc()){
				
					$accountID = $row['cardAccountID'];
				}
				
				if(!empty($accountID)){
					//Validate that the device is not already registered or is a Re-Registration.
					 $sql = "SELECT * FROM tblRegisteredClients WHERE registeredDeviceID = '$deviceUniqueID' OR registeredAccountID ='$accountID'";
				 
					$result = $mysqli->query($sql);
					
					if($result->num_rows > 0){
					
						//User Has Registered Before
						$tempDevID ="";
						$tempAccID = "";
						while($row = $result->fetch_assoc()){
						
							$tempDevID = $row['registeredDeviceID'];
						
							$tempAccID = $row['registeredAccountID'];
						}
						
						if(($tempDevID == $deviceUniqueID) && ($tempAccID == $accountID)){
						
							//Same device with same ID is registered. Thus, we reject re-registration.
							//Or We do nothing.
							$status = "4";//"Already Registered!!!";
						}elseif(($tempDevID != $deviceUniqueID) && ($tempAccID == $accountID)){
							//we update deviceUniqueID
							$sql = "UPDATE tblRegisteredClients SET registeredDeviceID = '$deviceUniqueID' WHERE registeredAccountID ='$accountID'";
				 
							$result = $mysqli->query($sql);
							
							$status = "1";//"Successfully Completed!!!";
					
						}elseif(($tempDevID == $deviceUniqueID) && ($tempAccID != $accountID)){
						
							//we update Account ID
							$sql = "UPDATE tblRegisteredClients SET registeredAccountID ='$accountID' WHERE registeredDeviceID = '$deviceUniqueID'";
				 
							$result = $mysqli->query($sql);
						}
						
						$status = "1";//"Successfully Completed!!!";
					}else{
						//A New Registration
						$sql = "INSERT INTO tblRegisteredClients ( registeredDeviceID, registeredAccountID)
												VALUES ('$deviceUniqueID', '$accountID')";
				 
						$result = $mysqli->query($sql);
						if($mysqli->insert_id > 0){
							$status = "1";// Successfull Registration
						}else{
							$status = "3";//"Incompleted Registration Try Again!!!";
						}
					}
				}
					//echo 'Already Registered';
			}else{
				$status = "2";//"Invalid Card Details";
			}
			mysqli_close($con);
			
		 }
		
		/*
		 //Debugging Purpose: Write to a file to view passed values of parameters
		 $myFile = fopen("debugText.txt", 'w');
		 
		 //fwrite($myFile,$params);
		 
		fwrite($myFile,$uniqueID .'##' .$cardNumber .'##' .$expiryMonth .'##' .$expiryYear .'##' .$cardCVC .'##' .$cardPin .'##' .$cardHolderName .'##'.$ins);
		 
		 fclose($myFle);
		*/
		
		return $status;
	}
	
	Function RegisterUser($username, $password){
	
		include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
		
		$response ="";
		
		$mysqli = connection();
		
		$sql = "SELECT * FROM tblLogin WHERE username = '$username'";
				 
		$result = $mysqli->query($sql);
		
		if($result->num_rows < 1){
			//Nobody is curreently Using username
			$hashPass = password_hash($password, PASSWORD_DEFAULT);
			$sql = "INSERT INTO tblLogin (username, password)
													VALUES ('$username', '$hashPass')";
					 
			$result = $mysqli->query($sql);
			
			if($mysqli->insert_id > 0){
				
				
				$response = "1"; //Successfull Login
			}else{
				$response = "0"; //Unsuccessful Login
			}
		}else{
			$response = "2"; //Username Exist
		}
		return $response;
	}
	
Function Login($username, $password){
		
		include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
		
		$response ="";
		$mysqli = connection();
		
		$sql = "SELECT * FROM tblLogin WHERE username = '$username'";
				 
		$result = $mysqli->query($sql);
		
		if($result->num_rows > 0){
		
			while($row = $result->fetch_assoc()){
				$pass = $row['password'];
				
				if(password_verify($password, $pass)){
					
					$response = "1"; //Successfull Login
				}else{
					$response ="0"; //Unsuccessful Login: Wrong Password
				}
			}
		
		}else{
			$response = "0"; //Unsuccessful Login
		}
		
		return $response;
	}
	
	/*
	$deviceID="e-muw3ciDJ4:APA91bEepvolufHIaKAU-WEa2U_mnE9filZW76f1suvtjhxrNlNVy2kMM4FLZanYACuj89pQzd5y7PsS_MQ1WGr_HiTn3hPkjysMzsf77khFkZV8b8aQKgux8qqzkl8x3bfswhWxGBLU";
	$message="Messages Here!!!";
	print(SendNotification($deviceID, $message
	//*/
?>