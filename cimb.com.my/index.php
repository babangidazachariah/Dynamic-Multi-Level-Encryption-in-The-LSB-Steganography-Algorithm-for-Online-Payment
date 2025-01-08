<?php
SESSION_START();	
	//require_once 'createStuffs.php';
	
	if($_SESSION['submit'] == true){
		$_SESSION['submit'] = false;
		//header("location:checkout.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Welcome to CIMB BANK</title>
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
			<li><a href="newAccount.php">Apply For New Account</a></li>
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
				
					<img src="images/logo.png" id="logo" alt="LOGO" />
				
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
		
		<div id="sliderFrame">
			<div id="slider">
				<img width="100%" src="images/slider-1.jpg" alt="#htmlcaption1" /> 
				<img width="100%" src="images/slider-2.jpg" alt="#htmlcaption2" />
				<img width="100%" src="images/slider-3.jpg" alt="#htmlcaption3" />
				<img width="100%" src="images/slider-4.jpg" alt="#htmlcaption4" />
				<img width="100%" src="images/slider-5.jpg" alt="#htmlcaption1" /> 
				
				
			</div>
			<!--Custom navigation buttons on both sides-->
			<div class="group1-Wrapper">
				<a onClick="imageSlider.previous()" class="group1-Prev"></a>
				<a onClick="imageSlider.next()" class="group1-Next"></a>
			</div>
			<!--thumbnails-->
			<div id="thumbs">
				<!-- navigation buttons in the thumbnails bar -->
				<a onClick="imageSlider.previous()" class="group2-Prev"></a>
				<a id='auto' onClick="switchAutoAdvance()"></a>
				<a onClick="imageSlider.next()" class="group2-Next" style="margin-right:30px;"></a>
				<!--Each thumb
				<div class="thumb"><img src="images/thumb-1.gif" /></div>
				<div class="thumb"><img src="images/thumb-2.gif" /></div>
				<div class="thumb"><img src="images/thumb-3.gif" /></div>
				<div class="thumb"><img src="images/thumb-4.gif" /></div>
				<div class="thumb"><img src="images/thumb-5.gif" /></div>
				<div class="thumb"><img src="images/thumb-6.gif" /></div>
				<div class="thumb"><img src="images/thumb-7.gif" /></div>
				<div class="thumb"><img src="images/thumb-8.gif" /></div>
				<div class="thumb"><img src="images/thumb-9.gif" /></div>
				-->
			</div>
			<div id="htmlcaption1" style="display: none;">
				<div style="width:190px;height:200px;display:inline-block;background:transparent url(images/caption1.jpg) no-repeat 0 0;border-radius:4px;"></div>
			</div>
			<div id="htmlcaption2" style="display: none;">
				<div style="width:190px;height:100px;display:inline-block;background:transparent url(images/caption2.jpg) no-repeat 0 0;border-radius:4px;"></div>
			</div>
			<div id="htmlcaption3" style="display: none;">
				<div style="width:190px;height:200px;display:inline-block;background:transparent url(images/caption3.jpg) no-repeat 0 0;border-radius:4px;"></div>
			</div>
			<div id="htmlcaption4" style="display: none;">
				<div style="width:190px;height:200px;display:inline-block;background:transparent url(images/caption4.jpg) no-repeat 0 0;border-radius:4px;"></div>
			</div>
		</div>
		
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