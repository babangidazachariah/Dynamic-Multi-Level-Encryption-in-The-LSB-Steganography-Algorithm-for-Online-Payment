<?php
	/*/The best way to create this receipt, is to break codes into header, body, and footer functions
		That way, for every page of the receipt, we could just call the header code and footer code, and
		the body code as the case may be.
	*/
	//https://www.sitepoint.com/web-services-with-php-and-soap-1/  FOR TUTORIALS
	require_once(__DIR__ .'/../nusoapInclude.php');
	require_once '../connection.php';
	require_once 'getPurchasedItems.php';
	Function GenerateReciept($transactionID, $merchantUrl){
		$output ="";
		$width = 400;
		$height = 600;
		$receipt = null;
		try{
			$bankLogo = imagecreatefrompng("../images/cimblogo.png");
			$bankLogo = imagescale($bankLogo, 100, 50);
			
			$sql = "SELECT merchantLogo FROM tblMerchantInfo WHERE merchantUrl ='www.".trim($merchantUrl) ."'";
			
			$mysqli = connection();
			$result = $mysqli->query($sql);
			//print("Here");
			if($result->num_rows > 0){
				//There are items with such transactio ID.
				//print("Here");
				while($row = $result->fetch_assoc()){
				
					$output = $row['merchantLogo'];
				}
				
				$font =  "../dejavu-fonts-ttf-2.35/ttf/DejaVuSerif-Bold.ttf";
				
				$merchantLogo = imagecreatefrompng("logo/". $output);
				$merchantLogo = imagescale($merchantLogo, 100,50);
				
				$receipt = imagecreatetruecolor($width, $height);
				$color = imagecolorallocate($receipt,255, 230, 230);
				imagefill($receipt, 0, 0, $color);
				
				
				//Copy MERCHANT LOGO to receipt
				$cw = imagesx($merchantLogo);
				$ch = imagesy($merchantLogo);
				
				imagecopy($receipt, $merchantLogo, ($width - ($cw + 10)),  10, 0, 0, $cw, $ch);
				
				//Copy CIMB LOGO to receipt
				$cw = imagesx($bankLogo);
				$ch = imagesy($bankLogo);
				
				imagecopy($receipt, $bankLogo, 10,  10, 0, 0, $cw, $ch);
				
				//Create Stamp and copy
				$stamp = imagecreatetruecolor(100, 70);
				$color = imagecolorallocate($stamp, 77, 0, 31);
				imagefilledrectangle($stamp, 0, 0, 99, 69, $color);
				imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
				
				
				$textcolor = imagecolorallocate($receipt, 230, 230, 255);
				imagettftext($stamp, 20, 25, 20, 60, $textcolor, $font, "PAID");
				
				$textcolor = imagecolorallocate($receipt, 255, 102, 255);
				
				imagettftext($stamp, 10, 0, 5, 35, $textcolor, $font, "CIMB BANK");
				
				
				imagecopy($receipt, $stamp, 30,  ($height - 90), 0, 0, 100, 70);
				
				imagedestroy($stamp);
				$text = "Purchase Receipt";
				
				//int imagecolorallocate ( resource $image , int $red , int $green , int $blue )
				$textcolor = imagecolorallocate($receipt, 0, 0, 0);
				
				 $x = 20;
				 $ch += 50;
				 for($i = 0; $i < strlen($text); $i++) {
					
					
					$num = substr($text, $i, 1);
					
					//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
					 imagettftext($receipt, 30, 0, $x, $ch, $textcolor, $font, $num);
					 
					 $x += 23;
				}
				  
				 //Draw a horizontal line across the receipt
				 $linecolor = imagecolorallocate($receipt, 204, 153, 255);
				 imagesetthickness($receipt, 2);
				 
				 $ch += 20;
				//bool imageline ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
				imageline($receipt, 0, $ch, $width, $ch, $linecolor);
				
				
				//GET Client Account Name
				$sql = "SELECT tblAccounts.accountName, tblAccounts.accountNumber FROM tblAccounts WHERE 
					tblAccounts.accountID = tblTransactions.customerAccountID AND tblTransactions.mTransactionID =".$transactionID;
					
				$result = $mysqli->query($sql);
				$accountName = '';
				$accountNumber = '';
				/*
				if($result->num_rows > 0){
					//There are items with such transactio ID.
					
					while($row = $result->fetch_assoc()){
					
						$accountName = $row['accountName'];
						$accountNumber = $row['accountNumber'];
					}
				}
				*/
				$accountName = "Babangida Zachariah";
				$accountNumber = "1234567890";
				$ch += 30;
				$x = 20;
				 for($i = 0; $i < strlen($accountName); $i++) {
					
					
					$num = substr($accountName, $i, 1);
					
					//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
					 imagettftext($receipt, 20, 0, $x, $ch, $textcolor, $font, $num);
					 
					 $x += 15;
				}
				$ch += 30;
				$x = 20;
				 for($i = 0; $i < strlen($accountNumber); $i++) {
					
					
					$num = substr($accountNumber, $i, 1);
					
					//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
					 imagettftext($receipt, 20, 0, $x, $ch, $textcolor, $font, $num);
					 
					 $x += 15;
				}
				
				//Draw a horizontal line across the receipt
				 $linecolor = imagecolorallocate($receipt, 204, 153, 255);
				 imagesetthickness($receipt, 2);
				 
				 $ch += 20;
				//bool imageline ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
				imageline($receipt, 0, $ch, $width, $ch, $linecolor);
				
				//Make a web service call to get items
				//Item at X= 10, quantity at x=250, and amount at x = 300
				$x = 20;
				$y = $ch + 30;
				$k = 0;
				$item = explode("$", "Item $ Qty $ Price (RM)");
				foreach($item as $output){
					
					for($i = 0; $i < strlen($output); $i++) {
						
						//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
						 imagettftext($receipt, 10, 0, $x, $y, $textcolor, $font, $output[$i]);
						 
						 $x += 10;
					}
					
					if($k == 0){
						$x = 200;
					}else{
						$x = 250;
					}
					$k += 1;
				}
				$purchasedItems = explode("##" ,GetPurchasedItems($merchantUrl, $transactionID));
				$y += 30;
				$x = 10;
				$k = 0;
				foreach($purchasedItems as $purchasedItem){
				
					$item = explode("$",$purchasedItem);
					foreach($item as $output){
						
						for($i = 0; $i < strlen($output); $i++) {
							
							//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
							 imagettftext($receipt, 10, 0, $x, $y, $textcolor, $font, $output[$i]);
							 
							 $x += 10;
						}
						
						if($k == 0){
							$x = 220;
						}else{
							$x = 280;
						}
						$k += 1;
					}
					$y += 30;
					$x = 10;
					$k = 0;
				}
				
				//
			}
			
			
			imagepng($receipt, "Receipts/receipt".$transactionID.$merchantUrl.".png");
			return true;
		}catch(Exception $e){
		
			return false;
		}
	}
	
	$output = GenerateReciept(20, "lazada.com.my");
?>