<?php
	
	/*
		HERE, THE MOBILE APP EXECUTES THE WEBSERVICE REQUEST DIRECTLY BY SPECIFYING
		THE FUNCTION NAME AND RESPECTIVE PARAMETERS.
	*/
	
	
	require_once(__DIR__ .'/../nusoapInclude.php');
	require_once $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
	require_once  $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/merchants/generalFunctions.php";
	///*
	if($_GET['funcName'] == "RequestPurchasedItems") {
		
		//Get the mtransactionID of this requesting bTransactionID
		$sql = "SELECT mTransactionID, transactionTotalAmount FROM tblTransactions WHERE bTransactionID =".$_GET['id'];
		
		$mysqli = connection();
		$result = $mysqli->query($sql);
		$transactionID = 0;
		$totalAmount = 0;
		while($row = $result->fetch_assoc()){
			$transactionID = $row['mTransactionID'];
			$totalAmount = $row['transactionTotalAmount'];
		}
		
		print(RequestPurchasedItems($transactionID) ."TOTAL@-@$totalAmount");
		
		
	}/*elseif($_GET['funcName'] == "RequestClosedTransactions") {
	
		$otp = $_GET['otp'];
		//Get the mtransactionID of this requesting bTransactionID
		$sql = "SELECT mTransactionID FROM tblTransactions WHERE bTransactionID =".$_GET['id'];
		
		$mysqli = connection();
		$result = $mysqli->query($sql);
		$mTransactionID = 0;
		$bTransactionID = trim($_GET['id']);
		while($row = $result->fetch_assoc()){
		
			
			$mTransactionID = $row['mTransactionID'];
		}
		
		print(RequestClosedTransactions($transactionID,$otp));
	}
	//*/
	
	Function RequestPurchasedItems($transactionID){
		//CLIENT FUNCTION
		//lazada.com.my 	http://146.148.55.110/
		
		$client = new nusoap_client("http://146.148.55.110/lazada.com.my/cimb/webServicesServerFunctions.php");

		$error = $client->getError();
		if ($error) {
			$error = false;
		}

		$result = $client->call("GetPurchasedItems", array("transactionID" => $transactionID));

		if ($client->fault) {
			//echo "<h2>Fault</h2><pre>";
			//print_r($result);
			//echo "</pre>";
			$error = "1";//Error
		}
		else {
			$error = $client->getError();
			if ($error) {
				//echo "<h2>Error</h2><pre>" . $error . "</pre>";
				$error = "1";
			}
			else {
				//echo "<h2>Books</h2><pre>";
			   return $result;
				//echo "</pre>";
				//header("location:index.php");
				//$error = true;
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
	
	
	
	//print(RequestPurchasedItems("33"));
?>