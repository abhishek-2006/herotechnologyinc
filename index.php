<?php 
include 'header.php'; 

$course_count = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM courses WHERE status = 'publish'"))[0];
$student_count = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM user_master WHERE role = 'student'"))[0];
$client_count = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM corporate_clients WHERE status = 'active'"))[0];
$hiring_rate = "98%";
?>

<header class="relative pt-12 pb-20 md:pt-20 md:pb-32 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="text-center lg:text-left order-2 lg:order-1">
                <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-6">
                    Engineering Excellence
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black tracking-tighter mb-6 lg:mb-8 leading-[1.1] lg:leading-[0.95] text-hero-blue">
                    Empowering the <span class="italic text-hero-orange">Next Generation</span> of Engineers.
                </h1>
                <p class="text-base sm:text-lg text-gray-500 mb-8 lg:mb-10 leading-relaxed max-w-lg mx-auto lg:mx-0">
                    Hero Technology Inc. bridges the gap between academic theory and industry reality with engineer-led technical training.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="courses.php" class="w-full sm:w-auto text-center bg-hero-blue text-white px-8 py-4 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-hero-orange transition-all shadow-xl">
                        Explore Academy
                    </a>
                    <a href="contact.php" class="w-full sm:w-auto text-center bg-white border-2 border-hero-blue text-hero-blue px-8 py-4 rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-gray-50 transition-all">
                        Corporate Training
                    </a>
                </div>
            </div>
            <div class="relative order-1 lg:order-2 px-8 sm:px-20 lg:px-0">
                <div class="aspect-square bg-gray-50 rounded-[2.5rem] sm:rounded-[3rem] overflow-hidden border border-gray-100 relative shadow-inner">
                    <div class="absolute inset-0 bg-gradient-to-br from-hero-blue/10 to-transparent"></div>
                    <div class="flex items-center justify-center h-full">
                        <i class="fas fa-microchip text-7xl sm:text-9xl text-gray-200"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="py-16 md:py-24 bg-hero-blue text-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tight italic">Global Training Delivery</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-12">
            <div class="p-6 md:p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-hero-orange transition-all">
                <div class="w-12 h-12 bg-hero-orange rounded-xl mb-6 flex items-center justify-center">
                    <i class="fas fa-globe text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 uppercase">Online Training</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Interactive, self-paced modules designed for the modern remote engineer. Access from anywhere.</p>
            </div>
            <div class="p-6 md:p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-hero-orange transition-all">
                <div class="w-12 h-12 bg-hero-orange rounded-xl mb-6 flex items-center justify-center">
                    <i class="fas fa-chalkboard-user text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 uppercase">Classroom Sessions</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Hands-on, instructor-led training at our state-of-the-art tech labs with high-performance hardware.</p>
            </div>
            <div class="p-6 md:p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-hero-orange transition-all">
                <div class="w-12 h-12 bg-hero-orange rounded-xl mb-6 flex items-center justify-center">
                    <i class="fas fa-building text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 uppercase">Corporate Solutions</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Tailored enterprise roadmaps to upskill your entire engineering team on internal tech stacks.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="grid grid-cols-2 gap-4 order-2 lg:order-1">
                <div class="bg-gray-50 p-6 md:p-8 rounded-2xl md:rounded-3xl border border-gray-100 text-center">
                    <div class="text-3xl md:text-4xl font-black text-hero-blue mb-2"><?php echo $course_count; ?></div>
                    <div class="text-[9px] md:text-[10px] font-black uppercase text-gray-400 tracking-widest">Tech Courses</div>
                </div>
                <div class="bg-gray-50 p-6 md:p-8 rounded-2xl md:rounded-3xl border border-gray-100 text-center">
                    <div class="text-3xl md:text-4xl font-black text-hero-orange mb-2"><?php echo $student_count; ?></div>
                    <div class="text-[9px] md:text-[10px] font-black uppercase text-gray-400 tracking-widest">Active Students</div>
                </div>
                <div class="bg-gray-50 p-6 md:p-8 rounded-2xl md:rounded-3xl border border-gray-100 text-center">
                    <div class="text-3xl md:text-4xl font-black text-hero-orange mb-2"><?php echo $hiring_rate; ?></div>
                    <div class="text-[9px] md:text-[10px] font-black uppercase text-gray-400 tracking-widest">Hiring Rate</div>
                </div>
                <div class="bg-gray-50 p-6 md:p-8 rounded-2xl md:rounded-3xl border border-gray-100 text-center">
                    <div class="text-3xl md:text-4xl font-black text-hero-blue mb-2"><?php echo $client_count; ?></div>
                    <div class="text-[9px] md:text-[10px] font-black uppercase text-gray-400 tracking-widest">Clients</div>
                </div>
            </div>
            <div class="order-1 lg:order-2 text-center lg:text-left">
                <h2 class="text-3xl md:text-4xl font-black tracking-tight mb-6 md:mb-8 uppercase italic">Bridging the Gap</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">Hero Technology Inc. was founded with a singular mission: to provide the practical, rigorous engineering education that universities often overlook.</p>
                <p class="text-gray-600 mb-10 leading-relaxed">Our curriculum is built by engineers from top-tier firms, ensuring every lesson translates directly to the job site.</p>
                <a href="about.php" class="inline-flex items-center gap-2 text-sm font-black text-hero-blue uppercase tracking-widest hover:text-hero-orange transition-colors">
                    Learn more <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 md:mb-16 text-center md:text-left gap-4">
            <div>
                <span class="text-hero-orange font-black uppercase tracking-[0.3em] text-[10px]">Curriculum</span>
                <h2 class="text-3xl md:text-4xl font-black tracking-tight mt-2 italic uppercase">Premium Learning Tracks</h2>
            </div>
            <a href="courses.php" class="text-xs font-bold uppercase tracking-widest border-b-2 border-hero-orange pb-1">Browse all</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">
            <?php 
                $result = mysqli_query($conn, "SELECT c.*, cat.category_name FROM courses c JOIN course_category cat ON c.category_id = cat.category_id WHERE c.status = 'publish' LIMIT 3");
                while($course = mysqli_fetch_assoc($result)): 
            ?>
            <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-gray-100 overflow-hidden hover:shadow-2xl transition-all group">
                <div class="h-48 md:h-56 bg-gray-100 relative overflow-hidden">
                    <img src="assets/img/courses/<?php echo $course['thumbnail']; ?>" class="w-full h-full object-cover  group-hover:scale-105 transition-all duration-500">
                    <div class="absolute top-4 left-4 md:top-6 md:left-6 px-3 py-1 bg-white/90 backdrop-blur rounded-full text-[9px] font-black uppercase tracking-widest text-hero-blue">
                        <?php echo htmlspecialchars($course['category_name']); ?>
                    </div>
                </div>
                <div class="p-6 md:p-8">
                    <h3 class="text-lg md:text-xl font-bold mb-4"><?php echo htmlspecialchars($course['title']); ?></h3>
                    <p class="text-gray-500 text-sm mb-6 md:mb-8 line-clamp-2"><?php echo htmlspecialchars($course['description']); ?></p>
                    <div class="flex items-center justify-between border-t border-gray-50 pt-6">
                        <span class="text-lg md:text-xl font-black text-hero-blue">₹<?php echo number_format($course['price'], 0); ?></span>
                        <a href="course-details.php?id=<?php echo $course['course_id']; ?>" class="bg-hero-orange text-white px-4 md:px-5 py-2.5 rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest shadow-lg shadow-orange-500/20">
                            Explore
                        </a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12 md:mb-16">
            <i class="fas fa-quote-left text-4xl md:text-5xl text-hero-blue/10 mb-6"></i>
            <h2 class="text-2xl md:text-3xl font-black tracking-tight italic uppercase px-4">Trusted Experiences</h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-10">
            <div class="bg-gray-50 p-6 md:p-10 rounded-2xl md:rounded-3xl border border-gray-100">
                <h4 class="text-hero-orange text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-4">Student Feedback</h4>
                <p class="text-sm md:text-base text-gray-500 italic mb-8 leading-relaxed">"The UI/UX Bootcamp at Hero Tech provided me with the prototyping tools and design thinking framework I needed to land my senior role."</p>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-hero-blue rounded-xl flex items-center justify-center text-white"><i class="fas fa-user"></i></div>
                    <div>
                        <p class="text-xs md:text-sm font-bold uppercase tracking-tight">Mina Shah</p>
                        <p class="text-[9px] uppercase font-bold text-hero-orange tracking-widest">Alumni Designer</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 p-6 md:p-10 rounded-2xl md:rounded-3xl border border-gray-100">
                <h4 class="text-hero-blue text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-4">Partner Feedback</h4>
                <p class="text-sm md:text-base text-gray-500 italic mb-8 leading-relaxed">"Hero Technology bridges the gap to employment. Their staffing services helped us source verified full-stack talent in record time."</p>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-hero-orange rounded-xl flex items-center justify-center text-white"><i class="fas fa-building"></i></div>
                    <div>
                        <p class="text-xs md:text-sm font-bold uppercase tracking-tight">InnovateX HR Team</p>
                        <p class="text-[9px] uppercase font-bold text-hero-blue tracking-widest">Corporate Partner</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>