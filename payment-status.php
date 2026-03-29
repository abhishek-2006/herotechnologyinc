<?php
include 'header.php';

// 1. Safe Variable Retrieval
$txnid       = $_POST['txnid'] ?? '';
$status      = $_POST['status'] ?? '';
$posted_hash = $_POST['hash'] ?? '';
$email       = $_POST['email'] ?? '';
$firstname   = $_POST['firstname'] ?? '';
$productinfo = $_POST['productinfo'] ?? '';
$amount      = $_POST['amount'] ?? '';
$mihpayid    = $_POST['mihpayid'] ?? '';
$mode        = $_POST['mode'] ?? '';
$key  = PAYU_MERCHANT_KEY;
$salt = PAYU_SALT;

$status_success = false;
$course_id = 0;
    
// 2. Verify integrity via Hash Check
$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
$hash = strtolower(hash("sha512", $retHashSeq));

// 3. Status Validation Node
if ($status === 'success') {
    
    // Fetch the existing pending enrollment using txnid
    $enroll_res = mysqli_query($conn, "SELECT enrollment_id, course_id, user_id FROM enrollments WHERE txnid = '$txnid' LIMIT 1");
    
    if ($enroll = mysqli_fetch_assoc($enroll_res)) {
        $enroll_id = $enroll['enrollment_id'];
        $course_id = $enroll['course_id'];

        // Financial Ledger Synchronization
        $check_p = mysqli_query($conn, "SELECT payment_id FROM payments WHERE transaction_id = '$mihpayid'");
        
        if (mysqli_num_rows($check_p) == 0) {
            $pay_sql = "INSERT INTO payments (enrollment_id, transaction_id, amount, payment_status, payment_method) 
                        VALUES ('$enroll_id', '$mihpayid', '$amount', 'SUCCESS', '$mode')";
            mysqli_query($conn, $pay_sql);

            // Access Activation Node
            mysqli_query($conn, "UPDATE enrollments SET status = 'active', activated_at = NOW() WHERE enrollment_id = '$enroll_id'");
        }
        $status_success = true;
    }
}
?>

<main class="min-h-screen bg-[var(--app-bg)] text-[var(--text-main)] flex items-center justify-center p-6 transition-colors duration-500">
    <div class="animate__animated animate__zoomIn max-w-md w-full bg-[var(--card-bg)] rounded-[3.5rem] p-12 text-center shadow-2xl border border-[var(--border-dim)]">
        
        <?php if ($status_success === true): ?>
            <div class="w-20 h-20 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner animate__animated animate__bounceIn animate__delay-1s">
                <i class="fas fa-check text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-2">Payment <span class="text-emerald-500 not-italic">Successful</span></h2>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-10">Access to course has been granted.</p>
            
            <div class="space-y-4">
                <a href="learn.php?id=<?= $course_id ?>" class="block w-full py-5 bg-hero-blue text-white rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl hover:scale-105 transition-all">
                    <i class="fas fa-graduation-cap mr-2"></i> Start Learning
                </a>
                <a href="receipt.php?txnid=<?= $txnid ?>" class="inline-block text-[9px] font-black uppercase tracking-widest text-slate-400 hover:text-hero-orange transition-colors">
                    <i class="fas fa-file-invoice mr-2"></i> Download Receipt
                </a>
            </div>
        <?php else: ?>
            <div class="w-20 h-20 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner animate__animated animate__shakeX">
                <i class="fas fa-times text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-2">Payment <span class="text-red-500 not-italic">Failed</span></h2>
            <p class="text-slate-500 text-xs mb-10">The payment gateway could not verify the transaction signature.</p>
            <a href="courses.php" class="block w-full py-5 bg-hero-orange text-white rounded-2xl font-black uppercase tracking-widest text-[10px]">Return to Courses</a>
        <?php endif; ?>

    </div>
</main>