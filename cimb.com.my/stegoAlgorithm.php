<?php

	define("MAX_INT_LEN",8); //Byte for representing message length
	define("MAX_DATA_SIZE", bindec(str_pad(1, MAX_INT_LEN,'1',STR_PAD_LEFT))); //define the maximum message lenth allowed based on MAX_INT_LEN
	
	
	/*
	if(!$image){
		print("Not Loaded Successfully!!!");
	}else{
		 for($y=0; $y< 30; $y++){
           for($x= 0; $x<50; $x++){
		   
				$rgb = imagecolorat($image,$x, $y);
				
				 print("R: " .intToBytes((($rgb >> 16) & 0xFF)) ."<br />");
				 print("G: " .intToBytes((($rgb >> 8) & 0xFF))."<br />");
				 print("B: " .intToBytes(($rgb & 0xFF))."<br />");

		   }
		}
	}
	*/
	Function WriteBits($image, $data, $fileOutput){
		
		
		
		if(strlen($data) < MAX_DATA_SIZE){
			$image = LoadImage($image);
			
			if(!$image){
				return false;
			}else{
				
				
				
				$dataBits = ToBinary("", strlen($data), 8) . ToBinary($data, -1, 8);
				
				$w = imagesx($image);
				$h = imagesy($image);
				$x = 0;
				$y = 0;
				$redComp = 0;
				$greenComp = 0;
				$blueComp = 0;
				
				$j = strlen($dataBits);
				$i = 0;
				
				//print($dataBits. "<br />");
				$setCol = false;
				while($y < $h){
					
					while($x < $w){
						
						$rgb = imagecolorat($image,$x, $y);
					
						if($i < $j){
							$redBits = ToBinary("",(($rgb >> 16) & 0xFF), 8) ;
							
							//print($redBits. " : ");
							$redBits = EmbedAtLocation($redBits, 8, $dataBits[$i]);
							//print($redBits. " <br /> ");
							$redComp = bindec($redBits);
							$i++;
						}else{
							$x = $w;
							$y = $h;
						}
						if($i < $j){
							$greenBits = ToBinary("",(($rgb >> 8) & 0xFF), 8);
							
							//print($greenBits ." : ");
							$greenBits = EmbedAtLocation($greenBits, 8, $dataBits[$i]);
							
							//print($greenBits ." <br />");
							$greenComp = bindec($greenBits);
							$i++;
						}else{
							$x = $w;
							$y = $h;
						}
						
						if($i < $j){
							$blueBits = ToBinary("",($rgb & 0xFF), 8);
							
							//print($blueBits. " : ");
							$blueBits = EmbedAtLocation($blueBits, 8, $dataBits[$i]);
							
							//print($blueBits. " <br /> ");
							$blueComp = bindec($blueBits);
							$i++;
						}else{
							$x = $w;
							$y = $h;
						}
						//set back the modified Color
						imagesetpixel($image,$x,$y, SetColor($image,$redComp,$greenComp,$blueComp));
						$x++;
					}
					$y++;
				}
				return writeImageToFile($fileOutput, $image);
			}
		}else{
		
			return false;
		}
	}
	
	Function ReadLengthBits($im){
	
		$bits = "";
		$bitLen = (MAX_INT_LEN);
		
		$w = imagesx($im);
		$h = imagesy($im);
		for ($y = 0; $y < $h; $y++){
			for($x = 0; $x < $w; $x++){
				$rgb = imagecolorat($im,$x, $y);
				
				if(strlen($bits) <= $bitLen){
					$redBits = ToBinary("",(($rgb >> 16) & 0xFF), 8) ;
					
					$bits .= $redBits[7];
					
				}else{
					$x = $w;
					$y = $h;
				}
				if(strlen($bits) <= $bitLen){
					$greenBits = ToBinary("",(($rgb >> 8) & 0xFF), 8);
					
					$bits .= $greenBits[7];
				}else{
					$x = $w;
					$y = $h;
				}
				
				if(strlen($bits) <= $bitLen){
					$blueBits = ToBinary("",($rgb & 0xFF), 8);
					
					$bits .= $blueBits[7];
				}else{
					$x = $w;
					$y = $h;
				}
			
			}
		}
		//print("Bits:-".$bits.": ".bindec($bits)."<br />");
		return bindec(substr($bits, 0, 8));
	}
	
	Function ReadBits($im, $bitLen){
		$bits = "";
		$w = imagesx($im);
		$h = imagesy ($im);
		$bitLen = (($bitLen*8) + MAX_INT_LEN);
		for($y = 0; $y < $h; $y++){
		 
			for($x = 0; $x < $w; $x++){
			
			
				$rgb = imagecolorat($im,$x, $y);
				
				if(strlen($bits) <= $bitLen){
					$redBits = ToBinary("",(($rgb >> 16) & 0xFF), 8) ;
					
					$bits .= $redBits[7];
					
				}else{
					$x = $w;
					$y = $h;
				}
				if(strlen($bits) <= $bitLen){
					$greenBits = ToBinary("",(($rgb >> 8) & 0xFF), 8);
					
					$bits .= $greenBits[7];
				}else{
					$x = $w;
					$y = $h;
				}
				
				if(strlen($bits) <= $bitLen){
					$blueBits = ToBinary("",($rgb & 0xFF), 8);
					
					$bits .= $blueBits[7];
				}else{
					$x = $w;
					$y = $h;
				}
			
			}
		}
		$bits = substr($bits, MAX_INT_LEN);
		//print($bits."<br />");
		return $bits;
	}
	
	Function ToBinary($text, $intVal, $bits){
	
	
		$result = "";
		$tempStr = "";
		$tempInt = 0;
		
		$textLen = strlen($text); 
		if(($textLen > 0) && ($intVal < 0)){
		
			for($i = 0; $i < $textLen; $i++){
			
			
				$result .= str_pad(decbin(ord($text[$i])),8,'0',STR_PAD_LEFT);	
			
			}
		}else{
		
			try{
				$result = str_pad(decbin($intVal),8,'0',STR_PAD_LEFT);	
			}catch(Exception $e){
			
				return false;
			
			}
		}
		
		return $result;
	}
	
	Function BitsToText($bits){
	
		$text = "";
		$j = strlen($bits);
		$i = 0;
		
		if($j >= MAX_INT_LEN){
			
			while(($i + 8) <= $j){
				//print(bindec(substr($bits,$i,8)));
				$text .= chr(bindec(substr($bits,$i,8)));
				$i += 8;
			}
		}
		return $text;
	}
	Function writeImageToFile($fileName, $im){
	
		include $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/merchants/SendMerchantShare.php"; //Required to execute SendMerchantShare function.
		
		$dir = $_SERVER['DOCUMENT_ROOT'].'/cimb.com.my/merchants/TransactionCaptchas';
		
		try{
		
			$width = imagesx($im);
			$height = imagesy($im);
			//Divide Picture into two
		    //resource imagecreatetruecolor ( int $width , int $height )
		    $shareOne = imagecreatetruecolor($width/2, $height);
		    $shareTwo = imagecreatetruecolor($width/2, $height);
		   
		    imagecopy($shareOne, $im, 0,0,0,0, $width, $height);
		    imagecopy($shareTwo, $im, 0,0,$width/2, 0, $width, $height);
			//copy image into directory	
			//header('Content-type: image/png');
			imagepng($shareOne, $dir ."/".$fileName. "ShareOne.png");
			
			
			//header('Content-type: image/png');
			imagepng($shareTwo, $dir ."/". $fileName  . "ShareTwo.png");
		
			imagepng($im, $dir ."/". $fileName  . ".png");
			
			
			///*
			
			//Send Merchant Share and delete the main Captcha image and shareTwo captcha image too.
			
			$image = base64_encode(file_get_contents($dir ."/". $fileName  . "ShareTwo.png"));
			
			//$fileName = $fileName  . "ShareTwo.png";
			
			SendMerchantShare($image, $fileName."ShareTwo.png");
			
			//Delete the Main and Merchant Share Captcha images
			unlink($dir ."/". $fileName  . "ShareTwo.png");
			unlink($dir ."/". $fileName  . ".png");
			
			
			
			
			//Free Resources
			imagedestroy($shareTwo);
			imagedestroy($shareOne);
			imagedestroy($im); 
			//*/
			return true;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}
	Function SetColor($img,$r,$g,$b){
	
		$c=imagecolorexact($img,$r,$g,$b); 
		if($c!=-1)return $c;
		
		$c=imagecolorallocate($img,$r,$g,$b); 
		if($c!=-1)return $c;
		
		return imagecolorclosest($img,$r,$g,$b);
	}
	Function intToBytes($int){
	
		//32-bits sequence representing stego message length
		return str_pad(decbin($int), 8,'0',STR_PAD_LEFT);	  
	
	}
	
	Function LoadImage($fileName){
		$dir = $_SERVER['DOCUMENT_ROOT'].'/cimb.com.my/merchants/TransactionCaptchas';
		$image = imagecreatefrompng($dir."/".$fileName);
		if(!$image){
			print("Not Loaded Successfully!!!");
		}else{
			return $image;
			
		}
	}
	
	Function EmbedAtLocation($bitSequence, $pos, $bit){
		
			/*
				This Function accepts and 8-bits sequence, a bit to be embedded at a certain
				position, pos.
				
				As bits are embedded at those locations, it also augment (Compensate) where 
				possible by switching the least significant bits so the value is close it its 
				real value before the embedding.
			*/
			 If( $pos == 6 ){
				//Embed at 6th bit location
				if($bitSequence[5] == "0" && $bit == "1"){
					
					$bitSequence = substr_replace($bitSequence, $bit, 5, 1);
					
					//'change to 0 to compensate reasonably the change in color.
					$bitSequence = substr_replace($bitSequence, "0", 6, 1);
					$bitSequence = substr_replace($bitSequence, "0", 7, 1);
					
					
				}elseif($bitSequence[5] == "1" && $bit == "0"){
				
					$bitSequence = substr_replace($bitSequence, $bit, 5, 1);
					
					//'change to 1 to compensate reasonably the change in color.
					$bitSequence = substr_replace($bitSequence, "1", 6, 1);
					$bitSequence = substr_replace($bitSequence, "1", 7, 1);
				}
			 }ElseIf ( $pos == 7 ){
				//Embed at 7th bit location
				if($bitSequence[6] == "0" && $bit == "1"){
					
					
					$bitSequence = substr_replace($bitSequence, $bit, 6, 1);
					
					//'change to 0 to compensate reasonably the change in color.
					$bitSequence = substr_replace($bitSequence, "0", 7, 1);
					
					
				}elseif($bitSequence[6] == "1" && $bit == "0"){
				
					$bitSequence = substr_replace($bitSequence, $bit, 6, 1);
					
					//'change to 1 to compensate reasonably the change in color.
					
					$bitSequence = substr_replace($bitSequence, "1", 7, 1);
				}
				
				
			}ElseIf ( $pos == 8 ){
				//'embed at 8th bit location
				//'Here, we embed at the last bit location. Thus no need for any compensation.
				$bitSequence = substr_replace($bitSequence, $bit, 7, 1);
			}
			return $bitSequence;
		}
		
	//*	
	//Test file - gets one file embeds and saves as another file.
	//$_SERVER['DOCUMENT_ROOT'].'/cimb.com.my/merchants/TransactionCaptchas';
	
	//WriteBits($im,"1234567890abBA0987654321","shareOne.png");
	
	//WriteBits("trans4048.png","Babangida Zachariah","trans4048");
	//$im = LoadImage("test.png");
	//print(BitsToText(ReadBits($im,  ReadLengthBits($im))));
	//print(BitsToText("0001001101000010011000010110001001100001011011100110011101101001011001000110000100100000010110100110000101100011011010000110000101110010011010010110000101101000"));
	//print(BitsToText("0011101101101101101101101101101101101010010010010010010010010010010010010010010010010010"));
	
	//print(ToBinary("e0b131b8e4486d84fca9cd787eed3c399tUS4PBCGf0iAV8", -01, 8));
	//*/
?>