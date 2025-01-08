<?php
	//https://www.sitepoint.com/web-services-with-php-and-soap-1/  FOR TUTORIALS
	require_once "../nusoap-0.9.5/lib/nusoap.php";
	require_once '../connection.php';
	
	Function GetPurchasedItems($transactionID){
	
		/*
		We assume that $transactionID would always be valid.
		Using Transaction ID, we query the transaction and retrieve items with their unit 
		prices and return back to the caller
		
		*/
		$output ="";
		if((!empty($transactionID))){
	
			if(is_numeric($transactionID)){
				/*
				$sql = "SELECT tblItems.itemName,tblPurchasedItems.quantity, tblItems.itemUnitPrice FROM tblItems, tblPurchasedItems
						WHERE tblItems.itemCode = tblPurchasedItems.itemCode AND tblPurchasedItems.transactionID =".$transactionID;
					
					$mysqli = connection();
					$result = $mysqli->query($sql);
					
					if($result->num_rows > 0){
						//There are items with such transactio ID.
						
						while($row = $result->fetch_assoc()){
						
							$output .= $row['itemName'] ."$".row['quantity']."$". $row['itemPrice']."##";
						}
						
						
					}
				*/
				$output = "Nokia N90$2$500##Sony Experia$1$1000##Samsung A5$30$45000";	
			
			}else{
				$output ="Invalid Transaction ID!!!";
			}
			
			
		}else{
			$output = "Nothin To Print";
		}
		return $output;
	
	}
	
	$server = new soap_server();
	$server->register("GetPurchasedItems");
	//$server->service($HTTP_RAW_POST_DATA);
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);

	
?>	