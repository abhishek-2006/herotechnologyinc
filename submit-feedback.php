<?php 
require 'config.php'; 

// 1. Session and Security Check
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];
$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// 2. Fetch User Identity
$user_res = mysqli_query($conn, "SELECT user_id, name FROM user_master WHERE email = '$user_email' LIMIT 1");
$user = mysqli_fetch_assoc($user_res);
$user_id = $user['user_id'];

// 3. Verification: Only allow feedback if course status is 'completed'
$check_completion = mysqli_query($conn, "SELECT enrollment_id FROM enrollments WHERE user_id = '$user_id' AND course_id = '$course_id' AND status = 'completed'");

if (mysqli_num_rows($check_completion) == 0) {
    // If not completed, redirect to dashboard with alert
    header("Location: dashboard.php?error=node_not_validated");
    exit();
}

// 4. Fetch Course Details for Context
$course_res = mysqli_query($conn, "SELECT title FROM courses WHERE course_id = '$course_id'");
$course = mysqli_fetch_assoc($course_res);

include 'header.php'; 
?>

<main class="bg-[#F8FAFC] min-h-screen pt-12 pb-20">
    <div class="max-w-2xl mx-auto px-4">
        
        <div class="text-center mb-10">
            <img src="backpanel/assets/img/logo.png" class="h-10 mx-auto mb-6" alt="Hero Tech Logo">
            <h1 class="text-3xl font-black italic uppercase tracking-tighter text-hero-blue">
                Node <span class="text-hero-orange not-italic">Validation</span>
            </h1>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.3em] mt-2">Submit Alumni Dispatch</p>
        </div>

        <div class="bg-white rounded-[3rem] p-8 md:p-12 shadow-[0_40px_100px_-20px_rgba(27,38,79,0.1)] border border-gray-100">
            <form action="process-feedback.php" method="POST" class="space-y-8">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                
                <div class="bg-slate-50 p-6 rounded-2xl border border-gray-100 flex items-center gap-4">
                    <img src="backpanel/assets/img/favicon.ico" class="w-6 h-6" alt="Favicon">
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Synchronizing Feedback For:</p>
                        <h2 class="text-sm font-black text-hero-blue uppercase italic"><?php echo htmlspecialchars($course['title']); ?></h2>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 ml-2">Rate Your Intelligence Node</label>
                    <div class="flex gap-4">
                        <?php for($i=1; $i<=5; $i++): ?>
                        <label class="flex-1 cursor-pointer group">
                            <input type="radio" name="rating" value="<?php echo $i; ?>" class="hidden peer" required>
                            <div class="py-4 text-center rounded-2xl border-2 border-slate-50 text-slate-300 transition-all peer-checked:border-hero-orange peer-checked:text-hero-orange peer-checked:bg-orange-50 group-hover:bg-slate-50">
                                <i class="fas fa-star text-lg"></i>
                                <span class="block text-[10px] font-black mt-1"><?php echo $i; ?></span>
                            </div>
                        </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 ml-2">Detailed Alumni Dispatch</label>
                    <textarea name="review" rows="5" required placeholder="Describe the technical impact of this curriculum on your engineering workflow..." 
                              class="w-full p-6 bg-slate-50 border-2 border-slate-50 rounded-3xl outline-none focus:border-hero-blue transition-all text-sm font-medium placeholder:text-slate-300"></textarea>
                </div>

                <button type="submit" class="w-full py-5 bg-hero-blue text-white rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all active:scale-[0.98]">
                    Transmit Feedback Node
                </button>
            </form>
        </div>

        <p class="mt-12 text-center text-[9px] font-bold text-gray-300 uppercase tracking-[0.4em]">
            &copy; 2026 Hero Technology Inc. Verified Alumni Network
        </p>
    </div>
</main>

<?php include 'footer.php'; ?>