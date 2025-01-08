<?php
		
		
		
		
		if((!empty($_GET['registeredDevice'])) && (!empty($_GET['funcName'])) && (!empty($_GET['requestType']))){
				
				
			$registeredDevice = $_GET['registeredDevice'];
			$requestType = $_GET['requestType'];
			
			if($_GET['funcName'] == "GetPendingTransactions"){
			
				print(GetPendingTransactions($registeredDevice, $requestType));
				
			}elseif($_GET['funcName'] == "GetPaidTransactions"){
			
				print(GetPaidTransactions($registeredDevice, $requestType));
				
			}elseif($_GET['funcName'] == "GetIDSAndOtp"){
			
				print(GetIDSAndOtp($_GET['id']));
				
			}elseif($_GET['funcName'] == "MakePayment"){
			
				$response = MakePayment($_GET['id'], $_GET['otp']);
				print($response);
				
			}elseif($_GET['funcName'] == 'GetMerchantUrl'){
			
				print(GetMerchantUrl($_GET['id']));
				
			}elseif($_GET['funcName'] == 'GetMerchantInfo'){
			
				print(GetMerchantInfo());
				
			}elseif($_GET['funcName'] == 'GetMerchantIDs'){
			
				print(GetMerchantIDs());
			}
			//end of if(!empty($_GET['registeredDevice']))	
		}
		
		function GetMerchantInfo(){
		
			include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
			//Rewrite the Json content
			$androidMerchantJson = "[";
			
			$mysqli = connection();
			$sql = "SELECT * FROM tblMerchantInfo ORDER BY merchantName";
			
			$result = $mysqli->query($sql);
			
			//var_dump($result);
			
			while($row = $result->fetch_assoc()){
			
				//print('Here');
				$androidMerchantJson .='	
{			
	"title":"'.$row['merchantName'].'",
	"image":"http://104.199.190.90/cimb.com.my/merchants/logo/'.$row['merchantLogo'].'",
	"rating":"'.$row['merchantTheme'].'",
	"releaseYear": " ",
	"genre":["'.$row['merchantUrl'].'"]
},';

			}
			
			
			
			$androidMerchantJson = substr($androidMerchantJson,0,-1);
			$androidMerchantJson .= "]";
			
			return $androidMerchantJson;
		}
		
		
		function GetMerchantIDs(){
		
			include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
			
			//Get the merchantID of this requesting bTransactionID
			$sql = "SELECT * FROM tblMerchantInfo ORDER BY merchantName";
			
			$mysqli = connection();
			$result = $mysqli->query($sql);
			$outPut = "";
			while($row = $result->fetch_assoc()){
				$outPut .= trim($row['merchantID']). " # ";
			}
		
			return $outPut;
		}
		function GetMerchantUrl($merchantID){
		
			$url ="";
		
			include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
			
			$sql = "SELECT merchantUrl FROM tblMerchantInfo WHERE merchantID = $merchantID";
			
			$mysqli = connection();
			
			$result = $mysqli->query($sql);
			
			while($row = $result->fetch_assoc()){
			
				$url = trim($row['merchantUrl']);
			}
			
			return $url;
		}
		
		
		Function GetIDSAndOtp($transactionID){
		
			include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
			
			//Get the mtransactionID of this requesting bTransactionID
			$sql = "SELECT mTransactionID, transactionOtek FROM tblTransactions WHERE bTransactionID =".$transactionID;
			
			$mysqli = connection();
			$result = $mysqli->query($sql);
			$outPut = "";
			while($row = $result->fetch_assoc()){
				$outPut = $row['mTransactionID'].$transactionID . "#".$row['transactionOtek'];
			}
		
			return $outPut;
		}
		Function GetPendingTransactions($registeredDevice, $requestType){
		
			include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
		
			//Rewrite the Json content
			$androidMerchantJson = "[";
				
			$mysqli = connection();
			$sql = "";
			$sql = "SELECT tblTransactions.bTransactionID,tblTransactions.transactionDate, tblTransactions.transactionTotalAmount,
							tblMerchantInfo.merchantName, tblMerchantInfo.merchantUrl, tblMerchantInfo.merchantLogo   
							FROM tblTransactions, tblMerchantInfo, tblRegisteredClients 
							WHERE tblTransactions.customerAccountID = tblRegisteredClients.registeredAccountID 
								AND tblTransactions.merchantAccountID = tblMerchantInfo.merchantAccountID
								AND tblTransactions.transactionClosed = 'No' 
								AND tblRegisteredClients.registeredDeviceID ='". $registeredDevice."' 
							ORDER BY tblTransactions.transactionDate";
			
			
			//$result = $mysqli->query($sql);
				
			//mysqli_report(MYSQLI_REPORT_OFF); //Turn off irritating default messages

			//$mysqli = new mysqli($host, $user,$pwd, $db);
			$result = $mysqli->query($sql);

			/*
			if ($mysqli->error) {
				try {    
					throw new Exception("MySQL error $mysqli->error <br> Query:<br> $sql", $msqli->errno);    
				} catch(Exception $e ) {
					echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
					echo nl2br($e->getTraceAsString());
				}
			}else{
				echo $sql;
			}
			//*/
			//var_dump($result);
				if($requestType == "JSON"){
					while($row = $result->fetch_assoc()){
				
					//print('Here');
						$androidMerchantJson .='	
	{			
		"title":"'.$row['merchantName'].'",
		"image":"http://104.199.190.90/cimb.com.my/merchants/logo/'.$row['merchantLogo'].'",
		"rating":"RM'.$row['transactionTotalAmount'].'",
		"releaseYear": "'.$row['transactionDate'].'",
		"genre":["'.$row['merchantUrl'].'"]
	},';

					}
				
				
				
					$androidMerchantJson = substr($androidMerchantJson,0,-1);
					$androidMerchantJson .= "]";
					
					
					$han = fopen("trace.txt", "w");
					fwrite($han, $androidMerchantJson);
					fclose($han);
					
					
					return $androidMerchantJson ;
					
					
				}elseif($requestType == "IDList"){
					
					$transactionIDList = "";
					while($row = $result->fetch_assoc()){
						$transactionIDList .= $row['bTransactionID']."#";
					}
					$transactionIDList = substr($transactionIDList, 0, -1);
					
					return $transactionIDList;
				}
		}
		
		Function GetPaidTransactions($registeredDevice, $requestType){
		
			include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
		
			$androidMerchantJson = "[";
			
			
			$mysqli = connection();
			$sql = "";
			
			$sql = "SELECT tblTransactions.bTransactionID,tblTransactions.transactionCloseDate, tblTransactions.transactionTotalAmount,
						tblMerchantInfo.merchantName, tblMerchantInfo.merchantUrl, tblMerchantInfo.merchantLogo   
						FROM tblTransactions, tblMerchantInfo, tblRegisteredClients 
						WHERE tblTransactions.customerAccountID = tblRegisteredClients.registeredAccountID 
							AND tblTransactions.merchantAccountID = tblMerchantInfo.merchantAccountID
							AND tblTransactions.transactionClosed = 'Yes' 
							AND tblRegisteredClients.registeredDeviceID ='". $registeredDevice."' 
						ORDER BY tblTransactions.transactionCloseDate";
			
			$result = $mysqli->query($sql);
			
			//var_dump($result);
			if($requestType == "JSON"){
				while($row = $result->fetch_assoc()){
			
				//print('Here');
					$androidMerchantJson .='	
{			
	"title":"'.$row['merchantName'].'",
	"image":"http://104.199.190.90/cimb.com.my/merchants/logo/'.$row['merchantLogo'].'",
	"rating":"RM'.$row['transactionTotalAmount'].'",
	"releaseYear": "'.$row['transactionCloseDate'].'",
	"genre":["'.$row['merchantUrl'].'"]
},';

				}
			
			
			
				$androidMerchantJson = substr($androidMerchantJson,0,-1);
				$androidMerchantJson .= "]";
				
				/*
				$han = fopen("trace.txt", "w");
				fwrite($han, $androidMerchantJson);
				fclose($han);
				//*/
				
				return $androidMerchantJson;
				
				
			}elseif($requestType == "IDList"){
				
				$transactionIDList = "";
				while($row = $result->fetch_assoc()){
					$transactionIDList .= $row['bTransactionID']."#";
				}
				$transactionIDList = substr($transactionIDList, 0, -1);
				
				return $transactionIDList;
			}
		
		}
		
		Function MakePayment($transactionID, $otp){
			/*
				This function is used when customer is approving payment.
				
			*/
			
			include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
			
			//include $_SERVER['DOCUMENT_ROOT'].'/cimb.com.my/merchants/webServicesServerFunctions.php'; //Needed when updating payment security details.
			//include $_SERVER['DOCUMENT_ROOT'].'/cimb.com.my/merchants/webServicesClientFunctions.php'; //Needed when updating payment at the merchant server.
			require_once $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/merchants/generalFunctions.php"; //Required to be able to execute RequestCloseTransaction function which updates merchant that payment has been made.
			
			$response ="";
			
			$customerAccountID = "";
			$customerAccBal = 0;
			
			$merchantAccountID = "";
			$merchantAccBal = 0;
			$transactionOtp = "";
			
			$mTransactionID = 0;
			$transactionTotalAmount = 0;
			
			//Validate transactionID and also get accountIDs of customer and merchant.
			$sql = "SELECT * FROM tblTransactions WHERE bTransactionID = $transactionID";
			
			//print($sql);
			
			$mysqli = connection();
			$result = $mysqli->query($sql);
			
			if($result->num_rows > 0){
				
				while($row = $result->fetch_assoc()){
				
					$mTransactionID = $row['mTransactionID'];
					$merchantAccountID = $row['merchantAccountID'];
					$customerAccountID = $row['customerAccountID'];
					$transactionOtp = $row['transactionOtp'];
					$transactionTotalAmount = $row['transactionTotalAmount'];
				}
				
				
				//Validate transactionOtp .
				if(password_verify($otp, $transactionOtp)){
				
					//Valid OTP from Customer.
					
					//Validate Account Existence and then Check Customer Account Balance.
					$sql = "SELECT * FROM tblAccounts WHERE accountID = $customerAccountID";
				
					$mysqli = connection();
					$result = $mysqli->query($sql);
					
					if($result->num_rows > 0){
					
						//Account Exist
					
						while($row = $result->fetch_assoc()){
						
							$customerAccBal = $row['accountBalance'];
						}
					
						//Validate that customer account balance is enough to pay for transaction.
						
						if($transactionTotalAmount < $customerAccBal){
						
							//Customer Account Balance is enough to make payment.
						
							/*
								We Validate Existence of Merchant Customer Account by Crediting the Account.
								If we successfully updated, it means the account exist. otherwise not.
							*/
							
							//Get Merchant Account Balance
							$sql = "SELECT * FROM tblAccounts WHERE accountID = $merchantAccountID";
				
							$mysqli = connection();
							$result = $mysqli->query($sql);
							
							if($result->num_rows > 0){
							
								//Merchant Account Exist
								while($row = $result->fetch_assoc()){
								
									$merchantAccBal = $row['accountBalance'];
								}
								
								//Add Merchant Account Balance to transactionTotalAmount
								
								$accountBal = $merchantAccBal + $transactionTotalAmount;
								
								
								//Update Merchant Account Balance
								$sql = "UPDATE tblAccounts SET accountBalance = $accountBal WHERE accountID = $merchantAccountID";
							
								$mysqli = connection();
								$result = $mysqli->query($sql);
								
								
								//Debit Customer Account and Update the Account
								
								$accountBal = $customerAccBal - $transactionTotalAmount;
								
								
								//Update Customer Account Balance
								$sql = "UPDATE tblAccounts SET accountBalance = $accountBal WHERE accountID = $customerAccountID";
							
								$mysqli = connection();
								$result = $mysqli->query($sql);
								
								//Close transaction in tblTransactions
								$transDate = date("Y-m-d H:i:s");
								$sql = "UPDATE tblTransactions SET transactionClosed = 'YES', transactionCloseDate = '$transDate' WHERE bTransactionID = $transactionID";
								
								//print($sql);
								
								
								$mysqli = connection();
								$result = $mysqli->query($sql);
								
								//Notify Merchant of payment through RequestClosedTransactions
								$receivedResponse = RequestClosedTransactions($transactionID, $mTransactionID);
								
								if($receivedResponse == "1"){
									//Successfully updated Merchant transaction record
									//if need be, notify customer
									$response = "1";
									
								}
							}else{
								//Merchant Account Doest not exist
								
								$response = "5";
							}
						}else{
						
							//Insufficient Customer Account Balance for payment.
							
							$response = "3";
						}
					}else{
					
						//Account Do Not Exist
						$response = "4";
					}
					
					
				}else{
					/*
						OTP Do not match. 
						We recreate the OTP By calling the: 
						SetUpdateTrnsactionSecurity($transactionID, $bTransactionID)
						function of the webServicesServerFunctions.php
					*/
					
					SetUpdateTrnsactionSecurity($mTransactionID, $transactionID, $customerAccountID, $merchantAccountID);
					$response = "2";
					
				}
				
			}else{
				$response = "0"; //No Such transactionID
			}
			
			//print("Here is ".$response ." <br />");
			return $response;
		}
			
	
	//print(MakePayment(12,"sBGb0a"));
	//print(GetMerchantUrl(2));
?>