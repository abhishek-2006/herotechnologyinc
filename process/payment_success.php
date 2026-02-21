<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hash'])) {

   // 1. Extract POST Data
    $status      = $_POST['status'];
    $firstname   = $_POST['firstname'];
    $amount      = $_POST['amount'];
    $txnid       = $_POST['txnid'];
    $posted_hash = $_POST['hash'];
    $key         = $_POST['key'];
    $productinfo = $_POST['productinfo'];
    $email       = $_POST['email'];
    $payu_id     = $_POST['mihpayid'];
    $mode        = $_POST['mode'] ?? "Unknown";

    $salt = PAYU_SALT;

    // 2. Verify Hash
    $hashSeq = "$salt|$status|||||||||||$email|$firstname|$productinfo|$amount|$txnid|$key";
    $calc_hash = strtolower(hash("sha512", $hashSeq));


    if ($calc_hash === $posted_hash && $status === "success") {

        // 3. Fetch Enrollment Details using txnid
        $stmt = $conn->prepare("SELECT enrollment_id,user_id,course_id 
                                FROM enrollments 
                                WHERE txnid=? LIMIT 1");
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


        // 4. Update Enrollment Status to Active
        $stmt = $conn->prepare("UPDATE enrollments SET status='active' WHERE enrollment_id=?");
        $stmt->bind_param("i", $enroll_id);
        $stmt->execute();

        // 5. Determine Payment Method
        $method = "Unknown";

        if (isset($_POST['PG_TYPE'])) {
            if (strpos($_POST['PG_TYPE'], "UPI") !== false) $method = "UPI";
            elseif (strpos($_POST['PG_TYPE'], "NB") !== false) $method = "NetBanking";
            elseif (strpos($_POST['PG_TYPE'], "CC") !== false || strpos($_POST['PG_TYPE'], "DC") !== false) $method = "Card";
            elseif (strpos($_POST['PG_TYPE'], "WALLET") !== false) $method = "Wallet";
        }

        // 6. Log Payment in Database
        $stmt = $conn->prepare("
            INSERT INTO payments
            (enrollment_id,user_id,course_id,amount,payment_status,transaction_id,gateway_id,payment_method)
            VALUES (?,?,?,?,?,?,?,?)
        ");

        $statusText = "success";

        $stmt->bind_param(
            "iiidssss",
            $enroll_id,
            $user_id,
            $course_id,
            $amount,
            $statusText,
            $txnid,
            $payu_id,
            $method
        );

        $stmt->execute();

        //7. Redirect to Dashboard with Success Message
        header("Location: ../dashboard.php?payment=success");
        exit();

    } else {

        // Hash mismatch or payment failure - Log the error and redirect to checkout
        $error = $_POST['error_Message'] ?? "Hash mismatch";

        $stmt = $conn->prepare("
            INSERT INTO payments
            (enrollment_id,amount,payment_status,transaction_id,error_log,gateway_id)
            VALUES (?,?,?,?,?,?)
        ");

        $fail = "failed";
        $dummyEnroll = 0;
        $dummyGateway = $_POST['mihpayid'] ?? "NA";

        $stmt->bind_param(
            "idssss",
            $dummyEnroll,
            $amount,
            $fail,
            $txnid,
            $error,
            $dummyGateway
        );

        $stmt->execute();

        header("Location: ../checkout.php?payment=failed");
        exit();
    }

} else {
    header("Location: ../index.php");
    exit();
}
?>