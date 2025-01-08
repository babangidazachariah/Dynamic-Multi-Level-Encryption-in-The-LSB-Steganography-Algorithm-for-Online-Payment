<?php 

	$db = mysql_connect("localhost","root") or die ('Unable to connect. Check your connection parameters or '.mysql_error($db));
		$sql= "CREATE DATABASE IF NOT EXISTS Lazada";
		mysql_query($sql, $db) or die(mysql_error($db));
		//make sure our recently created database is the active one
		mysql_select_db('Lazada', $db) or die(mysql_error($db));
		
		$sql = "CREATE TABLE IF NOT EXISTS tblTransactions (transactionID INTEGER NOT NULL AUTO_INCREMENT,
															
															transactionDate VARCHAR(16) NOT NULL,
															transactionCustomerAccountID INTEGER NOT NULL,
															transactionClosed VARCHAR(1) NOT NULL,
															transactionCloseDate VARCHAR(16),
															PRIMARY KEY (transactionID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));
		
		
		$sql = "CREATE TABLE IF NOT EXISTS tblCustomerAccounts (customerID INTEGER NOT NULL AUTO_INCREMENT,
															customerAccountID VARCHAR(20) NOT NULL,
															customerBank VARCHAR(30) NOT NULL,															
															
															PRIMARY KEY (customerID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));												
											
		//forum topics
		$sql = "CREATE TABLE IF NOT EXISTS tblRegisteredCustomers (registredID INTEGER NOT NULL AUTO_INCREMENT,
															registeredEmail VARCHAR(20) NOT NULL,
															registeredName VARCHAR(60) NOT NULL,
															registeredDob VARCHAR(20) NOT NULL,
															registeredGender VARCHAR(8) NOT NULL,
															registeredLanguage VARCHAR(10) NOT NULL,
															registeredBank VARCHAR(20) NOT NULL,
															registeredAccountNumber VARCHAR(20) NOT NULL,
															registerePassword VARCHAR(150) NOT NULL,
															PRIMARY KEY (registredID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));
		
		//forum
		$sql = "CREATE TABLE IF NOT EXISTS tblItems (itemID INTEGER NOT NULL AUTO_INCREMENT,
															itemCode VARCHAR(10) NOT NULL,
															itemName VARCHAR(60) NOT NULL,
															itemDescription VARCHAR(100) NOT NULL,
															itemPicture VARCHAR(15) NOT NULL,
															itemUnitPrice DOUBLE NOT NULL,
															PRIMARY KEY (itemID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));
		
		//article
		$sql = "CREATE TABLE IF NOT EXISTS tblPurchasedItems(purchasedItemID INTEGER NOT NULL AUTO_INCREMENT,
															
															transactionID INTEGER NOT NULL,
															itemCode VARCHAR(10) NOT NULL,
															quantity INTEGER NOT NULL,
															PRIMARY KEY (purchasedItemID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));
		
		
		
											
?>