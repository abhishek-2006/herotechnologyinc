<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "herotechnology";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
} catch (Exception $e) {
    die("SYSTEM_FAILURE: Database connection lost. " . $e->getMessage());
}

// 2. PayU Gateway Configuration
define('PAYU_MODE', 'sandbox'); 

define('PAYU_MERCHANT_KEY', (PAYU_MODE == 'sandbox') ? "TxuxLn" : "K4cfY7");
define('PAYU_SALT', (PAYU_MODE == 'sandbox') ? "oYVA5vyBJvRcn9fMqbFHM71LRLByuvf3" : "Dr2DZtzxj6h59L15q1Pj5L91tCBBZAf7");
define('PAYU_API_URL', (PAYU_MODE == 'sandbox') ? 'https://test.payu.in/_payment' : 'https://secure.payu.in/_payment');

// Identity Marker for PayU (Your Name: Salt- 32 bit)
define('PAYU_NAME', 'Salt- 32 bit'); 
?>