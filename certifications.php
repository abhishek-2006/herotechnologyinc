<?php 
require 'config.php';

// 1. Authentication Check
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = mysqli_real_escape_string($conn, $_SESSION['email']);
$resUser = mysqli_query($conn, "SELECT user_id, name FROM user_master WHERE email='$email' LIMIT 1");
$user = mysqli_fetch_assoc($resUser);
$user_id = $user['user_id'];

// 2. Fetch Completed Nodes (100% Progress)
// Note: Logic assumes a 'status' or 'progress' flag indicates completion
$sqlCerts = "
    SELECT e.*, c.title, c.course_id, cat.category_name 
    FROM enrollments e
    JOIN courses c ON e.course_id = c.course_id
    JOIN course_category cat ON c.category_id = cat.category_id
    WHERE e.user_id = '$user_id' AND e.status = 'completed'
    ORDER BY e.enrolled_at DESC
";
$resCerts = mysqli_query($conn, $sqlCerts);
include 'header.php';
?>

<section class="relative pt-12 pb-20 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-4">
            Credential Terminal
        </span>
        <h1 class="text-4xl md:text-6xl font-black tracking-tighter mb-6 leading-tight text-hero-blue italic uppercase">
            Verified <span class="text-hero-orange not-italic">Certifications.</span>
        </h1>
        <p class="text-base text-gray-500 max-w-2xl mx-auto leading-relaxed px-4 font-medium">
            Your technical achievements are cryptographically secured and mapped to global engineering standards. Initialize download for your verified nodes.
        </p>
    </div>
</section>

<section class="py-16 bg-gray-50 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            if (mysqli_num_rows($resCerts) > 0):
                while($cert = mysqli_fetch_assoc($resCerts)): 
            ?>
            <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden flex flex-col group hover:border-hero-blue transition-all">
                <div class="p-8 pb-0 text-center">
                    <div class="w-20 h-20 bg-hero-blue/5 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-award text-4xl text-hero-orange"></i>
                    </div>
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 block"><?php echo $cert['category_name']; ?></span>
                    <h3 class="text-lg font-black text-hero-blue uppercase italic leading-tight mb-4">
                        <?php echo htmlspecialchars($cert['title']); ?>
                    </h3>
                </div>

                <div class="mt-auto p-8 pt-4">
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[8px] font-black text-gray-400 uppercase">Verification ID</span>
                            <span class="text-[9px] font-mono font-bold text-hero-blue">HT-<?php echo strtoupper(substr(md5($cert['enrollment_id']), 0, 8)); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[8px] font-black text-gray-400 uppercase">Issue Date</span>
                            <span class="text-[9px] font-bold text-gray-900"><?php echo date('M Y'); ?></span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="generate-pdf.php?id=<?php echo $cert['course_id']; ?>" class="w-full bg-hero-blue text-white py-4 rounded-xl font-black uppercase tracking-widest text-[10px] text-center shadow-lg shadow-blue-900/10 hover:bg-hero-orange transition-all active:scale-95">
                            <i class="fas fa-file-pdf mr-2"></i> Download PDF
                        </a>
                        <button onclick="navigator.clipboard.writeText('https://herotechnologyinc.com/verify/HT-<?php echo strtoupper(substr(md5($cert['enrollment_id']), 0, 8)); ?>')" class="w-full bg-white border border-gray-200 text-hero-blue py-4 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-50 transition-all">
                            <i class="fas fa-share-nodes mr-2"></i> Share Node Link
                        </button>
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
            else:
            ?>
            <div class="col-span-full py-20 bg-white rounded-[4rem] border-2 border-dashed border-gray-100 flex flex-col items-center justify-center text-center">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-graduation-cap text-4xl text-gray-200"></i>
                </div>
                <h3 class="text-xl font-black text-hero-blue uppercase italic mb-2">No Verified Credentials</h3>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-8">Complete a curriculum node to 100% to initialize certification.</p>
                <a href="courses.php" class="bg-hero-orange text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-orange-500/20">
                    Explore Academy
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-hero-blue text-white overflow-hidden relative">
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl font-black italic uppercase tracking-tighter mb-6">Institutional <span class="text-hero-orange not-italic">Validation.</span></h2>
        <p class="text-gray-400 text-sm mb-12 leading-relaxed">
            Employers can verify Hero Technology certificates directly through our global staffing mainframe using the unique Node ID found on the credential.
        </p>
        <div class="flex justify-center gap-12 opacity-30">
            <i class="fas fa-shield-check text-6xl"></i>
            <i class="fas fa-microchip text-6xl"></i>
            <i class="fas fa-server text-6xl"></i>
        </div>
    </div>
    <div class="absolute -top-24 -left-24 w-64 h-64 bg-hero-orange/10 rounded-full blur-3xl"></div>
</section>

<?php include 'footer.php'; ?>