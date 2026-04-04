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
    $mode        = $_POST['mode'] ?? "Digital Payment";

    $salt = PAYU_SALT;

    // 2. Verify Hash
    $hashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
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

        $stmt = $conn->prepare("SELECT username, name FROM user_master WHERE user_id=? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'student';
            $_SESSION['payment_flow'] = false;
        } else {
            die("User not found");
        }

        // 4. Update Enrollment Status to Active
        $stmt = $conn->prepare("UPDATE enrollments SET status='active' WHERE enrollment_id=?");
        $stmt->bind_param("i", $enroll_id);
        $stmt->execute();

        // 5. Determine Payment Method
        $method = "Gateway";

        if (isset($_POST['PG_TYPE'])) {
            if (strpos($_POST['PG_TYPE'], "UPI") !== false) $method = "UPI";
            elseif (strpos($_POST['PG_TYPE'], "NB") !== false) $method = "NetBanking";
            elseif (strpos($_POST['PG_TYPE'], "CC") !== false || strpos($_POST['PG_TYPE'], "DC") !== false) $method = "Card";
            elseif (strpos($_POST['PG_TYPE'], "WALLET") !== false) $method = "Wallet";
        }

        // 6. Log Payment in Database
        $stmt = $conn->prepare("INSERT INTO payments (enrollment_id, user_id, course_id, amount, payment_status, transaction_id, gateway_id, payment_method) VALUES (?,?,?,?,'success',?,?,?)");
        $stmt->bind_param("iiidsss", $enroll_id, $user_id, $course_id, $amount, $txnid, $payu_id, $method);
        $stmt->execute();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Payment Successful</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <meta http-equiv="refresh" content="3;url=../generate-invoice.php?txnid=<?= $txnid ?>">
    </head>

    <body class="flex items-center justify-center min-h-screen bg-green-50">
        <div class="bg-white shadow-xl rounded-3xl p-10 text-center max-w-md">        
            <div class="text-green-600 text-5xl mb-4"> ✓ </div>

            <h1 class="text-2xl font-bold mb-2">Payment Successful</h1>
            <p class="text-gray-500 mb-6">Your course access has been activated.</p>

            <a href="../generate-invoice.php?txnid=<?= $txnid ?>" class="inline-block px-6 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition-colors">
                View Invoice
            </a>

            <p class="text-sm text-gray-400">
                Redirecting to invoice in a few seconds...
            </p>

        </div>
    </body>
</html>
<?php
    exit;
    } else {

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
            "idssss", $dummyEnroll, $amount, $fail, $txnid, $error, $dummyGateway
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