<?php 
include 'header.php'; 

// 1. Fetch Blog Posts (Procedural mysqli)
// We simulate the query based on your course/user schema logic
$sqlBlogs = "SELECT c.title, c.description, c.thumbnail, cat.category_name, u.name as author, c.created_at 
             FROM courses c 
             JOIN course_category cat ON c.category_id = cat.category_id 
             JOIN user_master u ON c.instructor_id = u.user_id 
             WHERE c.status = 'publish' 
             ORDER BY c.created_at DESC LIMIT 6";
$resBlogs = mysqli_query($conn, $sqlBlogs);
?>

<section class="relative pt-12 pb-20 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-4">
            Knowledge Base
        </span>
        <h1 class="text-4xl md:text-6xl font-black tracking-tighter mb-6 leading-tight text-hero-blue italic uppercase">
            Technical <span class="text-hero-orange not-italic">Insights.</span>
        </h1>
        <p class="text-base text-gray-500 max-w-2xl mx-auto leading-relaxed px-4 font-medium">
            Deep dives into modern engineering stacks, architectural patterns, and industry trends curated by our lead instructors.
        </p>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-[2.5rem] border border-gray-200 overflow-hidden shadow-sm flex flex-col lg:flex-row">
            <div class="lg:w-1/2 h-64 lg:h-auto overflow-hidden">
                <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=1000" class="w-full h-full object-cover transition-all duration-700" alt="Cybersecurity Blog">
            </div>
            <div class="lg:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <span class="text-hero-orange font-black uppercase tracking-widest text-[9px] mb-4">Featured Node</span>
                <h2 class="text-2xl md:text-3xl font-black text-hero-blue uppercase italic mb-6 leading-tight">Implementing Zero-Trust Architecture in Modern Microservices</h2>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">Discover why traditional perimeter security is failing and how to implement identity-based security nodes in your distributed systems.</p>
                <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-hero-blue rounded-xl flex items-center justify-center text-white text-xs font-bold">HT</div>
                        <p class="text-[10px] font-black uppercase tracking-tighter text-hero-blue">System Architect</p>
                    </div>
                    <a href="#" class="text-[10px] font-black uppercase tracking-widest text-hero-orange border-b-2 border-hero-orange pb-1">Read Node</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-12">
            <h3 class="text-xl font-black text-hero-blue uppercase italic tracking-tight">Recent Dispatches</h3>
            <div class="h-px flex-1 bg-gray-100 mx-8 hidden md:block"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while($post = mysqli_fetch_assoc($resBlogs)): ?>
            <div class="group cursor-pointer">
                <div class="relative h-60 rounded-[2rem] overflow-hidden mb-6 border border-gray-100">
                    <img src="assets/img/courses/<?php echo $post['thumbnail']; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Blog Image">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest text-hero-blue">
                        <?php echo htmlspecialchars($post['category_name']); ?>
                    </div>
                </div>
                <div class="px-2">
                    <div class="flex items-center gap-2 text-gray-400 text-[9px] font-black uppercase tracking-widest mb-3">
                        <span><?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>5 Min Read</span>
                    </div>
                    <h4 class="text-lg font-black text-hero-blue mb-4 group-hover:text-hero-orange transition-colors leading-tight uppercase">
                        <?php echo htmlspecialchars($post['title']); ?>
                    </h4>
                    <p class="text-gray-500 text-xs leading-relaxed line-clamp-2 mb-6 font-medium">
                        <?php echo htmlspecialchars($post['description']); ?>
                    </p>
                    <a href="#" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-hero-blue group-hover:gap-4 transition-all">
                        Analyze Node <i class="fas fa-arrow-right text-hero-orange"></i>
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <div class="mt-20 flex justify-center gap-2">
            <button class="w-10 h-10 rounded-xl bg-hero-blue text-white flex items-center justify-center text-xs font-black">1</button>
            <button class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 text-gray-400 flex items-center justify-center text-xs font-black hover:border-hero-blue hover:text-hero-blue transition-all">2</button>
            <button class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 text-gray-400 flex items-center justify-center text-xs font-black hover:border-hero-blue hover:text-hero-blue transition-all">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<section class="py-20 bg-hero-blue overflow-hidden relative">
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <i class="fas fa-microchip text-4xl text-hero-orange mb-6"></i>
        <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter mb-4">Synchronize Your Inbox</h2>
        <p class="text-gray-400 text-sm mb-10 max-w-lg mx-auto leading-relaxed">Join 5,000+ engineers receiving weekly technical dispatches and curriculum updates.</p>
        
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" placeholder="ENTER EMAIL NODE" class="flex-1 bg-white/5 border border-white/10 rounded-xl px-6 py-4 text-white text-xs font-bold outline-none focus:border-hero-orange transition-all uppercase tracking-widest">
            <button type="submit" class="bg-hero-orange text-white px-8 py-4 rounded-xl font-black uppercase tracking-widest text-xs shadow-lg shadow-orange-500/20 active:scale-95 transition-all">
                Subscribe
            </button>
        </form>
    </div>
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-hero-orange/10 rounded-full blur-3xl"></div>
</section>

<?php include 'footer.php'; ?>