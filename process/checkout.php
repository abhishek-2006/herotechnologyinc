<?php
require '../config.php';

// Intelligence Check: Redirect if session is missing
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?id=" . $_GET['id']);
    exit();
}

$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;
$course = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE course_id = '$course_id' LIMIT 1"));

if (!$course) { header("Location: courses.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Authorize Access | Hero Tech</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
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
        }
        .dark {
            --bg: radial-gradient(circle at 50% 0%, #0F172A, #020617);
            --card: rgba(15, 23, 42, 0.7);
            --text: #F8FAFC;
        }
        body { background: var(--bg); color: var(--text); }
        .glass { backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-6">

    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-hero-orange to-transparent opacity-50"></div>

    <div class="max-w-xl w-full">
        <div class="flex justify-center mb-10">
            <div class="w-25 h-15 rounded-lg bg-white p-1 flex items-center justify-center overflow-hidden">
                <img src="../assets/img/logo.png" class="h-8 dark:invert opacity-80" alt="Hero Technology">
            </div>
        </div>

        <div class="glass bg-[var(--card)] rounded-[4rem] p-12 shadow-2xl relative">
            <div class="absolute -top-6 -right-6 w-24 h-24 bg-hero-orange/10 blur-3xl rounded-full"></div>

            <header class="text-center mb-12">
                <span class="text-[10px] font-black uppercase tracking-[0.6em] text-hero-orange mb-3 block">Authorization Node</span>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic leading-none">
                    Confirm <span class="text-hero-orange not-italic">Enrollment</span>
                </h1>
            </header>

            <div class="bg-black/5 dark:bg-white/5 rounded-[2.5rem] p-8 mb-10 border border-white/5">
                <div class="flex justify-between items-start mb-6">
                    <div class="max-w-[70%]">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Course Name</p>
                        <h3 class="text-xl font-black uppercase tracking-tight"><?= htmlspecialchars($course['title']) ?></h3>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Access</p>
                        <span class="text-[10px] font-black text-emerald-500 uppercase">Lifetime</span>
                    </div>
                </div>
                
                <div class="pt-6 border-t border-white/5 flex justify-between items-baseline">
                    <span class="text-[10px] font-black uppercase text-slate-500">Total Investment</span>
                    <span class="text-4xl font-black italic">₹<?= number_format($course['price'], 2) ?></span>
                </div>
            </div>

            <button id="pay-button" class="group relative w-full bg-hero-orange text-white py-6 rounded-3xl font-black uppercase tracking-[0.2em] text-[11px] shadow-2xl shadow-hero-orange/20 hover:scale-[1.02] active:scale-95 transition-all cursor-pointer overflow-hidden">
                <span class="relative z-10 flex items-center justify-center gap-3">
                    Execute Secure Payment
                    <i class="fas fa-chevron-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                </span>
                <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform"></div>
            </button>

            <footer class="mt-8 flex items-center justify-center gap-6 opacity-30">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shield-halved text-xs"></i>
                    <span class="text-[8px] font-black uppercase tracking-widest">SSL 256-bit</span>
                </div>
                <div class="w-1 h-1 bg-slate-500 rounded-full"></div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-bolt text-xs"></i>
                    <span class="text-[8px] font-black uppercase tracking-widest">Instant Activation</span>
                </div>
            </footer>
        </div>
        
        <p class="text-center mt-8 text-[9px] font-bold text-slate-500 uppercase tracking-[0.3em]">
            Powered by <span class="text-white/60">Cashfree Payments</span>
        </p>
    </div>

    <script>
        const cashfree = Cashfree({ mode: "sandbox" });

        document.getElementById('pay-button').addEventListener('click', async function() {
            const btn = this;
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> INITIALIZING NODE...';
            btn.style.pointerEvents = 'none';

            try {
                const response = await fetch('create_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ course_id: '<?= $course_id ?>' })
                });

                const session = await response.json();

                if (session.payment_session_id) {
                    cashfree.checkout({
                        paymentSessionId: session.payment_session_id,
                        redirectTarget: "_self" 
                    });
                } else {
                    throw new Error("Invalid Session");
                }
            } catch (error) {
                console.error(error);
                btn.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i> ERROR. RETRY?';
                btn.style.backgroundColor = '#ef4444';
                btn.style.pointerEvents = 'all';
            }
        });

        // Theme sync
        if(localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</body>
</html>