<?php
require '../config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'UNAUTHORIZED_ACCESS']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$course_id = mysqli_real_escape_string($conn, $input['course_id']);
$user_id = $_SESSION['user_id'];
$_SESSION['payment_flow'] = true;

$key  = PAYU_MERCHANT_KEY;
$salt = PAYU_SALT;
$mode = PAYU_MODE;

// Fetch verified price and user identity markers
$course_query = "SELECT title, price FROM courses WHERE course_id = '$course_id' LIMIT 1";
$course = mysqli_fetch_assoc(mysqli_query($conn, $course_query));

$user_query = "SELECT name, email, phone FROM user_master WHERE user_id = '$user_id' LIMIT 1";
$user = mysqli_fetch_assoc(mysqli_query($conn, $user_query));

if (!$course) {
    echo json_encode(['error' => 'COURSE_NOT_FOUND']);
    exit();
}

// Transaction Metadata
$txnid = "HT_" . time() . "_" . $user_id;
$amount = number_format($course['price'], 2, '.', ''); 
$productinfo = $course['title'];

$firstname = $user['name']; 
$email = $user['email'];

$hashSequence = $key . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|||||||||||' . $salt;
$hash = strtolower(hash('sha512', $hashSequence));

// Initialize Pending Enrollment Node
$ins_enroll = "INSERT INTO enrollments (user_id, course_id, txnid, status) 
               VALUES ('$user_id', '$course_id', '$txnid', 'pending')";
mysqli_query($conn, $ins_enroll);

// Dispatch Payload to Frontend
echo json_encode([
    'url' => PAYU_API_URL,
    'params' => [
        'key'         => $key,
        'hash'        => $hash,
        'txnid'       => $txnid,
        'amount'      => $amount,
        'firstname'   => $firstname,
        'email'       => $email,
        'phone'       => $user['phone'],
        'productinfo' => $productinfo,
        'surl'        => $mode === 'sandbox' ? "https://localhost/herotechnologyinc/pages/payment_success.php" : "https://herotechnologyinc.com/pages/payment_success.php",
        'furl'        => $mode === 'sandbox' ? "https://localhost/herotechnologyinc/pages/payment_failure.php" : "https://herotechnologyinc.com/pages/payment_failure.php",
    ]
]);