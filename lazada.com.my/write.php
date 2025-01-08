<?php

	//require_once 'connection.php';
	//$mysqli = connection();
	print("<h1>write.php</h1><br />");
	print("write.php.. executing <br /> Returning to cimb/test.php..");
	/*
	$sql = "INSERT INTO tblAccounts (accountType,
											accountNumber,
											accountName,
											accountAddress,
											accountBalance)
									VALUES( ?,
											?,
											?,
											?,
											?)";
	
	$result = $mysqli->prepare($sql);
    $result->bindValue(1, 'Savings');
    $result->bindValue(2, '000000001001');
    $result->bindValue(3, 'Shekolo Diza');
	$result->bindValue(4, 'Kaduna');
	$result->bindValue(5, 20000);
    $result->execute();
	//*/
	
	/*
	//$result = $mysqli->query($sql);
	$tempCardNum = mt_rand((int)100000000,(int) 999999999);
				$tempCardNum = $tempCardNum . mt_rand((int)00000, (int)99999);
	print($tempCardNum);
	$ty = "0987654321";
	$sql = "SELECT * FROM tblItems";
	
	$result = $mysqli->query($sql);
	
	$results = $result->fetchAll(); 
	if(count($results) > 0) {
		echo "<h2>People who are registered:</h2>";
		echo "<table>";
		echo "<tr><th>Name</th>";
		echo "<th>Email</th>";
		echo "<th>Date</th></tr>";
		foreach($results as $account) {
			echo "<tr><td>".$account['itemName']."</td>";
			echo "<td>".$account['itemCode']."</td>";
			echo "<td>".$account['itemPicture']."</td></tr>";
		}
		echo "</table>";
	} else {
		echo "<h3>No one is currently registered.</h3>";
	}
	//*/
?>