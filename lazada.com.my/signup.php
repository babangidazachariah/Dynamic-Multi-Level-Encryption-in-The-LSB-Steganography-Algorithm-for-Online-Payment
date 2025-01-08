<?php
SESSION_START();	
	$errorMessage ="";
	if(isset($_POST['btnSubmit'])){
	
		
		$language ="";
		$password = "";
		$year ="";
		$month ="";
		$email ="";
		$name ="";
		$bank = "";
		$accountNumber="";
		
		if(empty($_POST['lang'])){
			$errorMessage ="Select Prefered Language";
		}
		if(empty($_POST['password'])){
			$errorMessage ="Password Field Cannot Be Empty";
		}
		if(empty($_POST['password2'])){
			$errorMessage ="Confirm Password Field Cannot Be Empty";
		}
	
		if(empty($_POST['bday'])){
			$errorMessage ="Select Date of Birth";
		}
		if(empty($_POST['fullName'])){
			$errorMessage ="Name Field Cannot Be Empty";
		}
		if(empty($_POST['email'])){
			$errorMessage ="Email Field Cannot Be Empty";
		}
		if(empty($_POST['RegistrationForm[gender]'])){
			$errorMessage ="Select Gender";
		}
		
		if(empty($_POST['bank'])){
			$errorMessage ="Select Bank";
		}
		
		if(empty($_POST['accountNumber'])){
			$errorMessage ="Account Number Field Cannot Be Empty";
		}
		if($_POST['RegistrationForm[password2]'] != $_POST['RegistrationForm[password]']){
			$errorMessage ="Password Mismatch";
		}
		
		
		
		if(empty($errorMessage)){
			
			require_once 'connection.php';
			
			$bank = $_POST['bank'];
			$accountNumber = $_POST['accountNumber'];
			$language = $_POST['lang'];
				
			$password = $_POST['password'];
			$passwordTwo = $_POST['password2'];
		
			//$day = $_POST['RegistrationForm[day]'];
			$name = $_POST['fullName'];
			$email = $_POST['email'];
			$gender = $_POST['gender'];
			
			$dob = $_POST['bday'];
			$query = "INSERT INTO tblRegisteredCustomers (registeredEmail,
															registeredName,
															registeredDob,
															registeredGender,
															registeredLanguage,
															
															registerePassword) 
						VALUES ('$email','$name','$dob','$gender','$language','$password')";
			$mysqli = connection();
			$result = $mysqli->query($query);
			
			
			if($mysqli->insert_id > 0){
				
				
				$customerID = $mysqli->insert_id;
				$query = "INSERT INTO tblCustomerAccounts (
															customerRegisteredID,
															customerBank,
															customerAccountNumber
															) 
													VALUES (,'$bank','$accountNumber')";
				$mysqli = connection();
				$result = $mysqli->query($query);
				
				
				if($mysqli->insert_id > 0){
					$erroMessage = "Successfully Created";
					$_SESSION['bank'] = $bank;
					$_SESSION['accountNumber'] = $accountNumber;
				}
			}
			
		}
	
	}
	
	
?>
<!DOCTYPE html>
<html>
<head>
<title>LAZADA - Customer Signup</title>
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
	}
	#topHeader{ 
		line-height:10px; 
		margin:0 auto; 
		width:100%; 
		text-align:right; 
	}
	
	
	/*Lower Header*/
	#lowerHeader_container { 
		background:#264d73; 
		border:1px solid #666; 
		height:40px; left:0; 
		position:fixed; width:100%; 
		top:102px; 
	}
	#lowerHeader{ 
		line-height:20px; 
		margin:0 auto; 
		width:100%; 
		text-align:center; 
	}
	 
	/*Middle Header*/
	 #midHeader_container { 
		background:#264d73; 
		border:1px solid #666; 
		height:60px; left:0; 
		position:fixed; width:100%; 
		top:40px; 
	}
	#midHeader{ 
		line-height:60px; 
		margin:0 auto; 
		width:100%; 
		text-align:center; 
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
		<form method="POST" action="signup.php">
			<div id="formControl">
					<h1>New Customer Registration</h1>
					<select name="gender" id="gender" class="inputControls">
						<option value="">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
					<input type ="text" name ="email" id="email" placeholder="Email Here" class="inputControls"  />
					Date of Birth<input type="date" name="bday" min="1900-01-02" class="inputControls">
					
					<select name="lang" id="lang" class="inputControls">
						<option value="">Select Language</option>
						<option value="Eng">English</option>
						<option value="Mal">Malay</option>
						
					</select>
					
					<input type ="password" name ="password" id="password" placeholder="Password Here" class="inputControls"  />
					<input type ="password" name ="password2" id="password2" placeholder="Retype Password Here" class="inputControls"  />
					<select name="bank" id="bank" class="inputControls">
						<option value="">Select Bank</option>
						<option value="CIMB">CIMB BANK</option>
						
					</select>
					
					<input type ="text" name ="accountNumber" id="accountNumber" placeholder="Account Number Here" class="inputControls"  />
					<input type ="submit" name ="btnSubmit" id="btnSubmit" value="Submit" class="btnSubmit"  />
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