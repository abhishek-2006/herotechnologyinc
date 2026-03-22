<?php
require 'config.php';

// Verification Protocol: Extracting identification from URL parameters
$order_id = $_GET['txnid'] ?? $_GET['transaction_id'] ?? '';
$order_id = mysqli_real_escape_string($conn, $order_id);

// Synchronized Intelligence Query
$query = "SELECT e.status, e.enrolled_at, u.name as student_name, c.title as course_title 
          FROM enrollments e 
          JOIN user_master u ON e.user_id = u.user_id 
          JOIN courses c ON e.course_id = c.course_id 
          WHERE (e.txnid = '$order_id') 
          AND e.status = 'active' LIMIT 1";

$res = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification | Hero Technology</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="assets/img/favicon.ico" type="image/x-icon" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
        }
    </style>
</head>
<body class="bg-[#020617] text-white flex items-center justify-center min-h-screen p-6">

    <div class="max-w-md w-full bg-[#0F172A] rounded-[3rem] p-10 border border-white/5 text-center shadow-2xl relative overflow-hidden">
        <img src="assets/img/logo.png" class="absolute -right-10 -bottom-10 h-40 opacity-5 brightness-0 invert pointer-events-none">
        
        <img src="assets/img/favicon.ico" class="h-8 mx-auto mb-8 opacity-50 relative z-10">
        
        <?php if ($data): ?>
            <div class="relative z-10">
                <div class="w-20 h-20 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-emerald-500/20">
                    <i class="fas fa-shield-check text-3xl"></i>
                </div>
                <h1 class="text-2xl font-black uppercase italic tracking-tighter mb-2">Identity <span class="text-emerald-500">Verified</span></h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.4em] mb-8">Authentic Enrollment Node</p>

                <div class="space-y-4 text-left bg-black/30 p-6 rounded-2xl border border-white/5 backdrop-blur-sm">
                    <div>
                        <p class="text-[8px] font-black uppercase text-slate-500 tracking-widest mb-1">Authorized Personnel</p>
                        <p class="text-sm font-bold uppercase text-white"><?= htmlspecialchars($data['student_name']) ?></p>
                    </div>
                    <div>
                        <p class="text-[8px] font-black uppercase text-slate-500 tracking-widest mb-1">Intelligence Track</p>
                        <p class="text-sm font-bold uppercase text-hero-orange"><?= htmlspecialchars($data['course_title']) ?></p>
                    </div>
                    <div>
                        <p class="text-[8px] font-black uppercase text-slate-500 tracking-widest mb-1">Activation Timestamp</p>
                        <p class="text-xs font-mono text-slate-300"><?= date('d M Y | H:i', strtotime($data['enrolled_at'])) ?></p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="relative z-10">
                <div class="w-20 h-20 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-500/20">
                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                </div>
                <h1 class="text-2xl font-black uppercase italic tracking-tighter mb-2">Invalid <span class="text-red-500">Node</span></h1>
                <p class="text-slate-400 text-sm leading-relaxed">This enrollment record could not be verified by the Hero Technology Mainframe.</p>
            </div>
        <?php endif; ?>

        <a href="dashboard.php" class="relative z-10 inline-block mt-10 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Return to Dashboard
        </a>
    </div>

</body>
</html>