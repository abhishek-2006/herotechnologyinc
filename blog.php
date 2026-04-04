<?php 
include 'header.php'; 

// 1. Fetch Blog Posts
$sqlBlogs = "SELECT c.title, c.summary, c.thumbnail, c.slug, cat.category_name, i.name as author, c.created_at 
             FROM courses c 
             JOIN course_category cat ON c.category_id = cat.category_id 
             JOIN instructors i ON c.instructor_id = i.instructor_id 
             WHERE c.status = 'publish' 
             ORDER BY c.created_at DESC LIMIT 6";
$resBlogs = mysqli_query($conn, $sqlBlogs);

if(mysqli_num_rows($resBlogs) == 0) {
    echo "<p class='text-center text-gray-500 py-20'>No blog posts available at the moment. Please check back later.</p>";
    include 'footer.php';
    exit;
}

if(mysqli_num_rows($resBlogs) > 0) {
    mysqli_data_seek($resBlogs, 0);
}
?>

<section class="relative pt-12 pb-16 md:pb-20 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 md:px-4 text-center">
        <span class="animate__animated animate__fadeInDown inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-4">
            Knowledge Base
        </span>
        <h1 class="animate__animated animate__fadeInUp text-3xl sm:text-4xl md:text-6xl font-black tracking-tighter mb-6 leading-tight text-hero-blue italic uppercase">
            Technical <span class="text-hero-orange not-italic">Insights.</span>
        </h1>
        <p class="animate__animated animate__fadeInUp animate__delay-1s text-sm md:text-base text-gray-500 max-w-2xl mx-auto leading-relaxed px-2 font-medium">
            Deep dives into modern engineering stacks, architectural patterns, and industry trends curated by our lead instructors.
        </p>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 md:px-4">
        <div class="animate__animated animate__fadeIn animate__delay-1s bg-white rounded-[2rem] md:rounded-[2.5rem] border border-gray-200 overflow-hidden shadow-sm flex flex-col lg:flex-row min-h-[400px]">
            <div class="lg:w-1/2 h-64 sm:h-80 lg:h-auto overflow-hidden">
                <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=1000" class="w-full h-full object-cover" alt="Cybersecurity Blog">
            </div>
            <div class="lg:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <span class="text-hero-orange font-black uppercase tracking-widest text-[9px] mb-4">Featured Courses</span>
                <h2 class="text-xl md:text-3xl font-black text-hero-blue uppercase italic mb-6 leading-tight">Implementing Zero-Trust Architecture in Modern Microservices</h2>
                <p class="text-gray-500 text-xs md:text-sm leading-relaxed mb-8">Discover why traditional perimeter security is failing and how to implement identity-based security nodes in your distributed systems.</p>
                <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-hero-blue rounded-xl flex items-center justify-center text-white text-xs font-bold">HT</div>
                        <p class="text-[9px] md:text-[10px] font-black uppercase tracking-tighter text-hero-blue">System Architect</p>
                    </div>
                    <a href="#" class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-hero-orange border-b-2 border-hero-orange pb-1">Read Node</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 md:py-24 bg-[var(--app-bg)] transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-6 md:px-4">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-12 md:mb-16 gap-4">
            <div class="flex items-center gap-4">
                <span class="w-2 h-2 rounded-full bg-hero-orange animate-ping"></span>
                <h3 class="text-xl md:text-2xl font-black text-hero-blue dark:text-white uppercase italic tracking-tighter">
                    Recent <span class="text-hero-orange not-italic">Dispatches</span>
                </h3>
            </div>
            <div class="h-px flex-1 bg-slate-200 dark:bg-slate-800 mx-8 hidden lg:block"></div>
            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Status: Uplink Active</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
            <?php while($post = mysqli_fetch_assoc($resBlogs)): ?>
            <div class="group cursor-pointer transform transition-all duration-700 hover:-translate-y-2 md:hover:-translate-y-4">
                
                <div class="relative h-60 sm:h-72 rounded-[2.5rem] md:rounded-[3rem] overflow-hidden mb-6 md:mb-8 shadow-2xl shadow-black/5 group-hover:shadow-hero-orange/20 transition-all">
                    <a href="course/<?php echo $post['slug']; ?>" class="absolute inset-0 z-10">
                        <img src="assets/img/courses/<?php echo $post['thumbnail']; ?>" 
                            class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110" alt="Node Thumbnail">
                    </a>
                    <div class="absolute top-4 md:top-6 left-4 md:left-6 bg-black/60 backdrop-blur-xl border border-white/10 px-4 md:px-5 py-1.5 md:py-2 rounded-xl md:rounded-2xl text-[7px] md:text-[8px] font-black uppercase tracking-[0.2em] text-white">
                        <?php echo htmlspecialchars($post['category_name']); ?>
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-hero-orange/10 to-transparent h-full w-full -translate-y-full group-hover:animate-[scan_3s_linear_infinite] pointer-events-none"></div>
                </div>

                <div class="px-2 md:px-4">
                    <div class="flex items-center gap-3 text-slate-400 text-[8px] md:text-[9px] font-black uppercase tracking-[0.2em] mb-4">
                        <i class="fas fa-user-ninja text-hero-orange"></i>
                        <span class="text-hero-blue dark:text-slate-300"><?php echo htmlspecialchars($post['author']); ?></span>
                        <span class="w-1 h-1 bg-slate-300 dark:bg-slate-700 rounded-full"></span>
                        <span><?php echo date('d M, Y', strtotime($post['created_at'])); ?></span>
                    </div>

                    <h4 class="text-lg md:text-xl font-black text-hero-blue dark:text-white mb-3 md:mb-4 group-hover:text-hero-orange transition-colors leading-tight uppercase italic tracking-tighter">
                        <?php echo htmlspecialchars($post['title']); ?>
                    </h4>

                    <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed line-clamp-2 mb-6 md:mb-8 font-medium opacity-80">
                        <?php echo htmlspecialchars($post['summary']); ?>
                    </p>

                    <div class="flex items-center justify-between">
                        <a href="course/<?php echo $post['slug']; ?>" class="inline-flex items-center gap-2 md:gap-3 text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] text-hero-blue dark:text-hero-orange group-hover:gap-6 transition-all">
                            Analyze Node <i class="fas fa-long-arrow-alt-right"></i>
                        </a>
                        <div class="flex gap-1">
                            <span class="w-1 h-1 md:w-1.5 md:h-1.5 bg-hero-orange rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            <span class="w-1 h-1 md:w-1.5 md:h-1.5 bg-hero-blue rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>