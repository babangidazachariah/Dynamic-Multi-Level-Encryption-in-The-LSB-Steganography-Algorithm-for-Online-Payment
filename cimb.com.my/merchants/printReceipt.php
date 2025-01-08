<?php

	require('PdfLib/fpdf.php');

	class PDF extends FPDF
	{
		private $isFinished = false;
		
		
		
		var $extgstates = array();
		var $angle=0;
		
		function Rotate($angle,$x=-1,$y=-1)
		{
			if($x==-1)
				$x=$this->x;
			if($y==-1)
				$y=$this->y;
			if($this->angle!=0)
				$this->_out('Q');
			$this->angle=$angle;
			if($angle!=0)
			{
				$angle*=M_PI/180;
				$c=cos($angle);
				$s=sin($angle);
				$cx=$x*$this->k;
				$cy=($this->h-$y)*$this->k;
				$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
			}
		}

		// alpha: real value from 0 (transparent) to 1 (opaque)
		// bm:    blend mode, one of the following:
		//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn, 
		//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
		function SetAlpha($alpha, $bm='Normal')
		{
			// set alpha for stroking (CA) and non-stroking (ca) operations
			$gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
			$this->SetExtGState($gs);
		}

		function AddExtGState($parms)
		{
			$n = count($this->extgstates)+1;
			$this->extgstates[$n]['parms'] = $parms;
			return $n;
		}

		function SetExtGState($gs)
		{
			$this->_out(sprintf('/GS%d gs', $gs));
		}

		function _enddoc()
		{
			if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
				$this->PDFVersion='1.4';
			parent::_enddoc();
		}

		function _putextgstates()
		{
			for ($i = 1; $i <= count($this->extgstates); $i++)
			{
				$this->_newobj();
				$this->extgstates[$i]['n'] = $this->n;
				$this->_out('<</Type /ExtGState');
				$parms = $this->extgstates[$i]['parms'];
				$this->_out(sprintf('/ca %.3F', $parms['ca']));
				$this->_out(sprintf('/CA %.3F', $parms['CA']));
				$this->_out('/BM '.$parms['BM']);
				$this->_out('>>');
				$this->_out('endobj');
			}
		}

		function _putresourcedict()
		{
			parent::_putresourcedict();
			$this->_out('/ExtGState <<');
			foreach($this->extgstates as $k=>$extgstate)
				$this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
			$this->_out('>>');
		}

		function _putresources()
		{
			$this->_putextgstates();
			parent::_putresources();
		}
		// Load data
		function LoadData($file)
		{
			// Read file lines
			//$lines = file($file);
			$lines = explode('##',trim($file));
			$data = array();
			foreach($lines as $line)
				$data[] = explode('@',trim($line));
			return $data;
		}

		// Simple table
		function BasicTable($header, $data)
		{
			// Header
			foreach($header as $col)
				$this->Cell(40,7,$col,1);
			$this->Ln();
			// Data
			foreach($data as $row)
			{
				foreach($row as $col)
					$this->Cell(40,6,$col,1);
				$this->Ln();
			}
		}

		// Better table
		function ImprovedTable($header, $data)
		{
			// Column widths
			$w = array(40, 35, 40, 45);
			// Header
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,'C');
			$this->Ln();
			// Data
			foreach($data as $row)
			{
				$this->Cell($w[0],6,$row[0],'LR');
				$this->Cell($w[1],6,$row[1],'LR');
				$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
				$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
				$this->Ln();
			}
			// Closing line
			$this->Cell(array_sum($w),0,'','T');
		}

		
		function Header()
		{
			// $bankLogo, $merchantLogo
			
			
			
			
		}

		
		// Page footer
		function Footer()
		{
			// Position at 1.5 cm from bottom
			$this->SetY(-15);
			
			//if($isFinished){->AliasNbPages()
			//if($this->AliasNbPages() == $this->PageNo){
				//$this->Image('Receipts/stamp.png',20,250,30);
			//}
			$this->Rotate(45,90,100);
			
			$this->SetAlpha(0.1);
			
			$this->Image('Receipts/stamp.png',20,100,100);
			
			$this->SetAlpha(1);
			
			$this->Rotate(0);
			
			$this->Image('Receipts/stamp.png',20,250,30);
			//$this->RotatedText();
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Page number
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
		
		
		
		// Colored table
		function FancyTable($customerAccountName, $customerAccountNumber, $merchantAccountName, $merchantAccountNumber,$transDate, $header,$data, $items)
		{
		
		
			$this->Image('logo.png',10,6,50);
			$this->Image("logo/www.lazada.com.my5.png",155,6,45);
			// Arial bold 15
			
			$this->SetFont('Arial','B',50);
			// Move to the right
			$this->Cell(80);
			// Title
			$this->Cell(20,45,'Purchase Receipt',0,0,'C');
			// Line break
			$this->Ln(33);
			
			$this->SetFont('Arial','B',15);
			//$date = date('d-m-y');
			
			$this->Cell(310,9,"Payment Date: ".$transDate, 0,0,'C');
			
			$this->Line(0, 50, 250, 50);
			//Header();
			$this->Ln(2);
			
			//Customer Info
			$this->SetFont('Arial','B',20);
			$this->SetY(53);
			
			$this->Cell(20,9,"Cust. Acct. Name: ", 0,0,'L');
			
			$this->SetFont('Arial','IB',20);
			$this->Cell(210,9,$customerAccountName, 0,0,'C');
			
			$this->Ln(10);
			
			$this->SetFont('Arial','B',20);
			$this->Cell(20,9,"Cust. Acct. No.: ", 0,0,'L');
			
			$this->SetFont('Arial','IB',20);
			$this->Cell(180,9,$customerAccountNumber, 0,0,'C');
			
			$this->Ln(10);
			//Merchant Info
			$this->SetFont('Arial','B',20);
			//$this->SetY(100);
			
			$this->Cell(20,9,"Mer. Acct. Name: ", 0,0,'L');
			
			$this->SetFont('Arial','IB',20);
			$this->Cell(180,9,$merchantAccountName, 0,0,'C');
			
			$this->Ln(10);
			
			$this->SetFont('Arial','B',20);
			$this->Cell(20,9,"Mer. Acct. Number: ", 0,0,'L');
			
			$this->SetFont('Arial','IB',20);
			$this->Cell(180,9,$merchantAccountNumber, 0,0,'C');
			
			$this->Line(0, 95, 250, 95);
			
			$this->Ln(5);
			// Colors, line width and bold font
			$this->SetFillColor(255,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');
			$this->SetY(100);
			
			// Header
			$this->SetFont('Arial','B',15);
			$w = array(120, 30, 40);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],9,$header[$i],1,0,'C',true);
			$this->Ln();
			// Color and font restoration
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Data
			$fill = false;
			$this->SetFont('Arial','',14);
			foreach($data as $row)
			{
			
				if($this->GetStringWidth($row[0]) > 53){
					
					$item = $row[0];
					//if($this->GetY() >
					while(strlen($item) > 0){
					
						$lenBefore = strlen($item);
						$subText = substr($item, 0, 53);
						$lastPos = strripos($subText, " ");
						
						$outText = substr($subText, 0, $lastPos);
						$subText = substr($subText, $lastPos + 1);
						$item = $subText . substr($item, 53);
						
						if($lenBefore > 53){
							$this->Cell($w[0],6,$outText,'LR',0,'L',$fill);
							$this->Cell($w[1],6,'','LR',0,'C',$fill);
							$this->Cell($w[2],6,'','LR',1,'R',$fill);
						}else{
						
							$this->Cell($w[0],6,$outText,'LR',0,'L',$fill);
						}
					}
					$this->Cell($w[1],6, trim($row[1]),'LR',0,'C',$fill);
					$this->Cell($w[2],6,trim($row[2]),'LR',0,'R',$fill);
					$this->Ln();
					$fill = !$fill;
				}else{
				
					$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
					//$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
					$this->Cell($w[1],6,trim($row[1]),'LR',0,'C',$fill);
					$this->Cell($w[2],6,trim($row[2]),'LR',0,'R',$fill);
					$this->Ln();
					$fill = !$fill;
				}
				
				
			}
			
			// Closing line
			$this->Cell(array_sum($w),0,'','T');
			
			//Stamp();
			$isFinished = true;
			
		}
	}
	
	
	require_once(__DIR__ .'/../nusoapInclude.php');
	require_once $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/connection.php";
	require_once  $_SERVER['DOCUMENT_ROOT']."/cimb.com.my/merchants/generalFunctions.php";
	
	Function RequestPurchasedItems($transactionID){
		//CLIENT FUNCTION
		//lazada.com.my 	http://146.148.55.110/
		
		$client = new nusoap_client("http://146.148.55.110/lazada.com.my/cimb/webServicesServerFunctions.php");

		$error = $client->getError();
		if ($error) {
			$error = false;
		}

		$result = $client->call("GetPurchasedItems", array("transactionID" => $transactionID));

		if ($client->fault) {
			//echo "<h2>Fault</h2><pre>";
			//print_r($result);
			//echo "</pre>";
			$error = "1";//Error
		}
		else {
			$error = $client->getError();
			if ($error) {
				//echo "<h2>Error</h2><pre>" . $error . "</pre>";
				$error = "1";
			}
			else {
				//echo "<h2>Books</h2><pre>";
			   return $result;
				//echo "</pre>";
				//header("location:index.php");
				//$error = true;
			}
		}
		/*
		//Used for Debugging
		echo "<h2>Request</h2>";
		echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
		echo "<h2>Response</h2>";
		echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
		//*/
		return $error;
	}
	
	
	
	
	$sql = "SELECT tblAccounts.accountName, tblAccounts.accountNumber, tblTransactions.mTransactionID, 
				tblTransactions.transactionTotalAmount, tblTransactions.transactionCloseDate FROM tblAccounts, tblTransactions
				WHERE tblTransactions.customerAccountID = tblAccounts.accountID AND 
				tblTransactions.bTransactionID = ".$_GET['id'];
				
	$mysqli = connection();
	$result = $mysqli->query($sql);
	$transactionID = 0;
	$totalAmount = 0;
	$customerAccountName = "";
	$customerAccountNumber = "";
	$merchantAccountName = "";
	$merchantAccountNumber = "";
	$transDate = "";
	while($row = $result->fetch_assoc()){
	
		$customerAccountName = strtoupper($row['accountName']);
		$customerAccountNumber = $row['accountNumber'];
		$transactionID = $row['mTransactionID'];
		$totalAmount = $row['transactionTotalAmount'];
		$transDate  = $row['transactionCloseDate'];
	}
	
	//Get merchant Account Details
	$sql = "SELECT tblAccounts.accountName, tblAccounts.accountNumber FROM tblAccounts, tblTransactions
				WHERE tblTransactions.merchantAccountID = tblAccounts.accountID AND 
				tblTransactions.transactionClosed = 'YES' AND tblTransactions.bTransactionID = ".$_GET['id'];
				
	$mysqli = connection();
	$result = $mysqli->query($sql);
	
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
		
			$merchantAccountName = strtoupper($row['accountName']);
			$merchantAccountNumber = $row['accountNumber'];
			
		}
		
		$items = RequestPurchasedItems($transactionID) ."@ @ ## @ @ ## TOTAL@-@RM$totalAmount";

		$pdf = new PDF();
		
		
		$pdf->AliasNbPages();
		
		$pdf->SetAutoPageBreak(true,30);
		
		/*
		$items ="Nigeria is going to be a great nation during my time as the president ; Abuja; 987768; 180M@Congo Nigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the president ; Jos;  87989@ Ghana; Abidjan; 787898@Kaduna; Jaba;86978";
		$items .= "@Nigeria is going to be a great nation during my time as the president ; Abuja; 987768; 180M@Congo Nigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the president ; Jos;  87989@ Ghana; Abidjan; 787898@Kaduna; Jaba;86978";
		$items .= "@Nigeria is going to be a great nation during my time as the president ; Abuja; 987768; 180M@Congo Nigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the president ; Jos;  87989@ Ghana; Abidjan; 787898@Kaduna; Jaba;86978";
		$items .= "@Nigeria is going to be a great nation during my time as the president ; Abuja; 987768; 180M@Congo Nigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the president ; Jos;  87989@ Ghana; Abidjan; 787898@Kaduna; Jaba;86978";
		$items .= "@Nigeria is going to be a great nation during my time as the president ; Abuja; 987768; 180M@Congo Nigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the president ; Jos;  87989@ Ghana; Abidjan; 787898@Kaduna; Jaba;86978";
		$items .= "@Nigeria is going to be a great nation during my time as the president ; Abuja; 987768; 180M@Congo Nigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the presidentNigeria is going to be a great nation during my time as the president ; Jos;  87989@ Ghana; Abidjan; 787898@Kaduna; Jaba;86978";
		//$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
		
		//*/
		
		// Column headings
		$header = array('Item', 'Quantity',  'Price (RM)');
		// Data loading
		//$data = $pdf->LoadData('countries.txt');
		$data = $pdf->LoadData($items);
		$pdf->SetFont('Arial','',14);
		

		$pdf->AddPage();
		$pdf->SetMargins(10,20,10);
		//$pdf->BasicTable($header,$data);
		//$pdf->AddPage();
		//$pdf->ImprovedTable($header,$data);
		//$pdf->AddPage();
		
		$pdf->FancyTable($customerAccountName, $customerAccountNumber, $merchantAccountName, $merchantAccountNumber,$transDate, $header,$data, $items);
		$pdf->Output();
	}else{
	
		print("Unable To Resolve Transaction.");
	}

?>