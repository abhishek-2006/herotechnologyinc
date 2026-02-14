<?php 
include 'header.php'; 

// 1. Session & Identity Verification
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = mysqli_real_escape_string($conn, $_SESSION['email']);

// 2. Fetch User Metadata
$user_res = mysqli_query($conn, "SELECT * FROM user_master WHERE email = '$email' LIMIT 1");
$user = mysqli_fetch_assoc($user_res);
$user_id = $user['user_id'];

// 3. Fetch Aggregate Metrics (Dynamic)
$enroll_count = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM enrollments WHERE user_id = '$user_id'"))[0];
$cert_count = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM enrollments WHERE user_id = '$user_id' AND status = 'completed'"))[0];

?>

<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />

<main class="bg-[#F8FAFC] min-h-screen pt-12 pb-20">
    <div class="max-w-5xl mx-auto px-4">
        
        <div class="flex flex-col md:flex-row items-center gap-8 mb-12">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&background=1B264F&color=fff&size=200" 
                     class="w-32 h-32 md:w-40 md:h-40 rounded-[3rem] shadow-2xl border-4 border-white" alt="Profile">
                <div class="absolute -bottom-2 -right-2 bg-hero-orange text-white p-3 rounded-2xl shadow-lg">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-4xl font-black text-hero-blue italic uppercase tracking-tighter">
                    <?php echo htmlspecialchars($user['name']); ?>
                </h1>
                <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px] mt-1">
                    Student ID: #HT-<?php echo $user_id; ?> | Node Active
                </p>
                
                <div class="flex gap-4 mt-6 justify-center md:justify-start">
                    <div class="bg-white px-6 py-3 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <span class="block text-xl font-black text-hero-blue"><?php echo $enroll_count; ?></span>
                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Enrolled</span>
                    </div>
                    <div class="bg-white px-6 py-3 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <span class="block text-xl font-black text-hero-orange"><?php echo $cert_count; ?></span>
                        <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Certificates</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue mb-6 border-l-4 border-hero-orange pl-4">Account Specs</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Username</p>
                            <p class="text-sm font-bold text-hero-blue">@<?php echo htmlspecialchars($user['username']); ?></p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase mb-1">Email</p>
                            <p class="text-sm font-bold text-hero-blue"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-hero-blue p-8 rounded-[3rem] text-center relative overflow-hidden group">
                    <img src="assets/img/logo.png" class="h-8 mx-auto mb-4 brightness-0 invert opacity-80" alt="Logo">
                    <p class="text-white text-[9px] font-black uppercase tracking-[0.2em] relative z-10">Verified Hero Technologist</p>
                    <div class="absolute inset-0 bg-hero-orange translate-y-full group-hover:translate-y-0 transition-transform duration-500 opacity-10"></div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white p-8 md:p-12 rounded-[3.5rem] border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue mb-8 italic">Update Identity Node</h3>
                    
                    <form action="process/update-profile.php" method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 ml-2">Full Name</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:border-hero-orange transition-all text-sm font-bold text-hero-blue">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 ml-2">Security Update (New Password)</label>
                            <input type="password" name="password" placeholder="Leave blank to maintain current password" class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl outline-none focus:border-hero-orange transition-all text-sm font-bold text-hero-blue">
                        </div>

                        <button type="submit" class="bg-hero-blue text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-blue-900/20 hover:bg-hero-orange transition-all active:scale-[0.98]">
                            Synchronize Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>