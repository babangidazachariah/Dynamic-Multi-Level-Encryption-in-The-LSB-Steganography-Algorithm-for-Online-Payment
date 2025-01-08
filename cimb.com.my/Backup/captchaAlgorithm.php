<?php 
	
	Function CaptchaAlgorithm($outputChars, $fileName){
	
		$dir = $_SERVER['DOCUMENT_ROOT'].'cimb.com.my/merchants/TransactionCaptchas';
		
		include "dejavu-fonts-ttf-2.35/ttf/DejaVuSerif-Bold.ttf";
		include "dejavu-fonts-ttf-2.35/ttf/DejaVuSans-Bold.ttf";
		include "dejavu-fonts-ttf-2.35/ttf/DejaVuSansMono-Bold.ttf";
		
		/*
		$han = fopen("trace.txt", "a+");
				
		fwrite($han, "FILE NAME: ". $dir ."/". $fileName . ".png");
		fwrite($han, "Captcha Text: ". $outputChars);
		fclose($han);
		*/
		try{
			$height = 60; 
			$width = 230; 
			 
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

			//$font_size = 14; 
				// using a mixture of TTF fonts
			  $fonts = array();
			  $fonts[] = "dejavu-fonts-ttf-2.35/ttf/DejaVuSerif-Bold.ttf";
			  $fonts[] = "dejavu-fonts-ttf-2.35/ttf/DejaVuSans-Bold.ttf";
			  $fonts[] = "dejavu-fonts-ttf-2.35/ttf/DejaVuSansMono-Bold.ttf";
			  
			  
			//imagestring($image_p, $font_size, 5, 5, $text, $white); 
			 // add random String to canvas using random black/white colour
			 
			  
			  $textRandomColor = array("0x44", "0xAB", "0xCA","0x55", "0xBA", "0x6A","0x67", "0xAB", "0xFF","0xFA", "0xAB", "0xCD");
			 
			 $x = 10;
			 for($i = 0; $i < strlen($outputChars); $i++) {
				
				//int imagecolorallocate ( resource $image , int $red , int $green , int $blue )
				$textcolor = imagecolorallocate($image_p, $textRandomColor[rand(0,11)], $textRandomColor[rand(0,11)], $textRandomColor[rand(0,11)]);
				
				
				//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
				 imagettftext($image_p, 20, rand(-30,30), $x, rand(20, 42), $textcolor, $fonts[array_rand($fonts)], $outputChars[$i]);
				 
				 $x += 25;
			  }

			  //Save the captcha
			   //resource imagecreatetruecolor ( int $width , int $height )
			   
				//header('Content-type: image/png');
				imagepng($image_p, $dir ."/". $fileName . ".png");
				
				
				imagedestroy($image_p); 
				
				return true;
		}Catch(Exception $e){
		
			return false;
		}
	}
	
	//CaptchaAlgorithm("TestComp", "test");
?>