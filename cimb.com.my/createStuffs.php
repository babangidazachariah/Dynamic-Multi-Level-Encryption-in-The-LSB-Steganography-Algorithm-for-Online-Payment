<?php 

	$db = mysql_connect("localhost","root") or die ('Unable to connect. Check your connection parameters or '.mysql_error($db));
		$sql= "CREATE DATABASE IF NOT EXISTS MobilePayment";
		mysql_query($sql, $db) or die(mysql_error($db));
		//make sure our recently created database is the active one
		mysql_select_db('MobilePayment', $db) or die(mysql_error($db));
		
		$sql = "CREATE TABLE IF NOT EXISTS tblTransactions (bTransactionID INTEGER NOT NULL AUTO_INCREMENT,
															mTransactionID INTEGER NOT NULL,
															customerAccountID INTEGER NOT NULL,
															merchantAccountID INTEGER NOT NULL,
															transactionOtp VARCHAR(6) NOT NULL,
															transactionCaptcha VARCHAR(8) NOT NULL,															
															transactionOtek VARCHAR(16) NOT NULL,
															transactionDate VARCHAR(16) NOT NULL,
															transactionTotalAmount DOUBLE NOT NULL,
															transactionClosed VARCHAR(4) NOT NULL,
															transactionCloseDate VARCHAR(16),
															PRIMARY KEY (bTransactionID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));
		
		
		$sql = "CREATE TABLE IF NOT EXISTS tblMerchants (merchantID INTEGER NOT NULL AUTO_INCREMENT,
															merchantAccountID INTEGER NOT NULL,
															merchantUrl VARCHAR(20) NOT NULL,															
															merchantTheme VARCHAR(50) NOT NULL,
															merchantLogo VARCHAR(50) NOT NULL,
															PRIMARY KEY (merchantID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));												
											
		//forum topics
		$sql = "CREATE TABLE IF NOT EXISTS tblRegisteredClients (registredID INTEGER NOT NULL AUTO_INCREMENT,
															registeredDeviceID VARCHAR(250) NOT NULL,
															registeredAccountID INTEGER NOT NULL,
															PRIMARY KEY (registredID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));
		
		//forum
		$sql = "CREATE TABLE IF NOT EXISTS tblAccounts (accountID INTEGER NOT NULL AUTO_INCREMENT,
															accountNumber VARCHAR(20) NOT NULL,
															accountName VARCHAR(60) NOT NULL,
															accountType VARCHAR(10) NOT NULL,
															accountAddress VARCHAR(70) NOT NULL,
															accountBalance DOUBLE NOT NULL,
															PRIMARY KEY (accountID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));
		
		//article
		$sql = "CREATE TABLE IF NOT EXISTS tblCards (cardID INTEGER NOT NULL AUTO_INCREMENT,
															
															cardType VARCHAR(10) NOT NULL,
															cardAccountID INTEGER NOT NULL,
															cardNumber VARCHAR(20) NOT NULL,
															
															cardExperyMonth VARCHAR(2) NOT NULL,
															cardExperyYear VARCHAR(2) NOT NULL,
															cardCVC VARCHAR(3) NOT NULL,
															cardPin VARCHAR(6) NOT NULL,
															PRIMARY KEY (cardID)
															)
															ENGINE=MyISAM";
															
		mysql_query($sql, $db) or die(mysql_error($db));
		
		
		
											
?>