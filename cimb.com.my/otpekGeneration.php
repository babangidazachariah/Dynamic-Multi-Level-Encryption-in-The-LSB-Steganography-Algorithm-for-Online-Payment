<?php 
	Function OtpekGeneration(){
		 $stringText ="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

		 // add random String to canvas using random black/white colour
		 
		  $characters = str_shuffle($stringText);
		  
		 $otp = substr($characters,0,6); // change the number to change number of chars
		 
		 
		 $characters = str_shuffle($stringText);
		  
		 $otpek = substr($characters,0,16); // change the number to change number of chars
		 
		 $otpek = $otp ."#". $otpek;
		 
		 //print($otpek);
		return  $otpek;
	}
	
	//print (OtpekGeneration());
?>