<?php 
include 'header.php';

$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// Enhanced Query to fetch more intelligence
$query = "SELECT c.*, cat.category_name, u.name as instructor_name, u.email as instructor_email 
          FROM courses c 
          JOIN course_category cat ON c.category_id = cat.category_id 
          JOIN user_master u ON c.instructor_id = u.user_id 
          WHERE c.course_id = '$course_id' AND c.status = 'publish' 
          LIMIT 1";
$result = mysqli_query($conn, $query);
$course = mysqli_fetch_assoc($result);

if (!$course) {
    header("Location: courses.php");
    exit();
}

$isEnrolled = false;
if (isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
    $check = mysqli_query($conn, "SELECT status FROM enrollments WHERE user_id = '$u_id' AND course_id = '$course_id'");
    $isEnrolled = mysqli_num_rows($check) > 0;
}
?>

<main class="bg-[#F8FAFC] min-h-screen pb-20">
    <section class="bg-hero-blue text-white pt-20 pb-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 items-start">
                
                <div class="lg:w-2/3">
                    <span class="inline-block px-4 py-1 bg-white/10 backdrop-blur rounded-full text-[10px] font-black uppercase tracking-[0.3em] mb-6">
                        <?php echo $course['category_name']; ?>
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter leading-tight mb-6">
                        <?php echo htmlspecialchars($course['title']); ?>
                    </h1>
                    <div class="flex flex-wrap items-center gap-6 opacity-80">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user-circle text-hero-orange"></i>
                            <span class="text-xs font-bold uppercase tracking-widest"><?php echo htmlspecialchars($course['instructor_name']); ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-layer-group text-hero-orange"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">12+ Modules</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-shield-alt text-hero-orange"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">Verified Curriculum</span>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/3 w-full lg:relative lg:right-4 z-25">
                    <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden">
                        <div class="h-75 relative overflow-hidden rounded-t-[3rem]">
                            <img src="assets/img/courses/<?php echo $course['thumbnail']; ?>" 
                                class="w-full h-full object-fill transition-all duration-500 hover:scale-110">
                        </div>
                        <div class="p-8">
                            <div class="flex items-end gap-2 mb-6">
                                <span class="text-3xl font-black text-hero-blue">₹<?php echo number_format($course['price'], 0); ?></span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase mb-1">Full Access</span>
                            </div>
                            
                            <div class="flex flex-col gap-3">
                                <?php if($isEnrolled): ?>
                                    <a href="learn.php?id=<?php echo $course['course_id']; ?>" 
                                       class="block w-full text-center bg-emerald-500 text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-emerald-500/20 hover:scale-[1.02] transition-all">
                                        Continue Learning
                                    </a>
                                <?php else: ?>
                                    <a href="process/enroll.php?id=<?php echo $course['course_id']; ?>" 
                                    class="block w-full text-center bg-hero-blue text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-blue-900/20 hover:scale-[1.02] transition-all">
                                        Enroll Now
                                    </a>
                                <?php endif; ?>

                                <a href="demo-lecture.php?id=<?php echo $course['course_id']; ?>" 
                                   class="block w-full text-center border-2 border-hero-orange text-hero-orange py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-hero-orange hover:text-white transition-all">
                                    Request Demo
                                </a>
                            </div>
                            
                            <div class="mt-8 space-y-4">
                                <div class="flex items-center gap-3 text-gray-500 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fas fa-infinity text-hero-blue"></i> Lifetime Access
                                </div>
                                <div class="flex items-center gap-3 text-gray-500 text-[10px] font-black uppercase tracking-widest">
                                    <i class="fas fa-certificate text-hero-blue"></i> Verified Certification
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="assets/img/logo.png" class="absolute -right-20 -bottom-20 h-96 opacity-5 brightness-0 invert pointer-events-none">
    </section>

    <section class="max-w-7xl mx-auto px-4 mt-20">
        <div class="flex flex-col lg:flex-row gap-16">
            <div class="lg:w-2/3">
                <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue mb-8 border-l-4 border-hero-orange pl-4">Intellectual Objectives</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-16">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-hero-orange mt-1"></i>
                        <p class="text-sm font-medium text-gray-600">Master core industrial concepts through hands-on nodes.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-hero-orange mt-1"></i>
                        <p class="text-sm font-medium text-gray-600">Deploy scalable solutions using verified stacks.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-hero-orange mt-1"></i>
                        <p class="text-sm font-medium text-gray-600">Obtain verified certification upon node completion.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-hero-orange mt-1"></i>
                        <p class="text-sm font-medium text-gray-600">Access exclusive Hero community resource nodes.</p>
                    </div>
                </div>

                <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue mb-8 border-l-4 border-hero-orange pl-4">Node Intelligence</h2>
                <div class="prose prose-slate max-w-none text-gray-600 leading-relaxed font-medium mb-16">
                    <?php echo nl2br(htmlspecialchars($course['description'])); ?>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
                        <i class="fas fa-clock text-hero-orange mb-3"></i>
                        <h4 class="text-[10px] font-black uppercase text-hero-blue">Duration</h4>
                        <p class="text-xs font-bold text-gray-400 uppercase">24.5 Hours</p>
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
                        <i class="fas fa-file-code text-hero-orange mb-3"></i>
                        <h4 class="text-[10px] font-black uppercase text-hero-blue">Resources</h4>
                        <p class="text-xs font-bold text-gray-400 uppercase">45 Downloads</p>
                    </div>
                    <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
                        <i class="fas fa-language text-hero-orange mb-3"></i>
                        <h4 class="text-[10px] font-black uppercase text-hero-blue">Language</h4>
                        <p class="text-xs font-bold text-gray-400 uppercase">English (US)</p>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="sticky top-24 space-y-6">
                    <div class="bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm">
                        <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue mb-6">Prerequisites</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                <div class="w-1.5 h-1.5 rounded-full bg-hero-orange"></div> Basic Logic Nodes
                            </li>
                            <li class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                <div class="w-1.5 h-1.5 rounded-full bg-hero-orange"></div> System Access
                            </li>
                        </ul>
                    </div>

                    <div class="bg-hero-blue p-8 rounded-[3rem] text-white">
                        <h3 class="text-xs font-black uppercase tracking-widest mb-4">Instructor Node</h3>
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($course['instructor_name']); ?>&background=EE6C4D&color=fff" class="w-12 h-12 rounded-2xl shadow-lg">
                            <div>
                                <p class="text-xs font-black uppercase"><?php echo $course['instructor_name']; ?></p>
                                <p class="text-[9px] font-bold opacity-60 uppercase">Senior Architect</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    $sqlReviews = "SELECT r.*, u.name 
                   FROM course_reviews r 
                   JOIN user_master u ON r.user_id = u.user_id 
                   WHERE r.course_id = '$course_id' 
                   ORDER BY r.review_id DESC";
    $resReviews = mysqli_query($conn, $sqlReviews);
    $reviewCount = mysqli_num_rows($resReviews);
    ?>

    <section class="max-w-7xl mx-auto px-4 mt-24 mb-20">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 gap-4">
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue italic mb-2">Technical Validation</h2>
                <h3 class="text-3xl font-black italic uppercase tracking-tighter text-slate-800">Alumni <span class="text-hero-orange not-italic">Feedback</span></h3>
            </div>
            <div class="flex items-center gap-2 bg-white px-5 py-3 rounded-2xl border border-gray-100 shadow-sm">
                <span class="text-hero-orange font-black text-xl"><?php echo $course['rating'] ?? '4.8'; ?></span>
                <div class="flex text-hero-orange text-[10px] gap-0.5">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest ml-2">(<?php echo $reviewCount; ?> Reviews)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ($reviewCount > 0): ?>
                <?php while($rev = mysqli_fetch_assoc($resReviews)): ?>
                <div class="bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm flex flex-col hover:border-hero-orange transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex text-hero-orange text-[8px] gap-0.5">
                            <?php for($i=0; $i<$rev['rating']; $i++): ?>
                                <i class="fas fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <img src="assets/img/favicon.ico" class="w-4 h-4 opacity-20 group-hover:opacity-100 transition-opacity" alt="Verified">
                    </div>
                    <p class="text-gray-500 italic text-sm leading-relaxed mb-8 flex-1 font-medium">
                        "<?php echo htmlspecialchars($rev['review']); ?>"
                    </p>
                    <div class="flex items-center gap-4 pt-6 border-t border-gray-50">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($rev['name']); ?>&background=1B264F&color=fff" class="w-10 h-10 rounded-xl shadow-md">
                        <div>
                            <p class="text-[11px] font-black uppercase tracking-tight text-hero-blue"><?php echo htmlspecialchars($rev['name']); ?></p>
                            <p class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Verified Alumni</p>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full py-16 bg-white rounded-[3rem] border border-dashed border-gray-200 text-center">
                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Feedback nodes are currently synchronizing...</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-20 pt-10 border-t border-gray-100 flex justify-center">
            <img src="assets/img/logo.png" class="h-8 opacity-20" alt="Hero Tech">
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>