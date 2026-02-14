<?php
require 'config.php';

// We verify using the Order ID or a Hash from the URL
$order_id = isset($_GET['oid']) ? mysqli_real_escape_string($conn, $_GET['oid']) : '';

$query = "SELECT e.status, e.activated_at, u.name, c.title 
          FROM enrollments e 
          JOIN user_master u ON e.user_id = u.user_id 
          JOIN courses c ON e.course_id = c.course_id 
          WHERE e.cashfree_order_id = '$order_id' AND e.status = 'active' LIMIT 1";

$res = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification Terminal | Hero Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[#020617] text-white flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full bg-[#0F172A] rounded-[3rem] p-10 border border-white/5 text-center shadow-2xl">
        <img src="assets/img/favicon.ico" class="h-8 mx-auto mb-8 opacity-50">
        
        <?php if ($data): ?>
            <div class="w-20 h-20 bg-emerald-500/20 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shield-check text-3xl"></i>
            </div>
            <h1 class="text-2xl font-black uppercase italic tracking-tighter mb-2">Identity <span class="text-emerald-500">Verified</span></h1>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.4em] mb-8">Authentic Enrollment Node</p>

            <div class="space-y-4 text-left bg-black/30 p-6 rounded-2xl border border-white/5">
                <div>
                    <p class="text-[8px] font-black uppercase text-slate-500">Authorized Student</p>
                    <p class="text-sm font-bold uppercase"><?= htmlspecialchars($data['name']) ?></p>
                </div>
                <div>
                    <p class="text-[8px] font-black uppercase text-slate-500">Curriculum Access</p>
                    <p class="text-sm font-bold uppercase text-hero-orange"><?= htmlspecialchars($data['title']) ?></p>
                </div>
                <div>
                    <p class="text-[8px] font-black uppercase text-slate-500">Verification Date</p>
                    <p class="text-xs font-mono"><?= date('d-m-Y | H:i', strtotime($data['activated_at'])) ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="w-20 h-20 bg-red-500/20 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-exclamation-triangle text-3xl"></i>
            </div>
            <h1 class="text-2xl font-black uppercase italic tracking-tighter mb-2">Invalid <span class="text-red-500">Node</span></h1>
            <p class="text-slate-400 text-sm">This enrollment record could not be verified by the Hero Tech Mainframe.</p>
        <?php endif; ?>

        <a href="https://herotechnologyinc.com" class="inline-block mt-10 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all">
            Return to Official Site
        </a>
    </div>

</body>
</html>