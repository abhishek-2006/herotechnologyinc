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
$amount = number_format($course['price'], 2, '.', ''); // PayU requires 2 decimal places
$productinfo = $course['title'];

/** * PayU SHA-512 Hash Generation
 * Sequence: key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5||||||salt
 * Note: firstname is mapped to your identity "Salt- 32 bit" if needed, 
 * but usually we use the actual user's name for PayU records.
 */
$firstname = $user['name']; 
$email = $user['email'];

$hashSequence = PAYU_MERCHANT_KEY . "|$txnid|$amount|$productinfo|$firstname|$email|||||||||||" . PAYU_SALT;
$hash = strtolower(hash('sha512', $hashSequence));

// Initialize Pending Enrollment Node
$ins_enroll = "INSERT INTO enrollments (user_id, course_id, txnid, status) 
               VALUES ('$user_id', '$course_id', '$txnid', 'pending')";
mysqli_query($conn, $ins_enroll);

// Dispatch Payload to Frontend
echo json_encode([
    'url' => PAYU_API_URL,
    'params' => [
        'key'         => PAYU_MERCHANT_KEY,
        'hash'        => $hash,
        'txnid'       => $txnid,
        'amount'      => $amount,
        'firstname'   => $firstname,
        'email'       => $email,
        'phone'       => $user['phone'],
        'productinfo' => $productinfo,
        'surl'        => "http://localhost/herotechnologyinc/process/payment_success.php",
        'furl'        => "http://localhost/herotechnologyinc/process/payment_failure.php",
    ]
]);