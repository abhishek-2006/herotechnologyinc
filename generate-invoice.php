<?php
require 'config.php';

$order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

// Comprehensive Intelligence Query
$query = "SELECT 
            e.enrollment_id, e.cashfree_order_id, e.activated_at,
            c.title, c.course_id,
            u.name, u.email, u.phone,
            p.amount, p.transaction_id, p.payment_method, p.payment_status
          FROM enrollments e 
          JOIN courses c ON e.course_id = c.course_id 
          JOIN user_master u ON e.user_id = u.user_id 
          JOIN payments p ON e.enrollment_id = p.enrollment_id 
          WHERE e.cashfree_order_id = '$order_id' 
          AND e.status = 'active' 
          LIMIT 1";

$res = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($res);

if (!$data) { die("Fulfillment Data Not Found."); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clearance_<?= $order_id ?> | Hero Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=JetBrains+Mono:wght@500&display=swap');
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        .mono { font-family: 'JetBrains Mono', monospace; }
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            #dashboard-link, 
            #print-button, 
            .no-print,
            .no-print-container,
            footer, 
            header.no-print {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            @page {
                margin: 1.5cm;
            }

            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .receipt-card {
                box-shadow: none !important;
                border: 1px solid #f1f5f9;
                border-radius: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                height: 100% !important;
            }
        }
    </style>
</head>
<body class="p-6 md:p-12">

    <div class="max-w-3xl mx-auto bg-white rounded-[3rem] shadow-2xl overflow-hidden receipt-card">
        <div class="bg-[#1B264F] p-12 text-white flex justify-between items-start">
            <div>
                <img src="assets/img/logo.png" class="h-8 mb-6 brightness-0 invert" alt="Hero Tech">
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Access <span class="text-[#EE6C4D]">Cleared</span></h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.4em] opacity-50 mt-2">Document ID: <?= $data['enrollment_id'] ?></p>
            </div>
            <div class="text-right">
                <div class="bg-[#EE6C4D] text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-full mb-4 inline-block">Official Receipt</div>
                <p class="text-xs font-bold opacity-60 uppercase"><?= date('D, M j, Y', strtotime($data['activated_at'])) ?></p>
            </div>
        </div>

        <div class="p-12">
            <div class="grid grid-cols-2 gap-12 mb-12">
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Student Identity</h4>
                    <p class="text-lg font-black text-[#1B264F]"><?= htmlspecialchars($data['name']) ?></p>
                    <p class="text-sm text-slate-500 font-medium"><?= htmlspecialchars($data['email']) ?></p>
                    <p class="text-[10px] mono text-slate-500 mt-1 uppercase"><?= htmlspecialchars($data['phone']) ?></p>
                </div>
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Payment Protocol</h4>
                    <p class="text-sm font-bold text-[#1B264F] uppercase italic"><?= $data['payment_method'] ?></p>
                    <p class="text-[10px] mono text-slate-500 mt-1 uppercase">Ref: <?= $data['transaction_id'] ?></p>
                </div>
            </div>

            <div class="border-t border-b border-slate-100 py-8 mb-12">
                <table class="w-full">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <th class="text-left pb-4">Curriculum Description</th>
                            <th class="text-right pb-4">Node ID</th>
                            <th class="text-right pb-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2">
                                <p class="text-base font-black text-[#1B264F] uppercase"><?= htmlspecialchars($data['title']) ?></p>
                                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mt-1">Full Access Unlocked</p>
                            </td>
                            <td class="text-right font-bold text-slate-500 mono text-xs uppercase">#COURSE_<?= $data['course_id'] ?></td>
                            <td class="text-right text-xl font-black text-[#1B264F]">₹<?= number_format($data['amount'], 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-end">
                <div class="opacity-40">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode("http://localhost/herotechnologyinc/verify-enrollment.php?oid=" . $data['cashfree_order_id']) ?>" class="grayscale mb-4 h-20 w-20">
                    <p class="text-[8px] font-black uppercase tracking-widest max-w-[150px]">Scan to verify authenticity of this digital clearing.</p>
                </div>
                <div class="text-right">
                    <h3 class="text-4xl font-black text-[#EE6C4D] italic leading-none mb-2">PAID</h3>
                    <p class="text-[9px] font-black text-[#1B264F] uppercase tracking-widest">Authorized by Hero Technology Inc.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto mt-8 flex justify-between no-print-container px-6">
        <a href="dashboard.php" id="dashboard-link" class="text-xs font-black uppercase tracking-widest text-slate-500 hover:text-[#1B264F] transition-all">← Back to Dashboard</a>
        <button onclick="executeFulfillment()" id="print-button" class="bg-[#1B264F] text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest shadow-xl hover:scale-105 transition-all">
            <i class="fas fa-print mr-2"></i> Print Document
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
    function executeFulfillment() {
        const element = document.getElementById('receipt-content');
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        // Common configuration for the PDF
        const opt = {
            margin:       0.5,
            filename:     'HeroTech_Receipt_<?= $order_id ?>.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
        };

        if (isMobile) {

            document.querySelector('.no-print-container').style.display = 'none';
            
            html2pdf().set(opt).from(element).save().then(() => {
                // Restore buttons after download starts
                document.querySelector('.no-print-container').style.display = 'flex';
            });
        } else {
            // DESKTOP LOGIC: Standard Print to PDF
            window.print();
        }
    }
    </script>
</body>
</html>