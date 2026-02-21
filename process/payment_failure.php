<?php
session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* =========================
       1. Collect PayU Response
       ========================= */
    $status      = $_POST['status'];
    $firstname   = $_POST['firstname'];
    $amount      = $_POST['amount'];
    $txnid       = $_POST['txnid'];
    $posted_hash = $_POST['hash'];
    $key         = $_POST['key'];
    $productinfo = $_POST['productinfo'];
    $email       = $_POST['email'];
    $payu_id     = $_POST['mihpayid'] ?? "NA";
    $error_msg   = $_POST['error_Message'] ?? "Transaction failed.";

    $salt = PAYU_SALT;


    // 2. Verify Hash
    $hashSeq = "$salt|$status|||||||||||$email|$firstname|$productinfo|$amount|$txnid|$key";
    $calc_hash = strtolower(hash("sha512", $hashSeq));


    if ($calc_hash === $posted_hash) {

        // 3. Fetch Enrollment Info
        $stmt = $conn->prepare("
            SELECT enrollment_id,user_id,course_id
            FROM enrollments
            WHERE txnid=? LIMIT 1
        ");

        $stmt->bind_param("s", $txnid);
        $stmt->execute();
        $result = $stmt->get_result();

        $enroll_id = null;
        $user_id   = null;
        $course_id = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $enroll_id = $row['enrollment_id'];
            $user_id   = $row['user_id'];
            $course_id = $row['course_id'];
        }


        // 4. Log Failed Payment
        $stmt = $conn->prepare("
            INSERT INTO payments
            (enrollment_id,user_id,course_id,amount,payment_status,transaction_id,gateway_id,error_log)
            VALUES (?,?,?,?,?,?,?,?)
        ");

        $statusFail = "failed";

        $stmt->bind_param(
            "iiidssss",
            $enroll_id,
            $user_id,
            $course_id,
            $amount,
            $statusFail,
            $txnid,
            $payu_id,
            $error_msg
        );

        $stmt->execute();
    }


    // Redirect to Failure Page with Context
    $course = $_SESSION['last_course_id'] ?? 0;
    header("Location: ../checkout.php?id=$course&payment=failed");
    exit();

} else {
    header("Location: ../index.php");
    exit();
}
?>