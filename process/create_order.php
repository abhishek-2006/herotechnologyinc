<?php
require '../config.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$course_id = mysqli_real_escape_string($conn, $input['course_id']);
$user_id = $_SESSION['user_id'];

// Fetch verified price and user details
$course = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price FROM courses WHERE course_id = '$course_id'"));
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name, email, phone FROM user_master WHERE user_id = '$user_id'"));

$order_id = "HERO_" . time() . "_" . $user_id;
$amount = $course['price'];

// 1. Create the Enrollment Record first
$ins_enroll = "INSERT INTO enrollments (user_id, course_id, cashfree_order_id, status) 
               VALUES ('$user_id', '$course_id', '$order_id', 'pending')";
mysqli_query($conn, $ins_enroll);
$enrollment_id = mysqli_insert_id($conn);

// 2. Call Cashfree API to get Session ID
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://sandbox.cashfree.com/pg/orders");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'order_id' => $order_id,
    'order_amount' => $amount,
    'order_currency' => 'INR',
    'order_note' => "Hero Technology Enrollment: " . $course['title'],
    'customer_details' => [
        'customer_id' => "STUDENT_$user_id",
        'customer_name' => $user['name'],
        'customer_email' => $user['email'],
        'customer_phone' => $user['phone']
    ],
    'order_meta' => [
        'return_url' => "http://localhost/herotechnologyinc/payment-status.php?order_id={order_id}&enroll_id=$enrollment_id"
    ]
]));

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "x-api-version: 2023-08-01",
    "x-client-id: " . CF_APP_ID,
    "x-client-secret: " . CF_SECRET_KEY,
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
echo $response;