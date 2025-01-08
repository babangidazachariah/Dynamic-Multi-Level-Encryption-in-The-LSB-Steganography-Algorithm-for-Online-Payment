<?php
SESSION_START();
require_once 'notificationFunctions.php';
$sql = "SELECT * FROM tblMerchantInfo WHERE merchantAccountID =2";
					
	$mysqli = connection();
	$result = $mysqli->query($sql);
	
	$merchantName =""; 
	while($row = $result->fetch_assoc()){
		$merchantName = $row['merchantName'];
	}
	
	//Get Customer Registered Device ID/token
	$deviceID = "";
	$sql = "SELECT * FROM tblRegisteredClients WHERE registeredAccountID =4";

	$mysqli = connection();
	$result = $mysqli->query($sql);
	
	while($row = $result->fetch_assoc()){
		$deviceID = $row['registeredDeviceID'];
	}
	$message = "You Have A Pending Payment Request From ". $merchantName; 
	print("Here :  ". SendNotification($deviceID , $message) ."<br />");
	PRINT($deviceID);
?>
<!DOCTYPE html>

<html>
	<head>
		<title>Android Push Notification using GCM</title>
	</head>
	
	<body>
	
		<h1>Android Push Notification using GCM</h1>
		
		<form method='POST' action='indexSendNotification.php'>
			
			<input type='text' name='apikey' placeholder='Enter API Key' />
			<input type='text' name='regtoken' placeholder='Enter Device Registration Token' />
			
			<textarea name='message' placeholder='Enter a message'></textarea>
		
			<button>Send Notification</button>
		</form>
		<p>
			<?php
				echo $_SESSION['token'];
				//if success request came displaying success message 
				if(isset($_REQUEST['success'])){
					echo "<strong>Cool!</strong> Message sent successfully check your device...";
				}
				//if failure request came displaying failure message 
				if(isset($_REQUEST['failure'])){
					echo "<strong>Oops!</strong> Could not send message check API Key and Token...";
				}
			?>
		</p>
		
	</body>
	
</html>