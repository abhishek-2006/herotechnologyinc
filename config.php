<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "herotechnology";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

define('CF_APP_ID', '44420448bffc79e4a3f218cc602444');
    define('CF_SECRET_KEY', '375d3690ef62c3e3009fc66ddd73b6247feb2551');
    define('CF_MODE', 'sandbox');
    define('CF_API_URL', (CF_MODE == 'sandbox') ? 'https://sandbox.cashfree.com/pg' : 'https://api.cashfree.com/pg');

try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
