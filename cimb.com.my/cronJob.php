<?php
	//server 1 key: AIzaSyC27GTXqjWjei1HY0hIjQElqgbSmCVT1mk
	
	//$password = password_hash("xDecronJobBangisX", PASSWORD_DEFAULT);
	$user = $_GET['user'];
	$pass = $_GET['pass'];
	$today = date("Y-m-d H:i:s");
	
	require_once 'notificationFunctions.php';
	include_once  'merchants/generalFunctions.php';
	
	if($user == "DeBangis" && $pass == "xDe66504742BangisX"){
		require_once 'connection.php';
		
		
		$sql = "SELECT tblTransactions.bTransactionID, tblTransactions.mTransactionID,
					tblTransactions.transactionDate, tblRegisteredClients.registeredDeviceID, 
					tblAccounts.accountName FROM tblTransactions, tblRegisteredClients, 
					tblAccounts WHERE tblTransactions.transactionDate < '$today' 
					AND tblTransactions.transactionClosed = 'No' AND 
					tblRegisteredClients.registeredAccountID = tblTransactions.customerAccountID 
					AND tblTransactions.merchantAccountID = tblAccounts.accountID";
		
		
		$mysqli = connection();
		$result = $mysqli->query($sql);
		
		if($result->num_rows > 0){
		
			$today = new DateTime($today);
			while($row = $result->fetch_assoc()){
				///*
				$bTransactionID = $row['bTransactionID'];
				$mTransactionID = $row['mTransactionID'];
				$deviceID = $row['registeredDeviceID'];
				$merchant = $row['accountName'];
				$transactionDateTime = new DateTime($row['transactionDate']);
				
				$dateTimeDiff = $transactionDateTime->diff($today);
				
				if($dateTimeDiff->i > 30){
				
					if($dateTimeDiff->i > 59){
						///*
						$subSql = "DELETE FROM tblTransactions WHERE bTransactionID = $bTransactionID ";
						
						$subMysqli = connection();
						$subMysqli->query($subSql);
						
						//Notify Merchant about Cancellation.
						MerchantCancellationNotification($mTransactionID);
						
						//Notify Customer about Cancellation.
						$message ="Your Order with " . $merchant . " has been Cancelled Due to Your Delay in Payment.";
						SendNotification($deviceID, $message);
						//*/
					}else{
					
						//Notify Customer about Cancellation.
						
						$message ="Your Order with ". $merchant . " will soon be Cancelled. Payment Now.";
						SendNotification($deviceID, $message);
					
					}
				
				}
				
				//*/
			}
		}
	}
?>