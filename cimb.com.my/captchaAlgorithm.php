<?php 
	
	Function CaptchaAlgorithm($outputChars, $fileName){
	
		$dir = $_SERVER['DOCUMENT_ROOT'].'/cimb.com.my/merchants/TransactionCaptchas';
		/*
		include "dejavu-fonts-ttf-2.35/ttf/DejaVuSerif-Bold.ttf";
		include "dejavu-fonts-ttf-2.35/ttf/DejaVuSans-Bold.ttf";
		include "dejavu-fonts-ttf-2.35/ttf/DejaVuSansMono-Bold.ttf";
		
		
		$han = fopen("trace.txt", "a+");
				
		fwrite($han, "FILE NAME: ". $dir ."/". $fileName . ".png");
		fwrite($han, "Captcha Text: ". $outputChars);
		fclose($han);
		*/
		try{
			$height = 30; 
			$width = 100; 
			 
			$image_p = imagecreatetruecolor($width, $height); 

			  // set background and allocate drawing colours
			  $background = imagecolorallocate($image_p, 0x66, 0x99, 0x66);
			  imagefill($image_p, 0, 0, $background);
			  $linecolor = imagecolorallocate($image_p, 0x99, 0xCC, 0x99);

			  
			  // draw random lines on canvas
			  for($i=0; $i < 15; $i++) {
				imagesetthickness($image_p, rand(1,3));
				imageline($image_p, 0, rand(0, $height), $width, rand(0,$height) , $linecolor);
			  }
			  
			$white = imagecolorallocate($image_p, 255, 255, 255); 

			 $textcolor = imagecolorallocate($image_p, 0, 0, 255);
			

			//$textcolor = imagecolorallocate($image_p, $textRandomColor[rand(0,11)], $textRandomColor[rand(0,11)], $textRandomColor[rand(0,11)]);
			// Write the string at the top left
			
			imagestring($image_p, 5, 10, 10, $outputChars, $textcolor);
			

			  //Save the captcha
			   //resource imagecreatetruecolor ( int $width , int $height )
			   
				header('Content-type: image/png');
				imagepng($image_p, $dir ."/". $fileName . ".png");
				
				
				imagedestroy($image_p); 
				
				header('Content-type: text/html');
				print("Here".$dir ."/". $fileName . ".png </br />");
				return true;
		}Catch(Exception $e){
		
			return false;
		}
	}
	
	print(CaptchaAlgorithm("Testing","testing"));
	/*
	
		include 'stegoAlgorithm.php';
		include 'otpekGeneration.php';
		include 'encryptDecrypt.php';
		$otpekDetails = OtpekGeneration();
		$otpekGenArray = explode("#",$otpekDetails );
		//print("otpekDetails: ".$otpekDetails ."<br />");
		$otp = $otpekGenArray[0];
		$otpek = $otpekGenArray[1];
		
		
		$captchaText = substr($otpek, 0,8);
		
	
	
	
	$enc = new MCrypt();
	$otpekGen = $enc->encrypt($otp, $otpek) . $otpek; //encrypt otp and attach the key.
	
	
		$han = fopen("trace.txt", "w");
		
		fwrite($han, "OTP: ".$otp ."<br />");
		fwrite($han, "OTPEK: ".$otpek ."<br />");
		fwrite($han, "OTPEKGEN: ".$otpekGen ."<br />");
	
		fclose($han);
	CaptchaAlgorithm($captchaText, "test");
	WriteBits("test.png", $otpekGen, "test");
	//*/
?>