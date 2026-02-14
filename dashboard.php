<?php 
include 'header.php'; 

// 1. Session & Identity Verification
if (!isset($_SESSION['email']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$session_id = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['username'];
$safe_id = mysqli_real_escape_string($conn, $session_id);
$resUser = mysqli_query($conn, "SELECT user_id, name, email, username FROM user_master WHERE email='$safe_id' OR username='$safe_id' LIMIT 1");
$user = mysqli_fetch_assoc($resUser);
$user_id = $user['user_id'];

// 2. Fetch Dynamic Analytics
// Count Active Nodes
$active_res = mysqli_query($conn, "SELECT COUNT(*) FROM enrollments WHERE user_id = '$user_id' AND status = 'active'");
$active_count = mysqli_fetch_row($active_res)[0];

// Count Verified Skillset (Completed Nodes)
$skill_res = mysqli_query($conn, "SELECT COUNT(*) FROM enrollments WHERE user_id = '$user_id' AND status = 'completed'");
$skill_count = mysqli_fetch_row($skill_res)[0];

// Logic for Hours Logged (Placeholder logic: 5 hours per active course + 10 per completed)
$hours_logged = ($active_count * 5.5) + ($skill_count * 12.0);

// 3. Fetch Active Learning Nodes
$sqlActive = "
    SELECT e.*, c.title, c.thumbnail, cat.category_name 
    FROM enrollments e
    JOIN courses c ON e.course_id = c.course_id
    JOIN course_category cat ON c.category_id = cat.category_id
    WHERE e.user_id = '$user_id' AND e.status = 'active'
    ORDER BY e.enrolled_at DESC
";
$resActive = mysqli_query($conn, $sqlActive);
?>

<link rel="icon" type="image/x-icon" href="backpanel/assets/img/favicon.ico" />

<div class="min-h-screen bg-[#F8FAFC] flex flex-col lg:flex-row transition-all duration-500">
    
    <aside class="hidden lg:flex w-72 flex-col bg-white border-r border-gray-100 p-8 sticky top-20 h-[calc(100vh-80px)]">
        <div class="mb-10 text-center lg:text-left">
            <img src="backpanel/assets/img/logo.png" class="h-8 mb-6 mx-auto lg:mx-0" alt="Hero Logo">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mb-2">Workspace</p>
            <h3 class="text-xl font-black text-hero-blue italic uppercase">Hero<span class="text-hero-orange not-italic">.Core</span></h3>
        </div>
        
        <nav class="space-y-2">
            <a href="dashboard.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-hero-blue text-white font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-900/20">
                <i class="fas fa-home text-[10px]"></i> Overview
            </a>
            <a href="courses.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl text-gray-400 hover:bg-gray-50 font-black text-xs uppercase tracking-widest transition-all">
                <i class="fas fa-book-open text-[10px]"></i> Academy
            </a>
            <a href="profile.php" class="flex items-center gap-3 px-6 py-4 rounded-2xl text-gray-400 hover:bg-gray-50 font-black text-xs uppercase tracking-widest transition-all">
                <i class="fas fa-user-gear text-[10px]"></i> Settings
            </a>
        </nav>

        <div class="mt-auto p-6 bg-gray-50 rounded-[2rem] border border-gray-100">
            <div class="flex justify-between items-center mb-2">
                <p class="text-[9px] font-black uppercase text-hero-blue tracking-tighter">Pro Node Status</p>
                <img src="backpanel/assets/img/favicon.ico" class="w-3 h-3 opacity-30">
            </div>
            <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-hero-orange w-3/4 shadow-[0_0_8px_#EE6C4D]"></div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-4 sm:p-8 lg:p-12 overflow-y-auto">
        
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-12">
            <div>
                <h1 class="text-3xl font-black text-hero-blue uppercase italic tracking-tighter">System Initialized</h1>
                <p class="text-gray-500 font-medium">Welcome back, <span class="text-hero-orange font-bold"><?php echo explode(' ', $user['name'])[0]; ?></span>. Your learning nodes are active.</p>
            </div>
            <div class="flex items-center gap-4 bg-white p-2 pr-6 rounded-2xl border border-gray-100 shadow-sm">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&background=1B264F&color=fff" class="w-12 h-12 rounded-xl shadow-md">
                <div class="hidden sm:block">
                    <p class="text-[10px] font-black uppercase text-hero-blue leading-none mb-1"><?php echo htmlspecialchars($user['name']); ?></p>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Verified Student</p>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                <p class="text-[9px] font-black uppercase text-gray-400 tracking-widest mb-2">Active Courses</p>
                <h4 class="text-4xl font-black text-hero-blue"><?php echo str_pad($active_count, 2, '0', STR_PAD_LEFT); ?></h4>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                <p class="text-[9px] font-black uppercase text-gray-400 tracking-widest mb-2">Hours Logged</p>
                <h4 class="text-4xl font-black text-hero-orange"><?php echo number_format($hours_logged, 1); ?></h4>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                <p class="text-[9px] font-black uppercase text-gray-400 tracking-widest mb-2">Verified Skillset</p>
                <h4 class="text-4xl font-black text-hero-blue"><?php echo str_pad($skill_count, 2, '0', STR_PAD_LEFT); ?></h4>
            </div>
        </div>

        <div class="space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-sm font-black uppercase tracking-[0.2em] text-gray-400 italic">Current Courses</h3>
                <a href="courses.php" class="text-[10px] font-black text-hero-orange uppercase border-b border-hero-orange pb-0.5">Explore More</a>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <?php if (mysqli_num_rows($resActive) > 0): while($row = mysqli_fetch_assoc($resActive)): ?>
                <div class="bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm flex flex-col sm:flex-row items-center gap-6 group hover:border-hero-blue transition-all relative overflow-hidden">
                    <div class="w-full sm:w-32 h-32 rounded-3xl overflow-hidden shrink-0 border border-gray-50 shadow-inner">
                        <img src="assets/img/courses/<?php echo $row['thumbnail']; ?>" class="w-full h-full object-cover transition-all duration-700">
                    </div>
                    <div class="flex-1 w-full text-center sm:text-left">
                        <span class="text-[9px] font-black text-hero-orange uppercase tracking-widest mb-1 block"><?php echo $row['category_name']; ?></span>
                        <h4 class="text-lg font-black text-hero-blue uppercase italic leading-tight mb-4"><?php echo htmlspecialchars($row['title']); ?></h4>
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-hero-blue w-2/3 group-hover:w-full transition-all duration-1000"></div>
                            </div>
                            <span class="text-[10px] font-black text-gray-400">Node Syncing...</span>
                        </div>
                    </div>
                    <a href="learn.php?id=<?php echo $row['course_id']; ?>" class="w-full sm:w-auto px-8 py-4 bg-hero-blue/5 text-hero-blue rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-hero-blue hover:text-white transition-all shadow-sm">
                        Resume Course
                    </a>
                </div>
                <?php endwhile; else: ?>
                <div class="col-span-full p-20 bg-white rounded-[3rem] border border-dashed border-gray-200 text-center">
                    <i class="fas fa-layer-group text-4xl text-gray-100 mb-6"></i>
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 leading-relaxed">No active courses synchronized.</p>
                    <a href="courses.php" class="inline-block bg-hero-orange text-white px-10 py-4 rounded-xl font-black uppercase text-[10px] shadow-xl shadow-orange-500/20">Initialize First Course</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>