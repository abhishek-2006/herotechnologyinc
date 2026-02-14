<?php 
include 'header.php'; 

// Fetch Featured Online Tracks
$sqlOnline = "SELECT c.*, cat.category_name 
              FROM courses c 
              JOIN course_category cat ON c.category_id = cat.category_id 
              WHERE c.status = 'publish' AND c.price > 0 
              LIMIT 3";
$resOnline = mysqli_query($conn, $sqlOnline);
?>

<section class="relative pt-12 pb-20 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-4">
            Intelligence Delivery
        </span>
        <h1 class="text-4xl md:text-6xl font-black tracking-tighter mb-6 leading-tight text-hero-blue italic uppercase">
            Training <span class="text-hero-orange not-italic">Architectures.</span>
        </h1>
        <p class="text-base text-gray-500 max-w-2xl mx-auto leading-relaxed px-4 font-medium">
            Select your preferred learning methodology. From self-paced digital nodes to intensive on-site bootcamps, we provide the framework for engineering mastery.
        </p>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-hero-blue rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-blue-900/20">
                    <i class="fas fa-laptop-code text-2xl"></i>
                </div>
                <h3 class="text-sm font-black uppercase tracking-widest text-hero-blue mb-3">Online Training</h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-6">Global access to high-fidelity video dispatches and sandbox environments.</p>
                <a href="#online" class="mt-auto text-[10px] font-black uppercase tracking-widest text-hero-orange border-b-2 border-hero-orange pb-1">View Modules</a>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-hero-orange rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-orange-500/20">
                    <i class="fas fa-chalkboard-user text-2xl"></i>
                </div>
                <h3 class="text-sm font-black uppercase tracking-widest text-hero-blue mb-3">Classroom Sessions</h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-6">Hands-on, instructor-led training at our state-of-the-art tech labs with high-performance hardware.</p>
                <a href="classroom.php" class="mt-auto text-[10px] font-black uppercase tracking-widest text-hero-orange border-b-2 border-hero-orange pb-1">Locate Lab</a>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-hero-blue rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-blue-900/20">
                    <i class="fas fa-building-shield text-2xl"></i>
                </div>
                <h3 class="text-sm font-black uppercase tracking-widest text-hero-blue mb-3">Corporate Solutions</h3>
                <p class="text-xs text-gray-500 leading-relaxed mb-6">Customized enterprise roadmaps designed to upskill internal engineering teams on specific stacks.</p>
                <a href="contact.php?subject=Corporate_Inquiry" class="mt-auto text-[10px] font-black uppercase tracking-widest text-hero-orange border-b-2 border-hero-orange pb-1">Consult Node</a>
            </div>
        </div>
    </div>
</section>

<section id="online" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 text-center md:text-left gap-4">
            <div>
                <span class="text-hero-orange font-black uppercase tracking-[0.3em] text-[10px]">Digital Curriculum</span>
                <h2 class="text-3xl font-black tracking-tight mt-2 italic uppercase">Live Online Tracks</h2>
            </div>
            <a href="courses.php" class="text-[10px] font-black uppercase tracking-widest border-b-2 border-hero-blue pb-1">Enter All-Course Terminal</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while($course = mysqli_fetch_assoc($resOnline)): ?>
            <div class="bg-gray-50 rounded-[2.5rem] border border-gray-100 overflow-hidden hover:shadow-2xl transition-all group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                    <img src="assets/img/courses/<?php echo $course['thumbnail']; ?>" class="w-full h-full object-cover transition-all duration-500">
                    <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[9px] font-black uppercase tracking-widest text-hero-blue">
                        <?php echo htmlspecialchars($course['category_name']); ?>
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-lg font-black text-hero-blue uppercase italic mb-4 h-12 overflow-hidden"><?php echo htmlspecialchars($course['title']); ?></h3>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                        <span class="text-xl font-black text-hero-blue">₹<?php echo number_format($course['price'], 0); ?></span>
                        <a href="course-details.php?id=<?php echo $course['course_id']; ?>" class="bg-hero-orange text-white px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-orange-500/20">
                            Initialize Track
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-hero-blue text-white overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4 flex flex-col lg:flex-row items-center gap-16 relative z-10">
        <div class="lg:w-1/2">
            <h2 class="text-3xl md:text-4xl font-black italic uppercase tracking-tighter mb-8 leading-tight">
                The <span class="text-hero-orange not-italic">Hero</span> Training Protocol.
            </h2>
            <div class="space-y-6">
                <div class="flex gap-4">
                    <i class="fas fa-check-double text-hero-orange mt-1"></i>
                    <p class="text-sm text-gray-300 leading-relaxed"><strong class="text-white uppercase tracking-tighter">Skill Validation:</strong> Every training node requires project-based validation before certification.</p>
                </div>
                <div class="flex gap-4">
                    <i class="fas fa-check-double text-hero-orange mt-1"></i>
                    <p class="text-sm text-gray-300 leading-relaxed"><strong class="text-white uppercase tracking-tighter">Current Stacks:</strong> We iterate our modules quarterly to align with shifting industry technology nodes.</p>
                </div>
                <div class="flex gap-4">
                    <i class="fas fa-check-double text-hero-orange mt-1"></i>
                    <p class="text-sm text-gray-300 leading-relaxed"><strong class="text-white uppercase tracking-tighter">Instructor Direct:</strong> Live troubleshooting sessions with senior engineers for all classroom and corporate tracks.</p>
                </div>
            </div>
        </div>
        <div class="lg:w-1/2">
            <div class="aspect-square bg-white/5 border border-white/10 rounded-[4rem] flex items-center justify-center p-12">
                <i class="fas fa-brain text-[12rem] text-hero-orange opacity-20"></i>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>