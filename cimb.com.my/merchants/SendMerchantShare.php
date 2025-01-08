<?php

	Function SendMerchantShare($image, $fileName){
		
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

		$output = $client->call("ReceiveMerchantShare", array("image" => $image,"fileName"=>$fileName));

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
	/*
	$dir = $_SERVER['DOCUMENT_ROOT'].'/cimb.com.my/merchants/TransactionCaptchas';
	$fileName = 'trans129';
	$image = base64_encode(file_get_contents($dir ."/". $fileName  . "ShareOne.png"));
			
	//$fileName = $fileName  . "ShareTwo.png";
	
	SendMerchantShare($image, $fileName."ShareTwo.png");
	//*/
?>