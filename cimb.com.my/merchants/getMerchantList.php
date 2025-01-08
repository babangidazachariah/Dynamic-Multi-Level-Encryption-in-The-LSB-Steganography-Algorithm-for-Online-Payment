<?php	
	
	//http://www.androidhive.info/2012/02/android-custom-listview-with-image-and-text/
	
	/*
	
		Here Merchant list is generated for reference purpose in the mobileApp, GoBaMer
	*/
		//Rewrite the xml content
		$androidMerchantListOrder = "";
		include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
		
		$mysqli = connection();
		$sql = "SELECT merchantID, merchantName FROM tblMerchantInfo ORDER BY merchantName";
		
		$result = $mysqli->query($sql);
		
		//var_dump($result);
		
		while($row = $result->fetch_assoc()){
		
			//At the android, we use the merchantID to callback to server for more details about the merchant.
			$androidMerchantListOrder .=$row['merchantID']."$".$row['merchantName']."#";

		}
		
		print($androidMerchantListOrder);
				
				
				
				
				
?>