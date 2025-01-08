<?php
SESSION_START();
	/*
	
		Here, when a user checksout from a merchant site, the merchant makes payment request to the bank via this interface.
		This interface accepts the Client Account Number, records the transaction details and generates
		a One Time Password is generated and embedded in to another generated PNG Captcha Image
		Divides the captcha image into two, sends one of the half to the client and the other half to the merchant.
	*/
/*
//To Download and store a remote image
$image = file_get_contents('http://www.url.com/image.jpg');
file_put_contents('/images/image.jpg', $image); //Where to save the image on your server

//to delete picture from directory
unlink("folder_name/".file_name);
*/
	
	if(isset($_POST['btnSubmit'])){
		$bank = $_POST['bank'];
		$accountNumber = $_POST['accountNumber'];
		$total = $_POST['total'];
		$accountID = "";
		$customerID = "";
		$merchantAccountNumber = "1234567890";
		$message = "";
		if(!empty($bank) && !empty($accountNumber) && !empty($_SESSION['cart'])){
			
			//Include Necessary Files
			require_once 'connection.php';
			try{
				include_once('cimb/webServicesClientFunctions.php');
				
			}catch(Exception $e){
				print($e->getMessage());
			}
			//We check if customer is registered or not
			$query = "SELECT * FROM tblCustomerAccounts WHERE 
			customerBank ='". $bank."' AND customerAccountNumber ='".$accountNumber."'";
			$mysqli = connection();
			$result = $mysqli->query($query);
			
			if($result->num_rows < 1){
				
				
			
				//Not a Registered Member. So store accoutn number
				$query = "INSERT INTO tblCustomerAccounts (
															customerBank,
															customerAccountNumber
															) 
													VALUES ('$bank','$accountNumber')";
				$mysqli = connection();
				
				$result = $mysqli->query($query);
				
				
				
				$customerID = $mysqli->insert_id;
			}else{
			
				while($row = $result->fetch_assoc()){
				
					$customerID = $row['customerID'];
				}
			}
			
			
			
			//CREATE A TRANSACTION FOR THIS ORDER
			$transDate = date("m-d-y");
			$transClose = "No";
			$query = "INSERT INTO tblTransactions ( transactionDate,
															transactionCustomerAccountID,
															transactionClosed
															) 
													VALUES ('$transDate',$customerID,'$transClose')";
						
			
			$mysqli = connection();
			
			$result = $mysqli->query($query);
			
			
			
			$transactionID = $mysqli->insert_id;
			//there should be a merchant ID and account Number for validattion purpose
			if(!empty($transactionID)){
			
				//Repeatedly Add items to tblPurchasedItems using their transaction ID
				
				$qty = 0;
				$itemsiInCart = explode("##",$_SESSION['cart']);
				$grpItems =array_count_values($itemsiInCart);
				$grpItem = array_unique($itemsiInCart);
				/*
				var_dump($grpItems);
				var_dump($grpItem);
				$transactionID = 9;
				//*/
				
				
				foreach($grpItem as $item){
				
					$qty = $grpItems[$item];
				
										
					$sql = "INSERT INTO tblPurchasedItems (
													transactionID,
													itemCode,
													quantity
													)
												VALUES ($transactionID,'$item',$qty)";
					$mysqli = connection();
					
					$mysqli->query($sql);
				
				}
				
				//Having Added all Ordered Items to the tblpurchasedItems
				//Make a web service call to the bank for payment request.
				
				//if(MakePaymentRequest($transactionID, $accountNumber, $merchantAccountNumber, $total)){
				
				
					MakePaymentRequest($transactionID, $accountNumber, $merchantAccountNumber, $total);
					
					
					//When Successfull, display a message to notify the customer
					//header("location:index.php");
					$message = "Payment Request Successfully Made to Your Bank <br /> Open Your OPAS Mobile App To Approve the Payment!!!";
					$_SESSION['cart'] = "";
				//}else{
				//	$message = "Error While Processing Payment Request!!!";
				//}
				
				//*/
			}
		}else{
			$error = urlencode("Select Bank and Input Bank Account Number!!!");
			header("location:checkout.php?error=".$error);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<style type="text/css">

		/* Reset body padding and margins */
	body { margin:0; padding:0; }
	 
	/* Make Header Sticky */
	#topHeader_container { 
		background:#000033; 
		border:1px solid #666; 
		height:40px; left:0; 
		position:fixed; width:100%; 
		top:0; 
		z-index:99;
	}
	#topHeader{ 
		line-height:10px; 
		margin:0 auto; 
		width:100%; 
		text-align:right; 
		z-index:99;
	}
	
	
	/*Lower Header*/
	#lowerHeader_container { 
		background:#264d73; 
		border:1px solid #666; 
		height:40px; left:0; 
		position:fixed; width:100%; 
		top:102px; 
		z-index:99;
	}
	#lowerHeader{ 
		line-height:20px; 
		margin:0 auto; 
		width:100%; 
		text-align:center; 
		z-index:99;
	}
	 
	/*Middle Header*/
	 #midHeader_container { 
		background:#264d73; 
		border:1px solid #666; 
		height:60px; left:0; 
		position:fixed; width:100%; 
		top:40px; 
		z-index:99;
	}
	#midHeader{ 
		line-height:60px; 
		margin:0 auto; 
		width:100%; 
		text-align:center;
		z-index:99;
	}
	 
	/* CSS for the content of page. I am giving top and bottom padding of 80px to make sure the header and footer do not overlap the content.*/
	#container { 
		
		margin:0 auto; 
		overflow:auto; 
		padding:150px 0; 
		width:940px; 
	}
	#content{
		
	}
	
	/* Menu Related  0043363169*/
	ul#menu {
		padding: 0;
	}

	ul#menu li {
		display: inline;
	}

	ul#menu li a {
		background-color: black;
		color: #e6e6e6;
		padding: 10px 20px;
		text-decoration: none;
		border-radius: 4px 4px 0 0;
	}

	ul#menu li a:hover {
		color:white;
	}
	 
	 /**/
	 
	 
	 /*Top Menu*/
	 ul#topMenu {
		padding: 0;
		}

	ul#topMenu li {
		display: inline;
	}

	ul#topMenu li a {
		
		color: #f2f2f2;
		padding: 10px 20px;
		text-decoration: none;
		border-radius: 4px 4px 0 0;
		font-size: 100%;
	}

	ul#topMenu li a:hover {
		 background-color: #264d73;
	}
	 
	 
	 
	/* Make Footer Sticky */
	#footer_container { 
		background:#eee;
		border:1px solid #666; 
		bottom:0;
		height:60px; 
		left:0; 
		 position:fixed;
		width:100%; 
	}
	#footer { 
		line-height:60px; 
		margin:0 auto; 
		width:100%; 
		text-align:center; 
	}
	
	
	#logo{
		top:45px;
		float:left;
		padding-left:50px;
		width:150px;
		height:50px;
	}
	
	
	#cart{
		width:6%;
		height:70%;
		position:absolute;
		padding-right:190px;
		right:0%;
		top:10px;
	}
	
	#cashDelivery{
		width:10%;
		height:130%;
		position:absolute;
		padding-right:50px;
		right:0%;
		top:0px;
	}
	
	
	/*Search Bar Related*/
	#tfheader{
		background-color:#c3dfef;
	}
	#tfnewsearch{
	
		float:center;
		padding: 5px;
	}
	.tftextinput{
		width:500px;
		height:25px;
		margin: 0;
		padding: 5px 15px;
		font-family: Arial, Helvetica, sans-serif;
		font-size:14px;
		border:1px solid #0076a3; border-right:0px;
		border-top-left-radius: 5px 5px;
		border-bottom-left-radius: 5px 5px;
	}
	.tfbutton {
		
		height:37px;
		margin: 0;
		padding: 5px 15px;
		font-family: Arial, Helvetica, sans-serif;
		font-size:14px;
		outline: none;
		cursor: pointer;
		text-align: center;
		text-decoration: none;
		color: #ffffff;
		border: solid 1px #0076a3; border-right:0px;
		background: #FFA500;
		background: -webkit-gradient(linear, left top, left bottom, from(#FFA500), to(#FFA500));
		background: -moz-linear-gradient(top,  #FFA500,  #0078a5);
		border-top-right-radius: 5px 5px;
		border-bottom-right-radius: 5px 5px;
	}
	.tfbutton:hover {
		text-decoration: none;
		background: #000033;
		background: -webkit-gradient(linear, left top, left bottom, from(#000033), to(#000033));
		background: -moz-linear-gradient(top,  #000033,  #000033);
	}
	/* Fixes submit button height problem in Firefox */
	.tfbutton::-moz-focus-inner {
	  border: 0;
	}
	.tfclear{
		clear:both;
	}
	
	
	
	/*Flexbox*/
	code {
	  background: #2db34a;
	  border-radius: 6px;
	  color: #fff;
	  display: block;
	  font: 14px/24px "Source Code Pro", Inconsolata, "Lucida Console", Terminal, "Courier New", Courier;
	  padding: 2px 2px;
	  text-align: center;
	   
	 
	}
	section {
	  display: inline-block;
	   margin: 0 2px 2px 2px;
	  width: 30%;
	}
	section:hover {
		text-decoration: none;
		background: #000033;
		background: -webkit-gradient(linear, left top, left bottom, from(#000033), to(#000033));
		background: -moz-linear-gradient(top,  #000033,  #000033);
	}
	
	/*Add To Cart Button*/
	.addCart {
		width:100%;
		height:30px;
		margin: 0;
		padding: 5px 5px;
		font-family: Arial, Helvetica, sans-serif;
		font-size:14px;
		outline: none;
		cursor: pointer;
		text-align: center;
		text-decoration: none;
		color: #ffffff;
		border: solid 1px #0076a3; border-right:0px;
		background: #FFA500;
		background: -webkit-gradient(linear, left top, left bottom, from(#FFA500), to(#FFA500));
		background: -moz-linear-gradient(top,  #FFA500,  #0078a5);
		
		border-radius: 5px 5px 5px 5px;
	}
	.addCart:hover {
		text-decoration: none;
		background: #000033;
		background: -webkit-gradient(linear, left top, left bottom, from(#000033), to(#000033));
		background: -moz-linear-gradient(top,  #000033,  #000033);
	}
	
	
	/*Tooltips CSS*/
	.tooltip {
		position: relative;
		display: inline;
		/*border-bottom: 1px dotted black;*/
	}

	.tooltip .tooltiptext {
		visibility: hidden;
		
		background-color: #000033 ;
		color: #fff;
		text-align: center;
		border-radius: 6px;
		padding: 5px 0;

		/* Position the tooltip */
		position: absolute;
		/*z-index: 1;*/ /*Deleted so any media content within it can go to the behind the floating header*/
		 width: 120px;
		bottom: 100%;
		left: 50%; 
		margin-left: -60px; /* Use half of the width (120/2 = 60), to center the tooltip */
	}

	.tooltip:hover .tooltiptext {
		visibility: visible;
	}
	
	
	/*Form Elements*/
	.inputControls {
		width: 100%;
		padding: 12px 20px;
		margin: 8px 0;
		display: inline-block;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
	}

	.btnSubmit {
		width: 100%;
		background-color: #264d73;
		color: white;
		padding: 14px 20px;
		margin: 8px 0;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	.btnSubmit:hover {
		background-color: #45a049;
	}

	#formControl {
		border-radius: 5px;
		background-color: #f2f2f2;
		padding: 20px;
	}
	
</style>
    <script type="text/javascript">
	
		//MyJavascript
		
	</script>
</head>
<body>
<!-- BEGIN: Sticky Header -->
<div id="topHeader_container">
    <div id="topHeader">
        <ul id="topMenu">
		
			<li><a href="#">GET THE APP</a></li>
			<li><a href="#">SELL ON LAZADA</a></li>
			<li><a href="#">CUSTOMER CARE</a></li>
			<li><a href="#">TRACK MY ORDER</a></li>
			<li><a href="login.php">LOGIN</a></li>
			<li><a href="signup.php">SIGNUP</a></li>
			<li><a href="#">TUKUR BAHASA</a></li>
		</ul>

    </div>
</div>
<div id="midHeader_container">
    <div id="midHeader">
        
			<div id="middleBarLogo">
				
					<a href="index.php" ><img src="images/logo.png" id="logo" alt="LOGO" /></a>
				
				<form id="tfnewsearch" method="get" action="http://www.google.com">
						<input type="text" placeholder="Search for Products, Brands, and Shops" class="tftextinput" name="q" size="21" maxlength="120"><input type="submit" value="search" class="tfbutton">
				</form>
				<img src="images/cart.png" id="cart" alt="Cart" />
				<img src="images/cashdelivery.png" id="cashDelivery" alt="Cart" />
				<div class="tfclear"></div>
				
			</div>
		
    </div>
</div>
<div id="lowerHeader_container">
    <div id="lowerHeader">
        <ul id="topMenu">
			<li><a href="shopping.php">Electronics</a></li>
			<li><a href="#">Women's Fashion</a></li>
			<li><a href="#">Men's Fashion</a></li>
			<li><a href="#">Home &amp; Living</a></li>
			<li><a href="#">Health &amp; Beauty</a></li>
			<li><a href="#">Baby &amp; Toys</a></li>
			<li><a href="#">Sport &amp; Travel </a></li>
			<!--<li><a href="">Auto Groceries &amp; More</a></li>-->
			<li><a href="#">Riang Ria Raya</a></li>
			<li><a href="#">Shop By Brands</a></li>
		</ul>

    </div>
</div>
<!-- END: Sticky Header -->
 
<!-- BEGIN: Page Content -->
<div id="container">
    <div id="content">
		
			
			
			<?php
				//print($_SESSION['cart']);
				///*
				if(!(empty($_SESSION['cart']))){
					print('<table border="1" width="100%">
		
						<tr>
						
							<th width="40%"> Item </th><th width="20%"> Quantity </th><th width="30%"> Price (RM)</th><th width="10%"> Action </th>
						</tr>');
						
					require_once 'connection.php';
					//print($_SESSION['cart']);
					$itemList = $_SESSION['cart'];
					$addedItems = explode("##", $itemList);
					//print_r($addedItems);
					$total = 0;
					foreach($addedItems as $item){
						//print($item);
						$iteName ="";
						$query = "SELECT * FROM tblItems WHERE itemCode='".$item."'";
						$mysqli = connection();
						$result = $mysqli->query($query);
						
						while($row = $result->fetch_assoc()){
						
							print("<tr><td>". $row['itemName']."</td><td>". $row['itemName']
							."</td><td align='right'>". $row['itemUnitPrice']."</td>"
							."</td><td><input type='submit' value='-' class='tfbutton' onclick='AddRemoveItem(".'"'.$row['itemCode'].'"'.");' /><input type='submit' value='+' class='tfbutton' /></td></tr>");
							$total +=  $row['itemUnitPrice'];
						}
						
					}
					print("<tr><td colspan ='2'><b>Total</b></td><td align='right'><b>".$total."</b></td><td> </td></tr></table>");
				}else{
				
					print("<tr><td colspan='3'> Transaction Successfully Completed. Thus, No More Items In Your Cart <a href='index.php'>Click Here To Add Items</a></table>");
				}
				//*/
			
			?>
			
		
		<form method="POST" action="checkout.php">
			<div id="formControl">
					
					<?php
						if(!empty($message )){
							print("<label class='inputControls'>".$message." <br /><a href='index.php'>Click Here To Shop Again</a></label>");
						}else{
					?>
					<h1>Order Payment Details</h1>
					<input type='hidden' name="total" id="total" value="<?php print($total); ?>" />
					<select default name="bank" id="bank" class="inputControls">
						<option value="">Select Bank</option>
						<option value="CIMB" selected>CIMB BANK</option>
						
					</select>
						
					<input type ="text" value="<?php if(!empty($_SESSION['accountNumber'] )){print($_SESSION['accountNumber'] ); }?>" name ="accountNumber" id="accountNumber" placeholder="Account Number Here" class="inputControls"  />
					<input type ="submit" name ="btnSubmit" id="btnSubmit" value="Submit" class="btnSubmit"  />
					<?php
						}
					?>
			</div>
		</form>
    </div>
</div>
<!-- END: Page Content -->
 
<!-- BEGIN: Sticky Footer
	
<div id="footer_container">
    <div id="footer">
        Footer Content
    </div>
</div>
<!-- END: Sticky Footer -->
</body>
</html>
