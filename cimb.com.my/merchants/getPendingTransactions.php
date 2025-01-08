<?php
			
			if(!empty($_GET['registeredDevice'])){
				//Rewrite the Json content
				$registeredDevice = $_GET['registeredDevice'];
				$androidMerchantJson = "[";
				include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
				
				$mysqli = connection();
				$sql = "";
				if($_GET['agent'] == "Pending"){
				
					$sql = "SELECT tblTransactions.bTransactionID,tblTransactions.transactionDate, tblTransactions.transactionTotalAmount,
							tblMerchantInfo.merchantName, tblMerchantInfo.merchantUrl, tblMerchantInfo.merchantLogo   
							FROM tblTransactions, tblMerchantInfo, tblRegisteredClients 
							WHERE tblTransactions.customerAccountID = tblRegisteredClients.registeredAccountID 
								AND tblTransactions.merchantAccountID = tblMerchantInfo.merchantAccountID
								AND tblTransactions.transactionClosed = 'No' 
								AND tblRegisteredClients.registeredDeviceID ='". $registeredDevice."' 
							ORDER BY tblTransactions.transactionDate";
				}elseif($_GET['agent'] == "Pending"){
					
					$sql = "SELECT tblTransactions.bTransactionID,tblTransactions.transactionDate, tblTransactions.transactionTotalAmount,
							tblMerchantInfo.merchantName, tblMerchantInfo.merchantUrl, tblMerchantInfo.merchantLogo   
							FROM tblTransactions, tblMerchantInfo, tblRegisteredClients 
							WHERE tblTransactions.customerAccountID = tblRegisteredClients.registeredAccountID 
								AND tblTransactions.merchantAccountID = tblMerchantInfo.merchantAccountID
								AND tblTransactions.transactionClosed = 'Yes' 
								AND tblRegisteredClients.registeredDeviceID ='". $registeredDevice."' 
							ORDER BY tblTransactions.transactionDate";
				}
				$result = $mysqli->query($sql);
				
				//var_dump($result);
				if($_GET['request'] == "JSON"){
					while($row = $result->fetch_assoc()){
				
					//print('Here');
						$androidMerchantJson .='	
	{			
		"title":"'.$row['merchantName'].'",
		"image":"http://104.199.190.90/cimb.com.my/merchants/logo/'.$row['merchantLogo'].'",
		"rating":"'.$row['transactionTotalAmount'].'",
		"releaseYear": "'.$row['transactionDate'].'",
		"genre":["'.$row['merchantUrl'].'"]
	},';

					}
				
				
				
					$androidMerchantJson = substr($androidMerchantJson,0,-1);
					$androidMerchantJson .= "]";
					
					print($androidMerchantJson );
					
					
				}elseif($_GET['request'] == "IDList"){
					
					$transactionIDList = "";
					while($row = $result->fetch_assoc()){
						$transactionIDList .= $row['bTransactionID']."#";
					}
					$transactionIDList = substr($transactionIDList, 0, -1);
					
					print($transactionIDList);
				}
			}//end of if(!empty($_GET['registeredDevice']))
				
?>