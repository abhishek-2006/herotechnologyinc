<?php
require 'config.php';

$txnid = $_GET['txnid'] ?? '';
$txnid = mysqli_real_escape_string($conn, $txnid);

$query = "SELECT 
            e.enrollment_id, e.txnid, e.activated_at,
            c.title, c.course_id,
            u.name, u.email, u.phone,
            p.amount, p.transaction_id, p.payment_method, p.payment_status
          FROM enrollments e 
          JOIN courses c ON e.course_id = c.course_id 
          JOIN user_master u ON e.user_id = u.user_id 
          JOIN payments p ON e.enrollment_id = p.enrollment_id 
          WHERE e.txnid = '$txnid' 
          AND e.status = 'active' 
          LIMIT 1";

$res = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($res);

if (!$data) { die("FULFILLMENT_ERROR: Transaction data not found in PayUMoney node."); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clearance_<?= $txnid ?> | Hero Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=JetBrains+Mono:wght@500&display=swap');
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .mono { font-family: 'JetBrains Mono', monospace; }
        
        .receipt-card { position: relative; }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 7rem;
            font-weight: 900;
            color: rgba(27, 38, 79, 0.03);
            pointer-events: none;
            text-transform: uppercase;
            z-index: 0;
        }

        @media print {
            body { background: white !important; padding: 0 !important; margin: 0 !important; }
            .no-print { display: none !important; }
            .receipt-card { box-shadow: none !important; border: 1px solid #e2e8f0 !important; border-radius: 0 !important; }
        }
    </style>
</head>
<body class="p-4 md:p-12">

    <div id="receipt-content" class="max-w-3xl mx-auto bg-white rounded-[3rem] shadow-2xl receipt-card">
        
        <div class="watermark">HERO TECH</div>

        <div class="bg-[#1B264F] p-8 md:p-12 text-white flex flex-col md:flex-row justify-between items-start relative z-10">
            <div>
                <img src="assets/img/logo.png" class="h-8 mb-6 brightness-0 invert" alt="Hero Tech">
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Access <span class="text-[#EE6C4D]">Cleared</span></h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.4em] opacity-50 mt-2">PayU Trace ID: <?= $txnid ?></p>
            </div>
            <div class="text-left md:text-right mt-6 md:mt-0">
                <div class="bg-[#EE6C4D] text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-full mb-4 inline-block shadow-lg">Official Receipt</div>
                <p class="text-xs font-bold opacity-60 uppercase"><?= date('D, M j, Y', strtotime($data['activated_at'])) ?></p>
            </div>
        </div>

        <div class="p-8 md:p-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 mb-12">
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Student Identity</h4>
                    <p class="text-lg font-black text-[#1B264F]"><?= htmlspecialchars($data['name']) ?></p>
                    <p class="text-sm text-slate-500 font-medium"><?= htmlspecialchars($data['email']) ?></p>
                    <p class="text-[10px] mono text-slate-500 mt-1 uppercase"><?= htmlspecialchars($data['phone']) ?></p>
                </div>
                <div class="text-left md:text-right">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Payment Protocol</h4>
                    <p class="text-sm font-bold text-[#1B264F] uppercase italic">Method: <?= $data['payment_method'] ?: 'PayUMoney' ?></p>
                    <p class="text-[10px] mono text-slate-500 mt-1 uppercase">Ref: <?= $data['transaction_id'] ?></p>
                </div>
            </div>

            <div class="border-t border-b border-slate-100 py-8 mb-12">
                <table class="w-full">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <th class="text-left pb-4">Course Description</th>
                            <th class="text-right pb-4">Course ID</th>
                            <th class="text-right pb-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2">
                                <p class="text-base font-black text-[#1B264F] uppercase"><?= htmlspecialchars($data['title']) ?></p>
                                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mt-1"><i class="fas fa-check-circle mr-1"></i> PayU Verified Access</p>
                            </td>
                            <td class="text-right font-bold text-slate-500 mono text-xs uppercase">#Course_<?= $data['course_id'] ?></td>
                            <td class="text-right text-xl font-black text-[#1B264F]">₹<?= number_format($data['amount'], 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center md:items-end gap-8">
                <div class="opacity-60 flex flex-col items-center md:items-start">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode("https://herotechnologyinc.com/verify-enrollment.php?txnid=" . $txnid) ?>" class="grayscale mb-4 h-24 w-24 border-2 border-slate-100 p-1 rounded-xl">
                    <p class="text-[8px] font-black uppercase tracking-widest text-center md:text-left max-w-[150px]">Authenticity verified via PayU Mainframe.</p>
                </div>
                <div class="text-center md:text-right">
                    <div class="inline-block border-4 border-[#EE6C4D] px-6 py-2 rounded-xl rotate-[-5deg] mb-4">
                        <h3 class="text-4xl font-black text-[#EE6C4D] italic leading-none uppercase">PAID</h3>
                    </div>
                    <p class="text-[9px] font-black text-[#1B264F] uppercase tracking-widest">Authorized by Hero Technology Inc.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto mt-8 flex justify-between px-6 no-print">
        <a href="dashboard.php" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-[#1B264F] transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Dashboard
        </a>
        <button onclick="executeFulfillment()" id="print-button" class="bg-[#1B264F] text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest shadow-xl hover:bg-[#EE6C4D] transition-all active:scale-95">
            <i class="fas fa-file-pdf mr-2"></i> Download Invoice
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        function executeFulfillment() {
            const element = document.getElementById('receipt-content');
            const btn = document.getElementById('print-button');

            btn.innerHTML = '<i class="fas fa-sync fa-spin mr-2"></i> Generating Node...';
            btn.disabled = true;

            const opt = {
                margin: 0.3,
                filename: 'HeroTech_Invoice_<?= $txnid ?>.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 3, scrollY: 0, useCORS: true },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                btn.innerHTML = '<i class="fas fa-file-pdf mr-2"></i> Download Invoice';
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>