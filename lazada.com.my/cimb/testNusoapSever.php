<?php
require_once "../nusoap-0.9.5/lib/nusoap.php";

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

	function getName(){
		return "Babangida Zachariah";
	}

	function GetPurchasedItems($transactionID){
	
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
				$output = "Nokia N90$2$ RM500##Sony Experia$1$ RM1000##Samsung A5$30$ RM45000";	
			    //$output ="Babangida";
			}else{
				$output ="Invalid Transaction ID!!!";
			}
			
			
		}else{
			$output = "Nothin To Print";
		}
		return $output;
	
	}
$server = new soap_server();
$server->register("getProd");
$server->register("getName");
$server->register("GetPurchasedItems");
$server->service($HTTP_RAW_POST_DATA);



?>