<?php 
	require_once 'notificationFunctions.php';
	
	if($_GET['funcName'] == "RegisterDevice"){
		
		Print(RegisterDevice($_GET['params']));
	}elseif($_GET['funcName'] == "RegisterUser"){
		
		Print(RegisterUser($_GET['username'],$_GET['password'] ));
	}elseif($_GET['funcName'] == "Login"){
		
		Print(Login($_GET['username'],$_GET['password'] ));
	}
?>