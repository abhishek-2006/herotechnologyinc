<?php
require '../config.php';

$cid = mysqli_real_escape_string($conn, $_GET['cid']);
$f = mysqli_real_escape_string($conn, $_GET['f']);
$ip = $_SERVER['REMOTE_ADDR'];

// 1. Update the time
mysqli_query($conn, "UPDATE demo_usage_logs 
                     SET minutes_watched = minutes_watched + 0.5 
                     WHERE (device_fingerprint = '$f' OR ip_address = '$ip') 
                     AND course_id = '$cid'");

// 2. Fetch the updated time to send back to JS
$res = mysqli_query($conn, "SELECT minutes_watched FROM demo_usage_logs 
                            WHERE (device_fingerprint = '$f' OR ip_address = '$ip') 
                            AND course_id = '$cid' LIMIT 1");
$data = mysqli_fetch_assoc($res);

// 3. Return as JSON 
header('Content-Type: application/json');
echo json_encode(['new_time' => $data['minutes_watched']]);
?>