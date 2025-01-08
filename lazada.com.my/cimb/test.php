<?php

//inside cimb
	print("<h1>cimb/test.php</h1><br />");
	print("../write.php.. is being Called <br />".$_SERVER["DOCUMENT_ROOT"].'/lazada.com.my/nusoap-0.9.5/lib/nusoap.php');
	require_once(__DIR__ .'/../write.php');
	require_once($_SERVER["DOCUMENT_ROOT"].'/cimb/Backup/backupTest.php');
	print("..write.php.. Called, Connected and Complete <br />Completing cimb/test.php execution..<br />");
	print(" cimb/test.php returning to test<br />");
	/*
	Function MakePaymentRequest($transactionID, $customerAccountNumber, $merchantAccountNumber, $totalAmount){
		//CLIENT FUNCTION
		//Since we're dealing with one Bank for this thesis, the merchantID and customerBank name are hardcoded. However, the 
		//standard function call is as defined.
	
	
		$client = new nusoap_client("http://104.199.190.90/cimb.com.my/merchants/webServicesServerFunctions.php");

		$error = $client->getError();
		if ($error) {
			$error = false;
		}

		$result = $client->call("PaymentRequest", array("transactionID" => $transactionID,
							
								"accountNumber" =>$customerAccountNumber,
								"merchantAccountNumber" => $merchantAccountNumber,
								"totalAmount" => $totalAmount));

		if ($client->fault) {
			//echo "<h2>Fault</h2><pre>";
			//print_r($result);
			//echo "</pre>";
			$error = false;
		}
		else {
			$error = $client->getError();
			if ($error) {
				//echo "<h2>Error</h2><pre>" . $error . "</pre>";
				$error = false;
			}
			else {
				//echo "<h2>Books</h2><pre>";
			   // echo $result;
				//echo "</pre>";
				header("location:index.php");
				$error = true;
			}
		}
		return $error;
	}
	
	Fucntion testClient()
	{
	
	
			
		
		
		$client = new nusoap_client("http://104.199.190.90/cimb.com.my/merchants/webServicesServerFunctions.php");

		$error = $client->getError();
		if ($error) {
			echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
		}

		$result = $client->call("PaymentRequest", array("transactionID" => 3,
														"cusAccount"=>"0987654321",
														"merAccount"=>"1234567890",
														"total"=>12));

		if ($client->fault) {
			echo "<h2>Fault</h2><pre>";
			print_r($result);
			echo "</pre>";
		}
		else {
			$error = $client->getError();
			if ($error) {
				echo "<h2>Error</h2><pre>" . $error . "</pre>";
			}
			else {
				echo "<h2>Books</h2><pre>";
				echo $result;
				echo "</pre>";
			}
		}
		echo "<h2>Request</h2>";
		echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
		echo "<h2>Response</h2>";
		echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
	}
	
	//*/
?>