<?php
include 'header.php';

$order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

// 1. Sync with Cashfree Node to verify payment
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, CF_API_URL . "/orders/" . $order_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "x-api-version: 2023-08-01",
    "x-client-id: " . CF_APP_ID,
    "x-client-secret: " . CF_SECRET_KEY
]);

$response = curl_exec($ch);
$order_data = json_decode($response, true);
curl_close($ch);

$status_success = false;

if ($order_data['order_status'] === 'PAID') {
    // 2. Fetch the existing pending enrollment ID
    $enroll_res = mysqli_query($conn, "SELECT enrollment_id, course_id, user_id FROM enrollments WHERE cashfree_order_id = '$order_id' LIMIT 1");
    $method_info = $order_data['payment_method'] ?? null;
    $detected_method = 'CASHFREE';

    if ($method_info) {
            
        $detected_method = strtoupper(array_keys($method_info)[0]);
    }

    if ($enroll = mysqli_fetch_assoc($enroll_res)) {
        $enroll_id = $enroll['enrollment_id'];
        $course_id = $enroll['course_id'];
        $user_id   = $enroll['user_id'];
        $amount    = $order_data['order_amount'];
        $cf_txn_id = $order_data['cf_order_id'];
        
        // 3. DATABASE INSERT: Financial Ledger
        $check_p = mysqli_query($conn, "SELECT payment_id FROM payments WHERE transaction_id = '$cf_txn_id'");
        if (mysqli_num_rows($check_p) == 0) {
            $pay_sql = "INSERT INTO payments (enrollment_id, transaction_id, amount, payment_status, payment_method) 
                        VALUES ('$enroll_id', '$cf_txn_id', '$amount', 'SUCCESS', '$detected_method')";
            mysqli_query($conn, $pay_sql);

            // 4. DATABASE UPDATE: Access Activation
            mysqli_query($conn, "UPDATE enrollments SET status = 'active', activated_at = NOW() WHERE enrollment_id = '$enroll_id'");
        }
        $status_success = true;
    }
}
?>

<main class="min-h-screen bg-[var(--app-bg)] text-[var(--text-main)] flex items-center justify-center p-6 transition-colors duration-500">
    <div class="max-w-md w-full bg-[var(--card-bg)] rounded-[3.5rem] p-12 text-center shadow-2xl border border-[var(--border-color)]">
        
        <?php if ($status_success): ?>
            <div class="w-20 h-20 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                <i class="fas fa-check text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-2">Course <span class="text-hero-orange not-italic">Active</span></h2>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-10">Course enrollment successful.</p>
            
            <a href="learn.php?id=<?= $course_id ?>" class="block w-full py-5 bg-hero-blue text-white rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl hover:scale-105 transition-all">
                <i class="fas fa-graduation-cap mr-2"></i> Start Learning
            </a>
            <a href="generate-invoice.php?order_id=<?= $order_id ?>" class="inline-block mt-6 text-[9px] font-black uppercase tracking-widest text-slate-400 hover:text-hero-orange transition-colors">
                <i class="fas fa-file-invoice mr-2"></i> Download Receipt
            </a>
        <?php else: ?>
            <div class="w-20 h-20 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                <i class="fas fa-times text-2xl"></i>
            </div>
            <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-2">Sync <span class="text-hero-orange not-italic">Failed</span></h2>
            <p class="text-slate-500 text-xs mb-10">Transaction was not authorized by the gateway.</p>
            <a href="checkout.php?id=<?= $course_id ?>" class="block w-full py-5 bg-hero-orange text-white rounded-2xl font-black uppercase tracking-widest text-[10px]">Retry Transaction</a>
        <?php endif; ?>

    </div>
</main>

<script>
    // Sync theme with system/local preference
    if(localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
</script>