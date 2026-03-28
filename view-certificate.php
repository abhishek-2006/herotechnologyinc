<?php
require 'config.php';

// 1. Security Check: Node identification
$enrollment_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

$query = "SELECT e.*, u.name as student_name, c.title as course_title, cat.category_name 
          FROM enrollments e 
          JOIN user_master u ON e.user_id = u.user_id 
          JOIN courses c ON e.course_id = c.course_id 
          JOIN course_category cat ON c.category_id = cat.category_id
          WHERE e.enrollment_id = '$enrollment_id' 
          AND (LOWER(e.status) = 'completed' OR LOWER(e.status) = 'active') LIMIT 1";

$res = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($res);

if (!$data) {
    die("Certificate generation failed: Invalid enrollment node.");
}

// 2. Intelligence Tracking: Generate unique hash
$cert_hash = strtoupper(substr(md5($data['enrollment_id'] . $data['enrolled_at']), 0, 12));

// 3. QR Code Protocol: Link to verification terminal
$verify_url = "https://localhost/herotechnologyinc/verify.php?cert=" . $cert_hash;
$qr_api_url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($verify_url) . "&choe=UTF-8";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - <?= htmlspecialchars($data['student_name']) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Inter:wght@400;700;900&family=Pinyon+Script&display=swap');
        
        :root {
            --hero-blue: #1B264F;
            --hero-orange: #EE6C4D;
        }

        body { font-family: 'Inter', sans-serif; background: #f8fafc; margin: 0; padding: 20px; }

        .cert-outer-wrapper {
            width: 1100px;
            margin: 40px auto;
            background: #fff;
            padding: 15px;
            border: 2px solid #e2e8f0;
            box-shadow: 0 40px 100px -20px rgba(27, 38, 79, 0.2);
        }

        .cert-inner-border {
            border: 8px double var(--hero-blue);
            padding: 50px;
            position: relative;
            min-height: 780px;
            background: #fff url('https://www.transparenttextures.com/patterns/white-paper.png');
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .corner {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 4px solid var(--hero-orange);
            z-index: 10;
        }
        .top-left { top: -12px; left: -12px; border-right: 0; border-bottom: 0; }
        .top-right { top: -12px; right: -12px; border-left: 0; border-bottom: 0; }
        .bottom-left { bottom: -12px; left: -12px; border-right: 0; border-top: 0; }
        .bottom-right { bottom: -12px; right: -12px; border-left: 0; border-top: 0; }

        .cert-header-font { font-family: 'Cinzel', serif; }
        .cert-script-font { font-family: 'Pinyon Script', cursive; }

        .watermark-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            opacity: 0.04;
            pointer-events: none;
            z-index: 0;
        }

        .verified-seal {
            width: 130px;
            height: 130px;
            background: #fff;
            border: 4px double var(--hero-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 10px 20px rgba(238, 108, 77, 0.1);
        }

        .verified-seal::after {
            content: "VERIFIED CURRICULUM";
            position: absolute;
            font-size: 7px;
            font-weight: 900;
            letter-spacing: 1.5px;
            color: var(--hero-blue);
            width: 100%;
            text-align: center;
            bottom: 22px;
        }

        @media print {
            .no-print { display: none; }
            body { padding: 0; background: #fff; }
            .cert-outer-wrapper { box-shadow: none; border: none; margin: 0; width: 100%; }
            .cert-inner-border { min-height: 95vh; }
        }
    </style>
</head>
<body>

    <div class="cert-outer-wrapper">
        <div class="cert-inner-border">
            <div class="corner top-left"></div>
            <div class="corner top-right"></div>
            <div class="corner bottom-left"></div>
            <div class="corner bottom-right"></div>

            <img src="assets/img/logo.png" class="watermark-bg">

            <div class="relative z-10 h-full flex flex-col justify-between flex-1">
                
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-5">
                        <img src="assets/img/logo.png" class="h-14">
                        <div class="h-10 w-px bg-slate-300"></div>
                        <div class="text-left">
                            <h4 class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 leading-none mb-1">Certificate ID</h4>
                            <p class="text-xs font-bold text-[#1B264F]">HT-CERT-<?= $cert_hash ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">Issued On</p>
                        <p class="text-xs font-bold text-[#1B264F] italic uppercase">
                            <?= date('d M Y', strtotime($data['enrolled_at'])) ?>
                        </p>
                    </div>
                </div>

                <div class="text-center py-6">
                    <h1 class="cert-header-font text-5xl text-[#1B264F] mb-6 tracking-[0.2em] uppercase">Certificate of Achievement</h1>
                    <p class="text-[11px] font-black uppercase tracking-[0.5em] text-[#EE6C4D] mb-10">This technical credential is awarded to</p>
                    
                    <div class="mb-10">
                        <h2 class="cert-script-font text-8xl text-[#1B264F] leading-none py-4"><?= htmlspecialchars($data['student_name']) ?></h2>
                        <div class="w-1/2 h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent mx-auto mt-4"></div>
                    </div>

                    <p class="max-w-2xl mx-auto text-slate-500 text-sm italic mb-8 leading-relaxed font-medium">
                        For successful synchronization with the academic architecture and mastery of technical competencies in the following intelligence track:
                    </p>

                    <div class="inline-block px-12 py-7 bg-slate-50/50 rounded-3xl border border-slate-100 shadow-inner">
                        <h3 class="text-3xl font-black uppercase italic tracking-tighter text-[#1B264F]">
                            <?= htmlspecialchars($data['course_title']) ?>
                        </h3>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#EE6C4D] mt-3">
                            Technical Domain: <?= htmlspecialchars($data['category_name']) ?>
                        </p>
                    </div>
                </div>

                <div class="flex justify-between items-end">
                    <div class="text-center w-64">
                        <div class="cert-script-font text-4xl text-slate-700 mb-0 leading-none">Abhishek Shah</div>
                        <div class="w-full h-px bg-slate-400 mb-3 mt-4"></div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-[#1B264F]">Chief Executive Officer</p>
                        <p class="text-[7px] font-bold text-slate-400 uppercase tracking-tighter">Hero Technology Inc.</p>
                    </div>

                    <div class="verified-seal">
                        <div class="text-center">
                            <i class="fas fa-shield-halved text-4xl text-[#EE6C4D] mb-1"></i>
                            <div class="flex gap-0.5 justify-center">
                                <i class="fas fa-star text-[6px] text-[#EE6C4D]"></i>
                                <i class="fas fa-star text-[6px] text-[#EE6C4D]"></i>
                                <i class="fas fa-star text-[6px] text-[#EE6C4D]"></i>
                            </div>
                        </div>
                    </div>

                    <div class="text-right w-64">
                        <div class="bg-white p-2 border border-slate-200 rounded-xl inline-block mb-3 shadow-sm hover:scale-105 transition-transform">
                            <div class="w-20 h-20 bg-white flex items-center justify-center overflow-hidden">
                                <img src="<?= $qr_api_url ?>" alt="Verification QR" class="w-full h-full object-contain">
                            </div>
                        </div>
                        <p class="text-[7px] font-black uppercase tracking-[0.3em] text-slate-400 mb-2">Scan to Verify Node</p>
                        <p class="text-[9px] font-black uppercase tracking-widest text-[#1B264F] leading-none mb-1">Verified Date</p>
                        <p class="text-xs font-bold text-[#EE6C4D] italic uppercase">
                            <?= date('d M Y', strtotime($data['enrolled_at'])) ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="mt-12 text-center no-print pb-20">
        <button onclick="window.print()" class="px-12 py-5 bg-[#1B264F] text-white rounded-2xl font-black uppercase text-xs tracking-[0.2em] shadow-2xl hover:bg-[#EE6C4D] transition-all hover:-translate-y-1 cursor-pointer">
            <i class="fas fa-print mr-3"></i> Download Certificate
        </button>
        <p class="text-[10px] font-bold text-slate-400 uppercase mt-8 tracking-[0.2em] max-w-lg mx-auto leading-relaxed">
            Note: For high-fidelity output, ensure "Background Graphics" is enabled in your system's print configuration.
        </p>
    </div>

</body>
</html>