<?php
SESSION_START();	
	$accountType =""; 
	$accountName =""; 
	$accountBalance =""; 
	$accountCardType =""; 
	$accountCardNumber =""; 
	$accountNumber ="";
	$accountAddress = "";
	
	$accountCardExpiryMonth =""; 
	$accountCardExpiryYear =""; 
	$accountCardCVC =""; 
	$accountCardPin =""; 
	
	$success = false;
	$message ="";
	if(isset($_POST['btnSubmit'])){
		$accountType = $_POST['accountType']; 
		$accountName = $_POST['accountName']; 
		$accountAddress = $_POST['accountAddress']; 
		$accountCardType =$_POST['accountCardType'];  
		
		$success = true;
		
		if(empty($accountType)){
			$success = false;
			$message = "Select Account Type!!!";
		}
		
		if(empty($accountName)){
			$success = false;
			$message = "Account Name Field Cannot Be Empty!!!";
		}
		if(empty($accountCardType)){
			$success = false;
			$message = "Select Account Card Type!!!";
		}
		
		if(empty($accountAddress)){
			$success = false;
			$message = "Account Address Field Cannot Be Empty!!!";
		}
		include $_SERVER['DOCUMENT_ROOT'].'/cimb.com.my/connection.php';
		
		if($success){
		
			//Genearate Account Number
			$gotIt = false;
			while(!$gotIt){
			
				$tempAccNum = rand((int)1000000000, (int)9999999999);
				$mysqli = connection();
				$sql = "SELECT * FROM tblAccounts WHERE accountNumber='$tempAccNum'";
				
				$result = $mysqli->query($sql);
				if($result->num_rows < 1){
					$accountNumber = $tempAccNum;
					$gotIt = true;
				}
				
			}
			
			//Generate Account Card Number
			$gotIt = false;
			while(!$gotIt){
			
				$tempCardNum = rand((int)100000000, (int)999999999);
				
				$tempCardNum .= rand((int)1000000, (int)9999999);
				$mysqli = connection();
				$sql = "SELECT * FROM tblCards WHERE cardNumber='$tempCardNum'";
				
				$result = $mysqli->query($sql);
				if($result->num_rows < 1){
					$accountCardNumber = $tempCardNum;
					$gotIt = true;
				}
				
			}
			
			 
			$accountBalance =1000; 
			$months = array("01","02","03","04","05","06","07","08","09","10","11","12");
			$accountCardExpiryMonth = $months[rand(1,11)]; 
			
			//$years = array("18","19","20"
			$accountCardExpiryYear =rand(date('y')+2, date('y')+4); //This works fine
			
			$possibleCVCandPin = "0123456789";
			
			$possibleCVCandPin  = str_shuffle($possibleCVCandPin);
			$accountCardCVC = substr($possibleCVCandPin, 0,3); 
			
			$possibleCVCandPin  = str_shuffle($possibleCVCandPin);
			$accountCardPin = substr($possibleCVCandPin, 0,4); 
			
			//Insert into various tables
			$mysqli = connection();
			$sql = "INSERT INTO tblAccounts (accountType,
											accountNumber,
											accountName,
											accountAddress,
											accountBalance)
									VALUES( '$accountType',
											'$accountNumber',
											'$accountName',
											'$accountAddress',
											$accountBalance)
											";
			
			$result = $mysqli->query($sql);
			
			$cardAccountID = $mysqli->insert_id;
			$sql = "INSERT INTO tblCards (cardType,
											cardAccountID,
											cardNumber,
											cardExperyMonth,
											cardExperyYear,
											cardCVC,
											cardPin)
									VALUES( '$accountCardType',
											$cardAccountID,
											'$accountCardNumber',
											'$accountCardExpiryMonth',
											'$accountCardExpiryYear',
											'$accountCardCVC',
											'$accountCardPin')
											";
			
			$result = $mysqli->query($sql);
			
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>CIMB BANK - New Account Application</title>
<style type="text/css">

		/* Reset body padding and margins */
	body { margin:0; padding:0; }
	 
	/* Make Header Sticky */
	#topHeader_container { 
		background:#808080; 
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
		background:#e62e00; 
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
		background:#ffffff; 
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
	
	/* Menu Related  */
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
		 background-color: #ffffff;
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
	
	
	/*Side Menu Bar*/
	 #sidebar ul { 
		background: #eee; 
		padding: 10px; 
	}
	li { 
		margin: 0 0 0 20px; 
	}
	#main { 
		width: 390px;
		float: left; 
	}
	#sidebar { 
		width: 250px; 
		position: fixed; 
		left: 72%; 
		top: 150px; 
		margin: 0 0 0 110px; 
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
		background-color: #000033;
	}

	#formControl {
		border-radius: 5px;
		background-color: #f2f2f2;
		padding: 20px;
	}
</style>
    <script type="text/javascript">
	
		//MyJavascript
		function AddItemToCart(code){
		
			//if(code =="Submit"){
			
			//	alert(code);
			//}else{
				if(window.XMLHttpRequest)
				{
					
					//code for internet explorer 7 and above, Firefox, safari, opera, and Chrome
					xmlhttp =new XMLHttpRequest();
				}else
				{
					//code for intenet explorer 6 and bellow
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function()
				{
					
					if((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
					{
						
						
						if(code =="Submit"){
			
							
						}else{
							//alert(xmlhttp.responseText);
							//append Item to cart item list
							///*
							
							
							
							var para = document.createElement("li");
							var node = document.createElement("a");
							var txt = document.createTextNode(xmlhttp.responseText);
							node.appendChild(txt);
							para.appendChild(node);
							var element = document.getElementById("cartItems");
							element.appendChild(para);
							//*/
						}
					}
				}
				
				//var qty = document.getElementById("qty").options.item(document.getElementById("qty").selectedIndex).text ;
				//alert(qty);
				xmlhttp.open("GET", "addItemToCart.php?item=" + code , true);
				xmlhttp.send();
				
			
			//}
			
		}
		
		
	</script>
	
	 <link href="themes/4/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="themes/4/js-image-slider.js" type="text/javascript"></script>
    <link href="generic.css" rel="stylesheet" type="text/css" />
	 
	
</head>
<body>
<!-- BEGIN: Sticky Header -->
<div id="topHeader_container">
    <div id="topHeader">
        <ul id="topMenu">
		
			<li><a href="#">Personal </a></li>
			<li><a href="#">Business</a></li>
			<li><a href="#">Apply ##########</a></li>
			<li><a href="#">CIMB Islamic</a></li>
			<li><a href="login.php">CIMB Preferred</a></li>
			<li><a href="">CIMB Private Banking</a></li>
			<li><a href="#">Global Sites</a></li>
		</ul>

    </div>
</div>
<div id="midHeader_container">
    <div id="midHeader">
        
			<div id="middleBarLogo">
				
					<a href="index.php"><img src="images/logo.png" id="logo" alt="LOGO" /></a>
				
				<form id="tfnewsearch" method="get" action="http://www.google.com">
						<a href="login.php">Login</a>
				</form>
				
				<div class="tfclear"></div>
				
			</div>
		
    </div>
</div>
<div id="lowerHeader_container">
    <div id="lowerHeader">
        <ul id="topMenu">
		
			<li><a href="createNewAccount.php">New Account Application</a></li>
			<li><a href="#">Bank With Us</a></li>
			<li><a href="#">Products</a></li>
			<li><a href="#">Credit Cards</a></li>
			
			<li><a href="#">Support</a></li>
			
		</ul>

    </div>
</div>
<!-- END: Sticky Header -->
 
<!-- BEGIN: Page Content -->
<div id="container">
    <div id="content">
		
		<form method="POST" action="createNewAccount.php">
			<div id="formControl">
				<?php
					if(!$success){
				?>
					<h1>New Account &amp; Card Application</h1>
					<select name="accountType" id="accountType" class="inputControls">
						<option value="">Select Account Type</option>
						<option value="Savings">Savings</option>
						<option value="Current">Current</option>
					</select>
					<input type ="text" name ="accountName" id="accountName" placeholder="Account Name Here" class="inputControls"  />
					<select name="accountCardType" id="accountCardType" class="inputControls">
						<option value="">Select Card Type</option>
						<option value="Master">Master Card</option>
						<option value="Verve">Verve Card</option>
						<option value="Visa">Visa Card</option>
					</select>
					<input type ="text" name ="accountAddress" id="accountAddress" placeholder="Contact Address Here" class="inputControls"  />
					<input type ="submit" name ="btnSubmit" id="btnSubmit" value="Submit" class="btnSubmit"  />
				<?php
				
					}else{
						//$message was not empty, thus we empty it and do the following.
						
						$message = "";
						//print("Message : $message");
				?>
				
					<h1>New Account &amp; Card Details</h1>
					<label class="inputControls" ><b>Account Type: </b><?php print($accountType); ?> </label>
					<label class="inputControls" ><b>Account Name: </b><?php print($accountName); ?> </label>
					<label class="inputControls" ><b>Account Number: </b><?php print($accountNumber); ?> </label>
					<label class="inputControls" ><b>Account Balace: </b><?php print($accountBalance); ?> </label>
					<label class="inputControls" ><b>Account Card Type: </b><?php print($accountCardType); ?> </label>
					<label class="inputControls" ><b>Account Card Number: </b><?php print($accountCardNumber); ?> </label>
					<label class="inputControls" ><b>Account Card Expiry Month: </b><?php print($accountCardExpiryMonth); ?> </label>
					<label class="inputControls" ><b>Account Card Expiry Year: </b><?php print($accountCardExpiryYear); ?> </label>
					<label class="inputControls" ><b>Account Card CVC: </b><?php print($accountCardCVC); ?> </label>
					<label class="inputControls" ><b>Account Card PIN: </b><?php print($accountCardPin); ?> </label>
					
					<label class="inputControls" ><b>NOTE : </b> Go To a Nearest CIMB Bank Branch To Collect Your Card. Do Ensure You Change The Card PIN Number.</label>
					
					<a href="index.php"><label name ="btnSubmit" id="btnSubmit"  class="btnSubmit"  >Close</label></a>
					<a href="createNewAccount.php"><label name ="btnSubmit" id="btnSubmit"  class="btnSubmit"  >Create New Account</label></a>
					<a href="http://104.199.190.90/"><label name ="btnSubmit" id="btnSubmit"  class="btnSubmit"  >Return To Guide Page</label></a>
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