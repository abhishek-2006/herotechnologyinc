<?php
require '../config.php';

$_SESSION['payment_flow'] = true;
// 1. Session & Identity Validation
if (!isset($_SESSION['payment_flow'])) {
    header("Location: ../");
    exit();
}

$txnid = "UNKNOWN";
$error_msg = "Transaction synchronization failed.";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect PayU Response Nodes
    $status      = $_POST['status'];
    $firstname   = $_POST['firstname'];
    $amount      = $_POST['amount'];
    $txnid       = $_POST['txnid'];
    $posted_hash = $_POST['hash'];
    $key         = $_POST['key'];
    $productinfo = $_POST['productinfo'];
    $email       = $_POST['email'];
    $payu_id     = $_POST['mihpayid'] ?? "NA";
    $error_msg   = $_POST['error_Message'] ?? "Transaction failed at gateway.";

    $salt = PAYU_SALT;

    // 2. Security Verification: Hash Protocol
    $hashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
    $calc_hash = strtolower(hash("sha512", $hashSeq));

    if ($calc_hash === $posted_hash) {
        // 3. Fetch Enrollment Intelligence
        $stmt = $conn->prepare("SELECT enrollment_id, user_id, course_id FROM enrollments WHERE txnid=? LIMIT 1");
        $stmt->bind_param("s", $txnid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $enroll_id = $row['enrollment_id'];
            $user_id   = $row['user_id'];
            $course_id = $row['course_id'];

            // Log Failed Payment Dispatch
            $stmt = $conn->prepare("INSERT INTO payments (enrollment_id, user_id, course_id, amount, payment_status, transaction_id, gateway_id, error_log) VALUES (?, ?, ?, ?, 'failed', ?, ?, ?)");
            $stmt->bind_param("iiidsss", $enroll_id, $user_id, $course_id, $amount, $txnid, $payu_id, $error_msg);
            $stmt->execute();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Failed | Hero Tech</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
        }
    </style>
</head>
<body class="bg-[#020617] text-white flex items-center justify-center min-h-screen p-6 font-sans">

    <div class="max-w-md w-full bg-[#0F172A] rounded-[3rem] p-12 border border-white/5 text-center shadow-2xl relative overflow-hidden">
        
        <div class="relative z-10">
            <div class="w-20 h-20 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-8 border border-red-500/20">
                <i class="fas fa-exclamation-triangle text-3xl"></i>
            </div>

            <h1 class="text-2xl font-black uppercase italic tracking-tighter mb-2">Payment <span class="text-red-500">Failed</span></h1>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] mb-10">Synchronization Interrupted</p>

            <div class="space-y-4 text-left bg-black/30 p-6 rounded-2xl border border-white/5 mb-8">
                <div>
                    <p class="text-[8px] font-black uppercase text-slate-500 tracking-widest mb-1">Error Identity</p>
                    <p class="text-xs font-bold text-slate-300"><?= htmlspecialchars($error_msg) ?></p>
                </div>
                <div>
                    <p class="text-[8px] font-black uppercase text-slate-500 tracking-widest mb-1">Transaction Node</p>
                    <p class="text-xs font-mono text-hero-orange">#<?= htmlspecialchars($txnid) ?></p>
                </div>
            </div>

            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-6 italic">
                System will auto-redirect to dashboard in <span id="timer">5</span> seconds...
            </p>

            <div class="flex flex-col gap-3">
                <a href="../dashboard.php" class="w-full bg-hero-blue text-white py-4 rounded-xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-blue-900/20 hover:bg-hero-orange transition-all">
                    Return to Dashboard
                </a>
                <a href="../contact.php" class="w-full bg-white/5 text-slate-400 py-4 rounded-xl font-black uppercase tracking-widest text-[10px] hover:text-white transition-all">
                    Contact Support
                </a>
            </div>
        </div>
    </div>

    <script>
        let seconds = 5;
        const timerElement = document.getElementById('timer');
        
        const countdown = setInterval(() => {
            seconds--;
            timerElement.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = '../dashboard.php';
            }
        }, 1000);
    </script>
</body>
</html>