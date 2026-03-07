<?php
require '../config.php';

// Intelligence Check: Redirect if session is missing
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?id=" . ($_GET['id'] ?? ''));
    exit();
}

$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;
$course_query = "SELECT * FROM courses WHERE course_id = '$course_id' AND status = 'publish' LIMIT 1";
$course = mysqli_fetch_assoc(mysqli_query($conn, $course_query));

if (!$course) { header("Location: ../courses.php"); exit(); }
?>
<!DOCTYPE html>     
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorize Access | Hero Tech</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
        }
        :root {
            --bg: radial-gradient(circle at 50% 0%, #F8FAFC, #E2E8F0);
            --card: rgba(255, 255, 255, 0.8);
            --text: #1B264F;
            --border-node: rgba(27, 38, 79, 0.05);
        }
        .dark {
            --bg: radial-gradient(circle at 50% 0%, #0F172A, #020617);
            --card: rgba(15, 23, 42, 0.7);
            --text: #F8FAFC;
            --border-node: rgba(255, 255, 255, 0.05);
        }
        body { background: var(--bg); color: var(--text); overflow-x: hidden; }
        .glass { backdrop-filter: blur(25px); border: 1px solid var(--border-node); }
        
        @keyframes scan {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }
        .scan-line {
            background: linear-gradient(to bottom, transparent, var(--color-hero-orange), transparent);
            height: 100px;
            width: 100%;
            position: absolute;
            opacity: 0.1;
            animation: scan 4s linear infinite;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-6 transition-colors duration-500">

    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-hero-orange to-transparent opacity-50"></div>

    <div class="max-w-xl w-full relative">
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-hero-blue/10 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-hero-orange/10 blur-[120px] rounded-full"></div>

        <div class="flex justify-center mb-10 animate__animated animate__fadeInDown">
            <div class="w-25 h-15 rounded-2xl bg-white/5 border border-white/10 p-2 flex items-center justify-center glass overflow-hidden">
                <img src="../assets/img/logo.png" class="h-8 dark:invert opacity-90" alt="Hero Tech">
            </div>
        </div>

        <div class="glass bg-[var(--card)] rounded-[4rem] p-10 sm:p-14 shadow-2xl relative overflow-hidden animate__animated animate__zoomIn">
            <div class="scan-line"></div>

            <header class="text-center mb-12 relative z-10">
                <span class="text-[10px] font-black uppercase tracking-[0.6em] text-hero-orange mb-3 block animate__animated animate__fadeIn animate__delay-1s">Security Handshake</span>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic leading-none">
                    Initialize <span class="text-hero-orange not-italic">Billing</span>
                </h1>
            </header>

            <div class="bg-black/5 dark:bg-white/5 rounded-[2.5rem] p-8 mb-10 border border-white/5 relative z-10 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="flex justify-between items-start mb-6">
                    <div class="max-w-[70%]">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Target Node</p>
                        <h3 class="text-xl font-black uppercase tracking-tight leading-tight"><?= htmlspecialchars($course['title']) ?></h3>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Protocol</p>
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter"><i class="fas fa-lock-open mr-1"></i> Full Access</span>
                    </div>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-[10px] font-bold uppercase text-slate-400">
                        <span>Node Enrollment Fee</span>
                        <span class="mono">₹<?= number_format($course['price'], 2) ?></span>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold uppercase text-slate-400">
                        <span>Platform Access</span>
                        <span class="text-emerald-500">GRATIS</span>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 dark:border-white/10 flex justify-between items-baseline">
                    <span class="text-[11px] font-black uppercase text-hero-blue dark:text-slate-400 italic">Deployment Cost</span>
                    <span class="text-4xl font-black italic tracking-tighter">₹<?= number_format($course['price'], 2) ?></span>
                </div>
            </div>

            <button id="pay-button" class="group relative z-10 w-full bg-hero-orange text-white py-6 rounded-3xl font-black uppercase tracking-[0.2em] text-[11px] shadow-2xl shadow-hero-orange/30 hover:scale-[1.02] active:scale-95 transition-all cursor-pointer overflow-hidden animate__animated animate__fadeInUp animate__delay-1s">
                <span class="relative z-10 flex items-center justify-center gap-3">
                    Transmit Secure Payment
                    <i class="fas fa-bolt text-[10px] group-hover:animate-pulse"></i>
                </span>
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
            </button>

            <footer class="mt-10 flex flex-wrap items-center justify-center gap-6 opacity-40 animate__animated animate__fadeIn animate__delay-2s">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shield-halved text-xs text-hero-blue dark:text-white"></i>
                    <span class="text-[8px] font-black uppercase tracking-widest">SHA-512 Encrypted</span>
                </div>
                <div class="w-1 h-1 bg-slate-500 rounded-full"></div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-server text-xs text-hero-blue dark:text-white"></i>
                    <span class="text-[8px] font-black uppercase tracking-widest">Verified PayU Gateway</span>
                </div>
            </footer>
        </div>
        
        <div class="mt-8 text-center animate__animated animate__fadeIn animate__delay-2s">
            <a href="../course-details.php?id=<?= $course_id ?>" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-hero-orange transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Return to Curriculum details
            </a>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').addEventListener('click', async function() {
            const btn = this;
            const originalContent = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-sync fa-spin mr-2"></i> ESTABLISHING SECURE HANDSHAKE...';
            btn.style.pointerEvents = 'none';
            btn.style.opacity = '0.8';

            try {
                // Pointing to your PayU order creation script
                const response = await fetch('create_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ course_id: '<?= $course_id ?>' })
                });

                const data = await response.json();

                if (data.params && data.url) {
                    // Create a high-fidelity hidden form to POST to PayUMoney Mainframe
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = data.url;

                    for (const key in data.params) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = data.params[key];
                        form.appendChild(input);
                    }

                    document.body.appendChild(form);
                    
                    // Subtle delay for visual confirmation of "handshake"
                    setTimeout(() => form.submit(), 800);
                } else {
                    throw new Error(data.message || "HANDSHAKE_TIMEOUT");
                }
            } catch (error) {
                console.error("GATEWAY_NODE_ERROR:", error);
                btn.innerHTML = '<i class="fas fa-triangle-exclamation mr-2"></i> NODE FAILURE. RETRY?';
                btn.style.backgroundColor = '#ef4444';
                btn.style.pointerEvents = 'all';
                btn.style.opacity = '1';
                
                // Reset after 3 seconds
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.style.backgroundColor = '';
                }, 3000);
            }
        });

        // Theme protocol sync
        if(localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>