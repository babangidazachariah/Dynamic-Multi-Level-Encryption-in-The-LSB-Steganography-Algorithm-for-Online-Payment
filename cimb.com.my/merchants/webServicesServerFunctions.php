<?php
	require_once(__DIR__ .'/../nusoapInclude.php');
	include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
	
	
	function getProd($category) {
		if ($category == "books") {
			return join(",", array(
				"The WordPress Anthology",
				"PHP Master: Write Cutting Edge Code",
				"Build Your Own Website the Right Way"));
		}
		else {
				return "No products listed under that category";
		}
	}
	
	Function PaymentRequest($transactionID, $customerAccountNumber, $merchantAccountNumber , $totalAmount){
		//SERVER FUNCTION
		
		include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/merchants/generalFunctions.php";
		
		$customerAccountID = 0;
		$merchantAccountID = 0;
		$merchantName = "";
		$otp = "";
		$captcha = "";
		$otpek = "";
		$status = false;
		//$status = "Begin";
		//for this function to execute, there must be the accountNumber and transactionID parameters
		
		if(!empty($transactionID) && !empty($customerAccountNumber)){
		
			$sql = "SELECT tblTransactions.* FROM tblTransactions, tblAccounts WHERE tblTransactions.mTransactionID =".$transactionID ." AND tblAccounts.accountNumber = '". $customerAccountNumber . "'";
				
				$mysqli = connection();
				$result = $mysqli->query($sql);
				
				//$status .= "Step One";
				if($result->num_rows > 0){
					//Thetransactio ID is alredy registered.
					
					$status = false;
					
				}else{
				
					
					
					$transactionDate = date("Y-m-d H:i:s");
					
					//Validate the supplied customer account Number and retrieve account ID
				
					
					$sql = "SELECT * FROM tblAccounts WHERE accountNumber ='". $customerAccountNumber . "'";
					//$status .= " " .$sql." ";
					$mysqli = connection();
					$result = $mysqli->query($sql);
					//$status .= "Step Two";
					if($result->num_rows == 1){
						//Customer Account Valid
						
						while($row = $result->fetch_assoc()){
						
							$customerAccountID = $row['accountID'];
						}
						
						//validate Merchant Account Number
						$sql = "SELECT * FROM tblAccounts WHERE accountNumber ='". $merchantAccountNumber . "'";
						//$status .= " " .$sql." ";
						$mysqli = connection();
						$result = $mysqli->query($sql);
						
						//$status .= "Step Three";
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
																		$customerAccountID .",".
																		$merchantAccountID .",'".
																		$transactionDate .
																		"','No',".
																		$totalAmount .")";
						
							$mysqli = connection();
							$result = $mysqli->query($sql);
							
							
							$bTransactionID = $mysqli->insert_id;
							//GetSetSecurity Details
							
							SetUpdateTrnsactionSecurity($transactionID, $bTransactionID, $customerAccountID, $merchantAccountID);
							
							$status = true;
						}else{
							//Merchant Account Validation end
							$status = "2";
						}
						
					}else{
					//customer Account Validation end
						$status = "3";
					}
				
				}/*else{
					$status = "4";
					
						
				}
				*/
		}
		
		return $status;
	}
	
	
	///*
	$server = new soap_server();
	$server->register("getProd");
	$server->register("PaymentRequest");
	
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	
	$server->service($HTTP_RAW_POST_DATA);
	//*/
	//print(PaymentRequest( 50,"1247781221","1234567890",12));
?>