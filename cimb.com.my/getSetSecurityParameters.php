<?php

	include 'captchaAlgorithm.php';
	include 'stegoAlgorithm.php';
	include 'otpekGeneration.php';
	include 'encryptDecrypt.php';
	
	Function GetSetSecurityParameters($transactionID){
		
		//where $transactionID is the combined transaction ID of the merchant and the transaction ID of the bank
		
		/*
		$han = fopen("trace.txt", "a+");
		
		fwrite($han, "Beg: ");
		fwrite($han, "Beg: ");
		fclose($han);
		*/
		$otpekDetails = OtpekGeneration();
		$otpekGenArray = explode("#",$otpekDetails );
		//print("otpekDetails: ".$otpekDetails ."<br />");
		$otp = $otpekGenArray[0];
		$otpek = $otpekGenArray[1];
		/*
		$han = fopen("trace.txt", "w");
		
		fwrite($han, "OTP: ". $otp);
		fwrite($han, "OTPEK: ". $otpek);
		fclose($han);
		*/
		$captchaText = substr($otpek, 0,8);
		
		$fileName = $transactionID;
		if(CaptchaAlgorithm($captchaText, $fileName)){
			
			//Captcha successfully created
			
			//Encrypt otp with Otpek
			$enc = new MCrypt();
			
			//encrypt otp with otpek as key and attach three characters of the key for steganography.
			$otpekGen = $enc->encrypt($otp, $otpek) . substr($otpek, 8,3); 
			//fwrite($han, "OTPEKGEN: ". $otpekGen);
			
			if(WriteBits($fileName.".png", $otpekGen, $fileName)){
			
				//Info successfully embedded and shares created.
				
				
				return $otpekDetails;
			}else{
			
				//$otpekDetails = "";
				return $otpekDetails;
			}
			
		}else{
		
			//print("Error: ".$fileName);
			return "Captcha Write Error";
		}
	
	}
	//GetSetSecurityParameters("trans39");
?>