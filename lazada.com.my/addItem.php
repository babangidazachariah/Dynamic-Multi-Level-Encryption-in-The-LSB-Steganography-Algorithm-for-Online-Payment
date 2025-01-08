<?php
	
	$errorMessage = "";
	
	if(isset($_POST['btnSubmit'])){
	
		if(empty($_POST['itemCode'])){
			$errorMessage = "Item Code Cannot Be Empty";
		}
		if(empty($_POST['itemName'])){
			$errorMessage = "Item Name Cannot Be Empty";
		}
		if(empty($_POST['itemDescription'])){
			$errorMessage = "Item Description Cannot Be Empty";
		}
		if(empty($_POST['itemPrice'])){
			$errorMessage = "Item Price Cannot Be Empty";
		}
		if(!is_numeric($_POST['itemPrice'])){
			$errorMessage = "Item Price Must Be Number,";
		}
		
		$itemCode = $_POST['itemCode'];
		$itemName = $_POST['itemName'];
		$itemDescription = $_POST['itemDescription'];
		$itemUnitPrice = $_POST['itemPrice'];
		
			if(!empty($_FILES['uploadfile'])){
				
				if(empty($errorMessage)){
				
					require_once 'connection.php';
					
					//change this path to match your images directory
					$dir = $_SERVER['DOCUMENT_ROOT']."/lazada.com.my/ItemsPictures";
					//make sure the uploaded file transfer was successful
					if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK) {
					
						switch ($_FILES['uploadfile']['error']) {
							case UPLOAD_ERR_INI_SIZE:
								$errorMessage = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
								die();
								break;
							case UPLOAD_ERR_FORM_SIZE:
								$errorMessage = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
								die();
								break;
							
							case UPLOAD_ERR_PARTIAL:
								$errorMessage = 'The uploaded file was only partially uploaded.';
								die();
								
								break;
							case UPLOAD_ERR_NO_FILE:
								$errorMessage = 'No file was uploaded.';
								die();
								break;
							case UPLOAD_ERR_NO_TMP_DIR:
								$errorMessage ='The server is missing a temporary folder.';
								die();
								break;
							case UPLOAD_ERR_CANT_WRITE:
								$errorMessage = 'The server failed to write the uploaded file to disk.';
								die();
								break;
							case UPLOAD_ERR_EXTENSION:
								$errorMessage = 'File upload stopped by extension.';
								die();
								break;
						}
					}
					//get info about the image being uploaded
				
					$imageDate = date('Y-m-d');
					list($width, $height, $type, $attr) = getimagesize($_FILES['uploadfile']['tmp_name']);
					// make sure the uploaded file is really a supported image
					$image = "";
					$ext ="";
					switch ($type) {
						case IMAGETYPE_GIF:
							try{
								$image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']);
								$ext = '.gif';
							}catch(Exception $e) {
								//echo $e->getMessage();
								//echo 'Sorry, could not upload file';
								$passportError = 'The file you uploaded was not a supported filetype.';
								die();
							}
							break;
						case IMAGETYPE_JPEG:
							try{
								$image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']);
								//print($image);
								$ext = '.jpg';
							}catch(Exception $e) {
								//echo $e->getMessage();
								//echo 'Sorry, could not upload file';
								$passportError = 'The file you uploaded was not a supported filetype.';
								die();
							}
							break;
						case IMAGETYPE_PNG:
							try{
								$image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']);
								$ext = '.png';
							}catch(Exception $e) {
								//echo $e->getMessage();
								//echo 'Sorry, could not upload file';
								$passportError = 'The file you uploaded was not a supported filetype.';
								die();
							}
							break;
						default:
							$passportError = 'The file you uploaded was not a supported filetype.';
							die();
					}
					//insert information into image table
					$query = "INSERT INTO tblItems (itemCode, itemName, itemDescription, itemUnitPrice) 
								VALUES ($itemCode,'$itemName','$itemDescription',$itemUnitPrice)";
								
					$mysqli = connection();
					$result = $mysqli->query($query);
					
					
					//retrieve the image_id that MySQL generated automatically when we inserted
					//the new record
					$last_id = $mysqli->insert_id;
					//because the id is unique, we can use it as the image name as well to make
					//sure we don't overwrite another image that already exists
					$imagename = $itemCode . $last_id. $ext;
					// update the image table now that the final filename is known.
					$sql = "UPDATE tblItems SET itemPicture = '" . $imagename . "' WHERE itemID = " . $last_id;
					
					$mysqli = connection();
		
					$result = $mysqli->query($sql);
				
					
					
					list($w,$h)  = getimagesize($image);
					//copy image into directory	
					$imageSave = imagecreatetruecolor(125,200); //Standard image size of all items.
					
					//copy and resize image
					imagecopyresized($imageSave, $image, 0, 0, 0, 0, 125, 200, $w, $h);

					imagepng($imageSave, $dir . '/' . $imagename);
					
			
					imagedestroy($image);
					imagedestroy($imageSave);
					
					
					$errorMessage = "Added Successfully!!!";
					//header("location:newWine.php
				}
			}else{
				$errorMessage ="Select/Browse Passport First!!!";
				//header("location:uploadPassport.php");
			}
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Sticky Header and Footer</title>
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
				<img src="images/logo.png" id="logo" alt="LOGO" />
				
				
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
		<form action="addItem.php" method="POST" enctype="multipart/form-data">
			<div id="formControl">
					<h1>Add New Item To Store</h1>
					<label  class="inputControls">* Require Fields</label>
					<input type ="text" name ="itemCode" id="itemCode" placeholder="* Item Code Here" class="inputControls"  />
					
					
					<input type ="text" name ="itemName" id="itemName" placeholder="* Item Name Here" class="inputControls"  />
					<textarea name="itemDescription" id="itemDescription" placeholder="* Item Description Here" class="inputControls"></textarea>
					<input type ="text" name ="itemPrice" id="itemPrice" placeholder="* Item Unit Price Here" class="inputControls"  />
					
					
					*<input type="file" id="uploadfile" name="uploadfile" placeholder="* Item Picture Here" class="inputControls" />
												<!--<button onclick="abortRead();">Cancel read</button>-->
												<div id="progress_bar"><div class="percent">0%</div></div>

												<script>
												  var reader;
												  var progress = document.querySelector('.percent');

												  function abortRead() {
													reader.abort();
												  }

												  function errorHandler(evt) {
													switch(evt.target.error.code) {
													  case evt.target.error.NOT_FOUND_ERR:
														alert('File Not Found!');
														break;
													  case evt.target.error.NOT_READABLE_ERR:
														alert('File is not readable');
														break;
													  case evt.target.error.ABORT_ERR:
														break; // noop
													  default:
														alert('An error occurred reading this file.');
													};
												  }

												  function updateProgress(evt) {
													// evt is an ProgressEvent.
													if (evt.lengthComputable) {
													  var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
													  // Increase the progress bar length.
													  if (percentLoaded < 100) {
														progress.style.width = percentLoaded + '%';
														progress.textContent = percentLoaded + '%';
													  }
													}
												  }

												  function handleFileSelect(evt) {
													
													// Reset progress indicator on new file selection.
													progress.style.width = '0%';
													progress.textContent = '0%';

													reader = new FileReader();
													reader.onerror = errorHandler;
													reader.onprogress = updateProgress;
													reader.onabort = function(e) {
													  alert('File read cancelled');
													};
													reader.onloadstart = function(e) {
													  document.getElementById('progress_bar').className = 'loading';
													};
														reader.onload = function(e) {
															  // Ensure that the progress bar displays 100% at the end.
															  progress.style.width = '100%';
															  progress.textContent = '100%';
															  setTimeout("document.getElementById('progress_bar').className='';", 2000);
														};
														// Read in the image file as a binary string.
														reader.readAsBinaryString(evt.target.files[0]);
														// Loop through the FileList and render image files as thumbnails.
														var files = evt.target.files; // FileList object
														for (var i = 0, f; f = files[i]; i++) {
															//alert("Here");
														  // Only process image files.
															 if (!f.type.match('image.*')) {
																continue;
															 }

															var readerImage = new FileReader();

															  // Closure to capture the file information.
															 readerImage.onload = (function(theFile) {
																return function(e) {
																  // Render thumbnail.
																  document.getElementById("passport").innerHTML = ['<img height="150px" width="200px" class="thumb" src="', e.target.result,
																	'" title="', escape(theFile.name), '"/>'].join('');
																
																};
															})(f);

															  // Read in the image file as a data URL.
															 readerImage.readAsDataURL(f);
														}
													
												  }

												  document.getElementById('uploadfile').addEventListener('change', handleFileSelect, false);
												</script>   
					
					
					<input type ="submit" name ="btnSubmit" id="btnSubmit" value="Submit" class="btnSubmit"  />
			</div>
		</form>
    </div>
</div>
<!-- END: Page Content -->
 
<!-- BEGIN: Sticky Footer -->
<div id="footer_container">
    <div id="footer">
        Footer Content
    </div>
</div>
<!-- END: Sticky Footer -->
</body>
</html>