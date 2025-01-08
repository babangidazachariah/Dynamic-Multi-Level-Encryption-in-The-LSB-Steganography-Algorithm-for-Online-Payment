<?php
	//https://www.sitepoint.com/web-services-with-php-and-soap-1/  FOR TUTORIALS
	require_once(__DIR__ .'/../nusoapInclude.php');
	
	//I formerly comment this include, but the GetPurchased Function didn't work as it
	//require it to be able to execute sql queries. I also change it from 'include' to 'require_once'
	require_once(__DIR__ .'/../connection.php');
	
	Function GetPurchasedItems($transactionID){
		//SERVER FUNCTION
		/*
		We assume that $transactionID would always be valid.
		Using Transaction ID, we query the transaction and retrieve items with their unit 
		prices and return back to the caller
		
		*/
		$output ="";
		if((!empty($transactionID))){
	
			if(is_numeric($transactionID)){
				///*
				$sql = "SELECT tblItems.itemName, tblItems.itemUnitPrice, tblPurchasedItems.quantity FROM tblItems, tblPurchasedItems
						WHERE tblItems.itemCode = tblPurchasedItems.itemCode AND tblPurchasedItems.transactionID =".$transactionID;
					
					$mysqli = connection();
					$result = $mysqli->query($sql);
					
					if($result->num_rows > 0){
						while($row = $result->fetch_assoc()){
						//There are items with such transactio ID.
						
						
							$output .= $row['itemName'] ." @ ". $row['quantity']." @ ". ( $row['quantity'] * $row['itemUnitPrice'])." ## ";
						}
						
						
					}
				//*/
				//$output = "Nokia N90$2$500##Sony Experia$1$1000##Samsung A5$30$45000";	
			
			}else{
				$output = "2";//"Invalid Transaction ID!!!";
			}
			
			
		}else{
			$output ="3";// "Nothin To Print";
		}
		return $output;
	
	}
	
	Function CloseTransaction($bTransactionID, $mTransactionID){
		//This function updates the Merchant Table that payment has been made
		//By client in the client Bank.
		
		$dir = $_SERVER['DOCUMENT_ROOT'].'/lazada.com.my/cimb/TransactionCaptchas';
		$output ="";
		if(!empty($mTransactionID)){
		
			
			$dat = Date('d-m-y');
			$sql = "UPDATE tblTransactions SET transactionClosed = 'YES', transactionCloseDate ='$dat' WHERE transactionID = $mTransactionID";
			$mysqli = connection();
		
			$result = $mysqli->query($sql);
		
			
			$dir .= "/trans".$mTransactionID.$bTransactionID."ShareTwo.png";
			/*
			$han = fopen("trace.txt", "w");
			fwrite($han, $dir);
			fclose($han);
			//*/
			$output = "1"; //if success, 1 is printed.
			unlink($dir);
			
		}else{
		
			$output = "2";//"Invalid Transaction ID!!!";
		}
		
		return $output;
	}
	
	
	Function ReceiveMerchantShare($image, $fileName){
	
		/*
			This Function receives and stores the merchant share of the stego image file
		*/
		
		$dir = $_SERVER['DOCUMENT_ROOT'].'/lazada.com.my/cimb/TransactionCaptchas';
		
		
		try{
			$image = imagecreatefromstring(base64_decode($image));
			imagepng($image, $dir ."/". $fileName);
			
			return "1"; //Success
		}catch(Exception $e){
		
			return "0"; //Failure
		}
	}
	
	function Cancellation($transactionID){
	
		$sql = "DELETE FROM tblTransactions WHERE transactionID = $transactionID";
		$mysqli = connection();
	
		$result = $mysqli->query($sql);
		return true;
		
	}
	///*
	$server = new soap_server();
	$server->register("GetPurchasedItems");
	$server->register("CloseTransaction");
	$server->register("ReceiveMerchantShare");
	$server->register("Cancellation");
	 
	//$server->service($HTTP_RAW_POST_DATA);
	
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);
	//*/
	//print(CloseTransaction("39"));
?>	