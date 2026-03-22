<?php
require '../config.php';

if (!isset($_SESSION['payment_flow'])) {
    header("Location: ../");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Collect PayU Response
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
    $hashSeq = "$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key";
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

        if ($result->num_rows === 0) {
            die("Enrollment not found");
        }

        $row = $result->fetch_assoc();
        $enroll_id = $row['enrollment_id'];
        $user_id   = $row['user_id'];
        $course_id = $row['course_id'];

        $stmt = $conn->prepare("SELECT username FROM user_master WHERE user_id=? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $user['username'];
        } else {
            die("User not found");
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

    $course = $_SESSION['course_id'] ?? 0;
    header("Location: checkout.php?id=$course&payment=failed");
    exit();

} else {
    header("Location: ../index.php");
    exit();
}
?>