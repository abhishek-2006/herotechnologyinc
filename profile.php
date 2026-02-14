<?php 
include 'header.php'; 

// 1. Session & Identity Verification
if (!isset($_SESSION['email']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$session_id = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['username'];
$email = mysqli_real_escape_string($conn, $session_id);

// 2. Fetch User Metadata
$user_res = mysqli_query($conn, "SELECT * FROM user_master WHERE email = '$email' OR username = '$email' LIMIT 1");
$user = mysqli_fetch_assoc($user_res);
$user_id = $user['user_id'];

// 3. Fetch Aggregate Metrics
$enroll_count = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM enrollments WHERE user_id = '$user_id'"))[0];
$cert_count = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM enrollments WHERE user_id = '$user_id' AND status = 'completed'"))[0];

// 4. Check Security Vault Status
$vault_res = mysqli_query($conn, "SELECT COUNT(*) FROM user_security_answers WHERE user_id = '$user_id'");
$is_vault_active = mysqli_fetch_row($vault_res)[0] >= 3;
?>

<style type="text/tailwindcss">
    @theme {
        --color-hero-blue: #1B264F;
        --color-hero-orange: #EE6C4D;
    }
    
    :root {
        --profile-bg: radial-gradient(circle at top, #F8FAFC 0%, #E2E8F0 100%);
        --profile-card: rgba(255, 255, 255, 0.8);
        --profile-border: rgba(27, 38, 79, 0.05);
    }

    .dark {
        --profile-bg: radial-gradient(circle at top, #0F172A 0%, #020617 100%);
        --profile-card: rgba(15, 23, 42, 0.6);
        --profile-border: rgba(255, 255, 255, 0.05);
    }

    body { background: var(--profile-bg); transition: all 0.5s ease; }
    
    .identity-card {
        background: var(--profile-card);
        backdrop-filter: blur(12px);
        border: 1px solid var(--profile-border);
    }
</style>

<main class="min-h-screen pt-20 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.07] pointer-events-none" 
         style="background-image: radial-gradient(var(--color-hero-blue) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="max-w-6xl mx-auto px-4 relative z-10">
        
        <div class="identity-card p-8 rounded-[3rem] mb-12 shadow-2xl flex flex-col md:flex-row items-center gap-8">
            <div class="relative group">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']); ?>&background=1B264F&color=fff&size=200" 
                     class="w-32 h-32 md:w-44 md:h-44 rounded-[3.5rem] shadow-2xl border-4 border-white dark:border-slate-800 transition-transform group-hover:scale-105 duration-500">
                <button class="absolute -bottom-2 -right-2 bg-hero-orange text-white w-12 h-12 rounded-2xl shadow-lg flex items-center justify-center hover:rotate-12 transition-all">
                    <i class="fas fa-fingerprint text-xl"></i>
                </button>
            </div>
            
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                    <h1 class="text-4xl font-black text-hero-blue dark:text-white italic uppercase tracking-tighter">
                        <?= htmlspecialchars($user['name']); ?>
                    </h1>
                    <span class="inline-flex items-center px-4 py-1 bg-emerald-500/10 text-emerald-500 text-[9px] font-black uppercase tracking-widest rounded-full border border-emerald-500/20">
                        <i class="fas fa-circle text-[6px] mr-2 animate-pulse"></i> Engineering Node Active
                    </span>
                </div>
                
                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                    <div class="identity-card px-6 py-4 rounded-2xl text-center min-w-[120px]">
                        <span class="block text-2xl font-black text-hero-blue dark:text-hero-orange"><?= $enroll_count; ?></span>
                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Enrolled Tracks</span>
                    </div>
                    <div class="identity-card px-6 py-4 rounded-2xl text-center min-w-[120px]">
                        <span class="block text-2xl font-black text-hero-orange dark:text-white"><?= $cert_count; ?></span>
                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Certifications</span>
                    </div>
                </div>
            </div>

            <div class="md:border-l border-slate-200 dark:border-slate-800 md:pl-8 flex flex-col items-center">
                <div class="w-16 h-16 rounded-3xl <?= $is_vault_active ? 'bg-emerald-500/20 text-emerald-500' : 'bg-hero-orange/20 text-hero-orange' ?> flex items-center justify-center mb-3">
                    <i class="fas <?= $is_vault_active ? 'fa-shield-check' : 'fa-shield-exclamation animate-pulse' ?> text-2xl"></i>
                </div>
                <p class="text-[9px] font-black uppercase tracking-widest opacity-40">Security Vault</p>
                <p class="text-[10px] font-bold"><?= $is_vault_active ? 'ENCRYPTED' : 'NOT CONFIGURED' ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="space-y-6">
                <div class="identity-card p-8 rounded-[3rem] relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-5">
                        <i class="fas fa-microchip text-6xl text-hero-blue"></i>
                    </div>
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-hero-orange mb-8 flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-hero-orange"></span> Metadata
                    </h3>
                    <div class="space-y-6">
                        <div class="group">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Network Identity</p>
                            <p class="text-sm font-bold text-hero-blue dark:text-white group-hover:text-hero-orange transition-colors">@<?= htmlspecialchars($user['username']); ?></p>
                        </div>
                        <div class="group">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Communication Protocol</p>
                            <p class="text-sm font-bold text-hero-blue dark:text-white group-hover:text-hero-orange transition-colors"><?= htmlspecialchars($user['email']); ?></p>
                        </div>
                        <div class="group">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Registration Hash</p>
                            <p class="text-[10px] font-mono font-bold text-slate-400">HT-NODE-<?= str_pad($user_id, 6, '0', STR_PAD_LEFT); ?></p>
                        </div>
                    </div>
                </div>

                <a href="security-questions.php" class="block bg-hero-blue p-8 rounded-[3rem] text-center hover:scale-[1.02] transition-transform group">
                    <i class="fas fa-key-skeleton text-white/20 text-4xl mb-4 group-hover:text-hero-orange transition-colors"></i>
                    <p class="text-white text-[10px] font-black uppercase tracking-[0.3em]">Update Security Questions</p>
                </a>
            </div>

            <div class="lg:col-span-2">
                <div class="identity-card p-8 md:p-12 rounded-[3.5rem] shadow-xl">
                    <div class="flex items-center justify-between mb-10">
                        <h3 class="text-xl font-black uppercase tracking-tight text-hero-blue dark:text-white italic">Update <span class="text-hero-orange not-italic">Identity Node</span></h3>
                        <i class="fas fa-sliders text-hero-orange opacity-20 text-2xl"></i>
                    </div>
                    
                    <form action="process/update-profile.php" method="POST" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Display Name</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-5 top-1/2 -translate-y-1/2 text-hero-orange/40 text-xs"></i>
                                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" 
                                           class="w-full pl-12 pr-6 py-4 bg-slate-500/5 border border-slate-500/10 rounded-2xl outline-none focus:ring-2 focus:ring-hero-orange/20 text-sm font-bold text-hero-blue dark:text-white">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Phone Link</label>
                                <div class="relative">
                                    <i class="fas fa-phone absolute left-5 top-1/2 -translate-y-1/2 text-hero-orange/40 text-xs"></i>
                                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" 
                                           class="w-full pl-12 pr-6 py-4 bg-slate-500/5 border border-slate-500/10 rounded-2xl outline-none focus:ring-2 focus:ring-hero-orange/20 text-sm font-bold text-hero-blue dark:text-white">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-black uppercase tracking-widest text-slate-400 ml-2">Access Key Overwrite (Password)</label>
                            <div class="relative">
                                <i class="fas fa-lock-open absolute left-5 top-1/2 -translate-y-1/2 text-hero-orange/40 text-xs"></i>
                                <input type="password" name="password" placeholder="LEAVE BLANK TO RETAIN CURRENT HASH" 
                                    class="w-full pl-12 pr-6 py-4 bg-slate-500/5 border border-slate-500/10 rounded-2xl outline-none focus:ring-2 focus:ring-hero-orange/20 text-sm font-bold text-hero-blue dark:text-white placeholder:text-[9px] placeholder:tracking-widest">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full md:w-auto bg-hero-blue dark:bg-hero-orange text-white px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-[11px] shadow-2xl hover:scale-[1.05] active:scale-95 transition-all">
                                Update Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>