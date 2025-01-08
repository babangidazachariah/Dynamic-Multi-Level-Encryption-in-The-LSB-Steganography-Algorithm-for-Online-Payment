<?php
	//https://www.sitepoint.com/web-services-with-php-and-soap-1/  FOR TUTORIALS
	require_once(__DIR__ .'/../nusoapInclude.php');
	
	Function GetPurchasedItems($merchantUrl, $transactionID){
		
				
		$client = new nusoap_client("http://146.148.55.110/lazada.com.my/".$merchantUrl."/cimb/getPurchasedItems.php");

		$error = $client->getError();
		if ($error) {
			return  $error;
		}

		$result = $client->call("GetPurchasedItems", array("transactionID" =>$transactionID));

		if ($client->fault) {
			
			return $result;
			
		}
		else {
			$error = $client->getError();
			if ($error) {
				return  $error ;
			}
			else {
				
				return $result;
				
			}
		}


		
	}

?>