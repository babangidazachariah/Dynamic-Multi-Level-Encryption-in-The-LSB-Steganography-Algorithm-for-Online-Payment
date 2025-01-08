<?php

	$han = fopen("trace.txt", "a+");
		
		fwrite($han, "OTP: " );
		fwrite($han, "OTPEK: ");
		fclose($han);
?>