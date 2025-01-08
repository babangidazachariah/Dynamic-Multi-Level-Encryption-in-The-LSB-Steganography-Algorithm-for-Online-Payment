<?php
		$qty = 0;
		
		/*
		print("<h1>test.php</h1><br />");
		print("Connected <br />Calling Connection.php..<br />");
		require_once 'connection.php';
		print("Connection.php.. Called and Connected <br />Calling cimb/test.php..<br />");
		require_once 'cimb/test.php';
		
		print("cimb/test.php.. Called, Connected, and completed <br />");
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
			$outputChars ="Captcha";
			imagestring($image_p, 5, 10, 10, $outputChars, $textcolor);
			

			  //Save the captcha
			   //resource imagecreatetruecolor ( int $width , int $height )
			   $dir = $_SERVER['DOCUMENT_ROOT'].'/lazada.com.my/cimb/TransactionCaptchas';
				header('Content-type: image/png');
				imagepng($image_p,  $dir."/imageTest.png");
				
				
				imagedestroy($image_p); 
				
				header('Content-type: text/html');
				print("Done");
		}Catch(Exception $e){
			header('Content-type: text/html');
			print("Error: ". $e->getMessage());
		}
		/*
		$string ="TPUBC99999##OSGC978484##IPTC898547##TPUBC99999##IPTC898547##IPTC898547##TPUBC99999";
				$itemsiInCart = explode("##",$string);
				$grpItems =array_count_values($itemsiInCart);
				$grpItem = array_unique($itemsiInCart);
				var_dump($grpItems);
				var_dump($grpItem);
				$transactionID = 25;
				foreach($grpItem as $item){
				
					$qty = $grpItems[$item];
				
										
					$sql = "INSERT INTO tblPurchasedItems (
													transactionID,
													itemCode,
													quantity
													)
												VALUES (
													".$transactionID .", '"
													.$item ."', ".
													$qty.")";
													
					print($sql."<br />");
					
					$mysqli = connection();
					
					$result = $mysqli->query($sql) or die($mysqli->error);
				
				}
				//*/
?>