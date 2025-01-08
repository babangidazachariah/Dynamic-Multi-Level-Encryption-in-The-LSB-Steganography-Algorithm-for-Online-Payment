<?php
require_once "nusoap-0.9.5/lib/nusoap.php";
$client = new nusoap_client("http://104.199.190.90/cimb.com.my/merchants/testNusoapClient.php");

$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}
 
$result = $client->call("PaymentRequest", array("transactionID" => 212,
												"customerAccountNumber" => "0987654321",
												"merchantAccountNumber" => "1234567890",
												"totalAmount" => 12));
												
//$result = $client->call("test", array("id" => "12"));
if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Books</h2><pre>";
        echo $result;
        echo "</pre>";
    }
}

?>