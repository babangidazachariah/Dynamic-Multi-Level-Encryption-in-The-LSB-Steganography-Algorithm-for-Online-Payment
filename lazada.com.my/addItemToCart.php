<?php
SESSION_START();
	if((!empty($_GET['item'])) && ($_GET['item'] !="Submit")){
	
		require_once 'connection.php';
		$iteName ="";
		$query = "SELECT * FROM tblItems WHERE itemCode='".$_GET['item']."'";
		$mysqli = connection();
		$result = $mysqli->query($query);
		
		
		while($row = $result->fetch_assoc()){
		
			$itemName = $row['itemName'];
		}
	
		if(!(empty($itemName))){
			if(!(empty($_SESSION['cart']))){
				$_SESSION['cart'] .= "##". $_GET['item'];
			}else{
				$_SESSION['cart'] = $_GET['item'];
			}
			print($itemName);
		}
	}else{
	
		//redirect
		$_SESSION['submit'] = true;
		
	}
?>