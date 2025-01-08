<?php
SESSION_START();	
	//require_once 'createStuffs.php';
	
	if($_SESSION['submit'] == true){
		$_SESSION['submit'] = false;
		header("location:checkout.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>LAZADA - Online Shopping and Sales</title>
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
			<li><a href="#">Electronics</a></li>
			<li><a href="#">Women's Fashion</a></li>
			<li><a href="#">Men's Fashion</a></li>
			<li><a href="#">Home &amp; Living</a></li>
			<li><a href="#">Health &amp; Beauty</a></li>
			<li><a href="#">Baby &amp; Toys</a></li>
			<li><a href="#">Sport &amp; Travel </a></li>
			<!--<li><a href="">Auto Groceries &amp; More</a></li>-->
			<li><a href="#">Riang Ria Raya</a></li>
			<!--<li><a href="#">Shop By Brands</a></li>-->
		</ul>

    </div>
</div>
<!-- END: Sticky Header -->
 
<!-- BEGIN: Page Content -->
<div id="container">
    <div id="content">
		<?php
			require_once 'connection.php';
			
			$query = "SELECT * FROM tblItems";
			$mysqli = connection();
			$result = $mysqli->query($query);
			
			while($row = $result->fetch_assoc()){
			
					print( '<section>
						<code>
							<table width="100%" height="100%">
								<tr>
									<td rowspan="2" width="50%">
										<div class="tooltip">
											<img width="100%" height="100%"alt="Pix" 
												src="http://146.148.55.110/lazada.com.my/ItemsPictures/'.$row['itemPicture'].'" />
												
											<span class="tooltiptext">'.$row['itemName'].'</span>
										</div>
																				
									</td>
									<td width="50%">
										'.$row['itemDescription'].'
									</td>
								</tr>
								<tr>
									
									<td bgcolor="#000033">
										<!--<select name="qty" id="qty" >
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>-->
										RM'.$row['itemUnitPrice'].'
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="submit" onclick="AddItemToCart('."'".$row['itemCode']."'".');" value="Add To Cart" class="addCart">
									</td>
									
								</tr>
							</table>
						</code>
					</section>');
			
			
			}
		
		
		?>
		
    </div>
</div>
<div id="sidebar">
			
	<div class="tooltip">
		<ul id="cartItems">
			<h3>Items On Cart</h3>
				<form id="index" method="POST" action="index.php">
					<input type='submit'  value='Checkout' onclick="AddItemToCart('Submit');" class="addCart" />
				</form>
			<?php
				//print($_SESSION['cart']);
				///*
				if(!(empty($_SESSION['cart']))){
					require_once 'connection.php';
					//print($_SESSION['cart']);
					$itemList = $_SESSION['cart'];
					$addedItems = explode("##", $itemList);
					//print_r($addedItems);
					foreach($addedItems as $item){
						print($item);
						$iteName ="";
						$query = "SELECT * FROM tblItems WHERE itemCode='".$item."'";
						$mysqli = connection();
						$result = $mysqli->query($query);
						
						while($row = $result->fetch_assoc()){
						
							print("<li>". $row['itemName']."</li>");
						}
					}
				}
				//*/
			?>
			
		</ul>
		<span class="tooltiptext">To Remove Items From Cart, Click on Checkout</span>
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