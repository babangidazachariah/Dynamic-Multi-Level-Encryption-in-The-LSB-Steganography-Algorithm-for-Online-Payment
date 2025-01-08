<?php
SESSION_START();
	require_once(__DIR__ .'/../nusoapInclude.php');
	require_once(__DIR__ .'/../connection.php');
	require_once(__DIR__ .'/../getSetSecurityParameters.php');
	
	Function MakeGetPurchasedItemsRequest($transactionID){
		//CLIENT FUNCTION
		$result ="";
		$client = new nusoap_client("http://146.148.55.110/lazada.com.my/cimb/webServicesFunctions.php");

		$error = $client->getError();
		if ($error) {
			//echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
			$result = false;
		}

		$result = $client->call("GetPurchasedItems", array("transactionID" => $transactionID));

		if ($client->fault) {
			//echo "<h2>Fault</h2><pre>";
			//print_r($result);
			//echo "</pre>";
			$result = false;
		}
		else {
			$error = $client->getError();
			if ($error) {
				//echo "<h2>Error</h2><pre>" . $error . "</pre>";
				$result = false;
			}
			
		}
		return $result;
	}
	
	
	Function PaymentRequest($transactionID, $customerAccountNumber, $merchantAccountNumber , $totalAmount){
		//SERVER FUNCTION
		
		$status = false;
		//for this function to execute, there must be the accountNumber and transactionID parameters
		
		if(!empty($transactionID) && !empty($customerAccountNumber)){
		
			$sql = "SELECT tblTransactions.* FROM tblTransactions WHERE tblTransactions.mTransactionID =".$transactionID ." AND tblAccounts.accountNumber = '". $customerAccountNumber . "'";
				
				$mysqli = connection();
				$result = $mysqli->query($sql);
				
				if($result->num_rows > 0){
					//Thetransactio ID is alredy registered.
					
					$status = false;
					
				}else{
				
					$customerAccountID = 0;
					$merchantAccountID = 0;
					
					$otp = "";
					$captcha = "";
					$otpek = "";
					
					$transactionDate = date('d-m-y');
					
					//Validate the supplied customer account Number and retrieve account ID
				
					
					$sql = "SELECT * FROM tblAccounts WHERE accountNumber ='". $customerAccountNumber . "'";
				
					$mysqli = connection();
					$result = $mysqli->query($sql);
					
					if($result->num_rows == 1){
						//Customer Account Valid
						
						while($row = $result->fetch_assoc()){
						
							$customerAccountID = $row['accountID'];
						}
						
						//validate Merchant Account Number
						$sql = "SELECT * FROM tblAccounts WHERE accountNumber ='". $merchantAccountNumber . "'";
				
						$mysqli = connection();
						$result = $mysqli->query($sql);
						
						if($result->num_rows == 1){
							//Merchant Account Valid
							
							while($row = $result->fetch_assoc()){
							
								$merchantAccountID = $row['accountID'];
							}
							
							//Get Captcha, OTP, OTEK
							//Insert Data into Transaction table and retrieve bTransactionID for setting 
							//of security parameters and filenames. Later update the security details, otp, otpek, and captcha
							$sql = "INSERT INTO tblTransactions (mTransactionID,
																	customerAccountID,
																	merchantAccountID,
																	transactionDate,
																	transactionClosed,
																	transactionTotalAmount
																	)
																VALUES(".$transactionID .",".
																		$customerAccountID .
																		$merchantAccountID .",'".
																		$transactionDate .
																		"','No',".
																		$totalAmount ."')".;
						
							$mysqli = connection();
							$result = $mysqli->query($sql);
							
							
							$bTransactionID = $result->insert_id;
							//GetSetSecurity Details
							$otpekDetails = GetSetSecurityParameters($transactionID.$bTransactionID);
							$otpekGenArray = explode("#",$otpekDetails );
							
							$otp = $otpekGenArray[0];
							$otpek = $otpekGenArray[1]; //Encryption
							
							$captcha = substr($otpek, 0,7); //first 8 characters for captcha creation
							$otpek = substr($otpek,8); //last eight characters to be saved with the bank server.
							//Update security details.
							$sql = "UPDATE tblTransactions SET  transactionOtp ='".
																		$otp."',
																	transactionCaptcha ='".
																		$captcha."',
																	transactionOtek='".
																		$otpek."',
																	 WHERE bTransactionID ='". $bTransactionID . "'";
				
							$mysqli = connection();
							$result = $mysqli->query($sql);
							
							$status = true;
						}//Merchant Account Validation end
						
					}//customer Account Validation end
				}
		}
		
		return $status;
	}
	
	Function test($id){
		$res = "here". $id;
		return $res;
	}
	
	$server = new soap_server();
	$server->register("PaymentRequest");
	$server->register("test");
	//$server->service($HTTP_RAW_POST_DATA);
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);
?>