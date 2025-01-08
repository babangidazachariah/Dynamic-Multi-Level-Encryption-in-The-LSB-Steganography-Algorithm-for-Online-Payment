<?php

	
	Function RequestClosedTransactions($bTransactionID,$mTransactionID){
		
		require_once(__DIR__ .'/../nusoapInclude.php');
		
		//CLIENT FUNCTION
		/*
			This function is called from getTransaction.php MakePayment function
			it provide the merchant side transactionID
		//*/
		
		$output = "";
		
				
		$client = new nusoap_client("http://146.148.55.110/lazada.com.my/cimb/webServicesServerFunctions.php");

		$output = $client->getError();
		if ($output) {
			$output = false;
		}
		//CloseTransaction($bTransactionID, $mTransactionID)
		$output = $client->call("CloseTransaction", array("bTransactionID" => $bTransactionID, "mTransactionID" => $mTransactionID));

		if ($client->fault) {
			//echo "<h2>Fault</h2><pre>";
			//print_r($result);
			//echo "</pre>";
			$output = "1";//Error
		}
		else {
			$output = $client->getError();
			if ($output) {
				//echo "<h2>Error</h2><pre>" . $error . "</pre>";
				$output = "0";
			}else {
				//echo "<h2>Books</h2><pre>";
			   $output = "1";
				//echo "</pre>";
				//header("location:index.php");
				//$error = true;
			}
			//*/
		}
	
		
		
		/*
		//Used for Debugging
		echo "<h2>Request</h2>";
		echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
		echo "<h2>Response</h2>";
		echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
		//*/
		return $output;
	}
	
	
	
	
	
	Function SetUpdateTrnsactionSecurity($transactionID, $bTransactionID, $customerAccountID, $merchantAccountID){
		/*
			NOTE: This function is not to be published as web service interface.
			It is used when user's approval of payment fails and the security details
			need to be changed. This the essence of removing it from its parent function, PaymentRequest.
		*/
		
		
		require_once(__DIR__ .'/../getSetSecurityParameters.php');
		require_once(__DIR__ .'/../notificationFunctions.php');
	
		
		$otpekDetails = GetSetSecurityParameters("trans".$transactionID.$bTransactionID);
		
		//print($otpekDetails);
		
		$otpekGenArray = explode("#",$otpekDetails );
		
		$otp = $otpekGenArray[0];
		$otpek = $otpekGenArray[1]; //Encryption
		
		$captcha = substr($otpek, 0,8); //first 8 characters for captcha creation
		$otpek = substr($otpek,11); //last five characters to be saved with the bank server.
		
		//Update security details.
		$otp = password_hash($otp, PASSWORD_DEFAULT);
		$sql = "UPDATE tblTransactions SET  transactionOtp ='".
													$otp."',transactionCaptcha ='".$captcha."',
												transactionOtek='".$otpek."'
												 WHERE bTransactionID =". $bTransactionID;

		$mysqli = connection();
		$result = $mysqli->query($sql);
		
		
		//FINALLY, WE SEND CUSTOMER A NOTIFICATION
		//First We get Merchant Name
		$sql = "SELECT * FROM tblMerchantInfo WHERE merchantAccountID =". $merchantAccountID ;

		$mysqli = connection();
		$result = $mysqli->query($sql);
		
		$merchantName =""; 
		while($row = $result->fetch_assoc()){
			$merchantName = $row['merchantName'];
		}
		
		//Get Customer Registered Device ID/token
		$deviceID = "";
		$sql = "SELECT * FROM tblRegisteredClients WHERE registeredAccountID =". $customerAccountID ;

		$mysqli = connection();
		$result = $mysqli->query($sql);
		
		while($row = $result->fetch_assoc()){
			$deviceID = $row['registeredDeviceID'];
		}
		$message = "Pending Payment Request From ". $merchantName; 
		SendNotification($deviceID , $message);
		return true;
	}
	
	
	function MerchantCancellationNotification($transactionID){
	
		/*/There should be parameter to know which merchant is to be notified.
			However, since we are dealing with one merchnant now, we do not
			use parameter.
			This function is usually called by cronJob.php
		*/
		$output = "";
		require_once(__DIR__ .'/../nusoapInclude.php');
				
		$client = new nusoap_client("http://146.148.55.110/lazada.com.my/cimb/webServicesServerFunctions.php");

		$output = $client->getError();
		if ($output) {
			$output = false;
		}
		//CloseTransaction($bTransactionID, $mTransactionID)
		$output = $client->call("Cancellation", array("transactionID" => $transactionID));

		if ($client->fault) {
			//echo "<h2>Fault</h2><pre>";
			//print_r($result);
			//echo "</pre>";
			$output = "1";//Error
		}
		else {
			$output = $client->getError();
			if ($output) {
				//echo "<h2>Error</h2><pre>" . $error . "</pre>";
				$output = "0";
			}else {
				//echo "<h2>Books</h2><pre>";
			   $output = "1";
				//echo "</pre>";
				//header("location:index.php");
				//$error = true;
			}
			//*/
		}
		return $output;
	}
	//SetUpdateTrnsactionSecurity(100, 100, 4, 2);
	//print(RequestClosedTransactions(11, 14));
?>