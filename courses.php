<?php
// Include header (contains config.php and session_start)
include 'header.php'; 

// 1. Capture Filter Parameters
$active_cat = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : 'all';

// 2. Enrollment Status Intelligence
$isLoggedIn = isset($_SESSION['email']);
$enrolled_courses = [];

if ($isLoggedIn) {
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    $resUser = mysqli_query($conn, "SELECT user_id FROM user_master WHERE email='$email' LIMIT 1");
    $user_id = mysqli_fetch_column($resUser);

    $resEnroll = mysqli_query($conn, "SELECT course_id FROM enrollments WHERE user_id = '$user_id' AND status = 'active'");
    while($row = mysqli_fetch_assoc($resEnroll)) {
        $enrolled_courses[] = $row['course_id'];
    }
}

// 3. Fetch Dynamic Categories
$resCats = mysqli_query($conn, "SELECT * FROM course_category WHERE status = 'active'");
$categories = mysqli_fetch_all($resCats, MYSQLI_ASSOC);

// 4. Construct Dynamic Query based on Category Filter
$category_filter = ($active_cat !== 'all') ? "AND c.category_id = '$active_cat'" : "";

$sqlCourses = "
    SELECT c.*, u.name as instructor_name, cat.category_name 
    FROM courses c
    JOIN user_master u ON c.instructor_id = u.user_id
    JOIN course_category cat ON c.category_id = cat.category_id
    WHERE c.status = 'publish' $category_filter
    ORDER BY c.created_at DESC
";
$resCourses = mysqli_query($conn, $sqlCourses);
$allCourses = mysqli_fetch_all($resCourses, MYSQLI_ASSOC);
?>

<link rel="icon" type="image/x-icon" href="backpanel/assets/img/favicon.ico">

<section class="pt-12 pb-16 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <img src="backpanel/assets/img/logo.png" class="h-10 mx-auto mb-6 opacity-80" alt="Hero Logo">
        <h1 class="text-5xl font-black tracking-tighter mt-4 mb-6 italic uppercase text-hero-blue">Browse <span class="text-hero-orange not-italic">Courses</span></h1>
        <p class="text-gray-500 max-w-2xl mx-auto text-sm leading-relaxed font-medium">
            Explore industry-standard technical training modules designed by engineers. Select a node to view detailed curriculum intelligence.
        </p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-12">
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="courses.php?category=all" 
               class="px-6 py-2 rounded-full border-2 transition-all text-[10px] font-black uppercase tracking-widest <?= ($active_cat == 'all') ? 'border-hero-blue bg-hero-blue text-white shadow-lg shadow-blue-900/10' : 'border-gray-100 text-gray-400 hover:border-hero-blue' ?>">
               All Nodes
            </a>
            
            <?php foreach($categories as $cat): ?>
                <a href="courses.php?category=<?= $cat['category_id'] ?>" 
                   class="px-6 py-2 rounded-full border-2 transition-all text-[10px] font-black uppercase tracking-widest <?= ($active_cat == $cat['category_id']) ? 'border-hero-orange bg-hero-orange text-white shadow-lg shadow-orange-500/10' : 'border-gray-100 text-gray-400 hover:border-hero-orange hover:text-hero-orange' ?>">
                    <?php echo htmlspecialchars($cat['category_name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <div class="relative w-full md:w-72">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-xs"></i>
            <input type="text" id="courseSearch" placeholder="Search curriculum..." 
                   class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-xs font-bold focus:border-hero-blue outline-none transition-all">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10" id="courseGrid">
        <?php if(count($allCourses) > 0): foreach($allCourses as $course): 
            $isEnrolled = in_array($course['course_id'], $enrolled_courses);
        ?>
        <div class="course-card bg-white rounded-[2.5rem] border border-gray-100 overflow-hidden hover:shadow-2xl transition-all group relative" 
             data-title="<?= strtolower($course['title']) ?>">
            
            <div class="h-75 bg-gray-50 relative overflow-hidden">
                <img src="assets/img/courses/<?php echo htmlspecialchars($course['thumbnail']); ?>" class="w-full h-full object-fill transition-all duration-500 group-hover:scale-110" alt="Course Thumbnail">
                <div class="absolute top-6 left-6 px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[9px] font-black uppercase tracking-widest text-hero-blue">
                    <?php echo htmlspecialchars($course['category_name']); ?>
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-2 rounded-full bg-hero-orange animate-pulse"></div>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Instructor: <?php echo htmlspecialchars($course['instructor_name']); ?></span>
                </div>
                
                <h3 class="course-title text-xl font-bold mb-4 h-14 overflow-hidden leading-tight text-hero-blue italic uppercase">
                    <?php echo htmlspecialchars($course['title']); ?>
                </h3>

                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-50">
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter mb-1">Access Cost</p>
                        <span class="text-2xl font-black text-hero-blue">₹<?php echo number_format($course['price'], 0); ?></span>
                    </div>

                    <?php if($isEnrolled): ?>
                        <a href="learn.php?id=<?php echo $course['course_id']; ?>" class="bg-emerald-500 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-500/20">
                            Resume Node
                        </a>
                    <?php else: ?>
                        <a href="course-details.php?id=<?php echo $course['course_id']; ?>" class="bg-hero-orange text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-orange-500/20 hover:-translate-y-1 transition-all">
                            View Module
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; else: ?>
            <div class="col-span-full py-20 text-center">
                <i class="fas fa-microchip text-4xl text-gray-100 mb-4"></i>
                <p class="text-xs font-black uppercase tracking-widest text-gray-300">No Intelligence Nodes Found in this Sector.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('courseSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.course-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const title = card.getAttribute('data-title');
            if (title.includes(searchTerm)) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>

<?php include 'footer.php'; ?>