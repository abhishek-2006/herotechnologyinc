<?php 
include 'header.php';

$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// Dynamic Query: Pulling all relevant course data including metadata
$query = "SELECT c.*, cat.category_name, i.name as instructor_name, i.email as instructor_email, i.profile_image as instructor_img
          FROM courses c 
          JOIN course_category cat ON c.category_id = cat.category_id 
          JOIN instructors i ON c.instructor_id = i.instructor_id 
          WHERE c.course_id = '$course_id' AND c.status = 'publish' 
          LIMIT 1";
$result = mysqli_query($conn, $query);
$course = mysqli_fetch_assoc($result);

if (!$course) {
    header("Location: courses.php");
    exit();
}

// Check Enrollment Status
$isEnrolled = false;
if (isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
    $check = mysqli_query($conn, "SELECT 1 FROM enrollments WHERE user_id = '$u_id' AND course_id = '$course_id' AND status = 'active' LIMIT 1");
    $isEnrolled = mysqli_num_rows($check) > 0;
}

// Logic for Dynamic Favicon
$favicon = file_exists('assets/img/favicon.ico') ? 'assets/img/favicon.ico' : 'assets/img/logo.png';
?>

<script>
    document.title = "<?php echo htmlspecialchars($course['title']); ?> | Hero Technology Inc.";
</script>

<section class="bg-hero-blue dark:bg-slate-950 text-white pt-20 pb-32 relative overflow-hidden transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row gap-12 items-start">
            
            <div class="lg:w-2/3 animate__animated animate__fadeInLeft">
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
                        <i class="fas fa-clock text-hero-orange"></i>
                        <span class="text-xs font-bold uppercase tracking-widest">
                            <?php 
                                $minutes = $course['duration'] ?? 0;
                                $hours = $minutes / 60;
                                echo htmlspecialchars(number_format($hours, 2)) . ' Hrs';
                            ?>
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shield-alt text-hero-orange"></i>
                        <span class="text-xs font-bold uppercase tracking-widest">Verified Curriculum</span>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/3 w-full lg:relative lg:right-4 z-25 animate__animated animate__zoomIn">
                <div class="bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-gray-100 dark:border-slate-800 overflow-hidden">
                    <div class="h-64 relative overflow-hidden">
                        <img src="assets/img/courses/<?php echo $course['thumbnail']; ?>" 
                             class="w-full h-full object-cover transition-all duration-500 hover:scale-110">
                    </div>
                    <div class="p-8">
                        <div class="flex items-end gap-2 mb-6">
                            <span class="text-3xl font-black text-hero-blue dark:text-white">₹<?php echo number_format($course['price'], 0); ?></span>
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
                                   class="block w-full text-center bg-hero-orange text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs shadow-xl shadow-orange-500/20 hover:scale-[1.02] transition-all">
                                   Enroll Now
                                </a>
                            <?php endif; ?>

                            <a href="demo-lecture.php?id=<?php echo $course['course_id']; ?>" 
                               class="block w-full text-center border-2 border-hero-blue dark:border-white/20 text-hero-blue dark:text-white py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-hero-blue hover:text-white transition-all">
                                Watch Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if(file_exists('assets/img/logo.png')): ?>
        <img src="assets/img/logo.png" class="absolute -right-20 -bottom-20 h-96 opacity-5 brightness-0 invert pointer-events-none">
    <?php endif; ?>
</section>

<section class="max-w-7xl mx-auto px-4 mt-20 dark:bg-[#020617]">
    <div class="flex flex-col lg:flex-row gap-16">
        <div class="lg:w-2/3">
            <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue dark:text-hero-orange mb-8 border-l-4 border-hero-orange pl-4">Course Objectives</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-16">
                <?php 
                // Assumes objectives are stored as a comma-separated string or JSON in DB
                $obj_data = $course['objectives'] ?? "Master core concepts,Deploy scalable solutions,Get certified,Community access";
                $objectives = explode(',', $obj_data);
                foreach($objectives as $obj): 
                ?>
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-hero-orange mt-1"></i>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400"><?= trim($obj) ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue dark:text-hero-orange mb-8 border-l-4 border-hero-orange pl-4">About this Node</h2>
            <div class="prose prose-slate dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 leading-relaxed font-medium mb-16">
                <?php echo $course['description']; ?>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
                    <i class="fas fa-file-video text-hero-orange mb-3"></i>
                    <h4 class="text-[10px] font-black uppercase text-hero-blue dark:text-white">Content</h4>
                    <p class="text-xs font-bold text-gray-400 uppercase"><?php echo $course['total_lessons'] ?? '0'; ?> Lessons</p>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
                    <i class="fas fa-globe text-hero-orange mb-3"></i>
                    <h4 class="text-[10px] font-black uppercase text-hero-blue dark:text-white">Language</h4>
                    <p class="text-xs font-bold text-gray-400 uppercase"><?php echo $course['language'] ?? 'English'; ?></p>
                </div>
                <div class="bg-white dark:bg-slate-900 p-6 rounded-[2rem] border border-gray-100 dark:border-slate-800 shadow-sm">
                    <i class="fas fa-certificate text-hero-orange mb-3"></i>
                    <h4 class="text-[10px] font-black uppercase text-hero-blue dark:text-white">Certification</h4>
                    <p class="text-xs font-bold text-gray-400 uppercase">Verified</p>
                </div>
            </div>
        </div>

        <div class="lg:w-1/3">
            <div class="sticky top-24 space-y-6">
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[3rem] border border-gray-100 dark:border-slate-800 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white mb-6">Prerequisites</h3>
                    <ul class="space-y-4">
                        <?php 
                        $pre_data = $course['prerequisites'] ?? "Basic Programming, Internet Connection";
                        $pre_reqs = explode(',', $pre_data);
                        foreach($pre_reqs as $pre): 
                        ?>
                        <li class="flex items-center gap-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            <div class="w-1.5 h-1.5 rounded-full bg-hero-orange"></div> <?php echo trim($pre); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="bg-hero-blue dark:bg-slate-800 p-8 rounded-[3rem] text-white">
                    <h3 class="text-xs font-black uppercase tracking-widest mb-4">Instructor Node</h3>
                    <div class="flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($course['instructor_name']); ?>&background=EE6C4D&color=fff" class="w-12 h-12 rounded-2xl shadow-lg">
                        <div>
                            <p class="text-xs font-black uppercase"><?php echo $course['instructor_name']; ?></p>
                            <p class="text-[9px] font-bold opacity-60 uppercase">Subject Matter Expert</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 mt-24 mb-20">
    <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-4">
        <div>
            <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue italic mb-2">Technical Validation</h2>
            <h3 class="text-3xl font-black italic uppercase tracking-tighter text-slate-800 dark:text-white">Alumni Feedback</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php 
        $resReviews = mysqli_query($conn, "SELECT r.*, u.name FROM course_reviews r JOIN user_master u ON r.user_id = u.user_id WHERE r.course_id = '$course_id' ORDER BY r.review_id DESC");
        if (mysqli_num_rows($resReviews) > 0): 
            while($rev = mysqli_fetch_assoc($resReviews)): ?>
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[3rem] border border-gray-100 dark:border-slate-800 shadow-sm hover:border-hero-orange transition-all">
                <p class="text-gray-500 dark:text-gray-400 italic text-sm mb-6">"<?php echo htmlspecialchars($rev['review']); ?>"</p>
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($rev['name']); ?>&background=1B264F&color=fff" class="w-10 h-10 rounded-xl">
                    <p class="text-[11px] font-black uppercase text-hero-blue dark:text-white"><?php echo htmlspecialchars($rev['name']); ?></p>
                </div>
            </div>
        <?php endwhile; else: ?>
            <p class="col-span-full text-center text-gray-400 text-xs uppercase tracking-widest">No reviews synchronized yet.</p>
        <?php endif; ?>
    </div>

    <div class="mt-20 pt-10 border-t border-gray-100 dark:border-slate-800 flex justify-center">
        <?php if(file_exists('assets/img/logo.png')): ?>
            <img src="assets/img/logo.png" class="h-8 opacity-20 dark:invert" alt="Hero Tech">
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>