<?php
	//require_once(__DIR__.'/../nusoap-0.9.5/lib/nusoap.php';
	
	
	require_once(__DIR__ .'/../nusoapInclude.php');
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

								
		//$result = $client->call("getProd", array("transactionID" => "books"));
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
			    //echo $result;
				//echo "</pre>";
				//header("location:index.php");
				$error = true;
			}
		}
		
		
		/*
		//Used for Debugging
		echo "<h2>Request</h2>";
		echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
		echo "<h2>Response</h2>";
		echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
		//*/
		
		
		return $error;
	}
	
	//print(MakePaymentRequest(33, "1247781221", "1234567890", 233));
?>