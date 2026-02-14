<?php 
include 'header.php'; 

$sqlStudent = "SELECT r.*, u.name, c.title 
               FROM course_reviews r 
               JOIN user_master u ON r.user_id = u.user_id 
               JOIN courses c ON r.course_id = c.course_id 
               ORDER BY r.review_id DESC";
$resStudent = mysqli_query($conn, $sqlStudent);
?>

<section class="relative pt-12 pb-20 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-4">
            Network Validation
        </span>
        <h1 class="text-4xl md:text-6xl font-black tracking-tighter mb-6 leading-tight text-hero-blue italic uppercase">
            Verified <span class="text-hero-orange not-italic">Success.</span>
        </h1>
        <p class="text-base text-gray-500 max-w-2xl mx-auto leading-relaxed px-4 font-medium">
            Discover how Hero Technology's curriculum nodes have transformed careers and optimized corporate engineering teams.
        </p>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-4 mb-10 justify-center md:justify-start">
            <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue italic">Partner Validation</h2>
            <div class="h-px flex-1 bg-gray-200 hidden md:block"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden group">
                <i class="fas fa-quote-right absolute -right-4 -top-4 text-8xl text-gray-50 opacity-50 group-hover:text-hero-orange/10 transition-colors"></i>
                <p class="text-gray-600 italic mb-8 leading-relaxed relative z-10 text-sm md:text-base">
                    "Hero Technology doesn't just train; they bridge the gap to employment. Their staffing services helped us source verified full-stack talent in record time."
                </p>
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-12 h-12 bg-hero-blue rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-900/20">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-tight text-hero-blue">InnovateX HR Team</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Corporate Partner • Staffing</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden group">
                <i class="fas fa-quote-right absolute -right-4 -top-4 text-8xl text-gray-50 opacity-50 group-hover:text-hero-orange/10 transition-colors"></i>
                <p class="text-gray-600 italic mb-8 leading-relaxed relative z-10 text-sm md:text-base">
                    "The corporate upskilling program was intensive and directly applicable. Our migration to cloud-native architecture was 40% faster thanks to Hero Tech."
                </p>
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-12 h-12 bg-hero-orange rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-500/20">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-tight text-hero-blue">CTO, DataCore Systems</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Enterprise Training Client</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <span class="text-hero-orange font-black uppercase tracking-[0.3em] text-[10px]">Alumni Network</span>
            <h2 class="text-3xl font-black tracking-tight mt-2 italic uppercase">Student <span class="text-hero-blue not-italic">Dispatches</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            if (mysqli_num_rows($resStudent) > 0):
                while($review = mysqli_fetch_assoc($resStudent)): 
            ?>
            <div class="bg-gray-50 p-8 rounded-[3rem] border border-gray-100 flex flex-col hover:border-hero-orange transition-all active:scale-[0.98]">
                <div class="flex text-amber-500 gap-1 mb-6 text-[10px]">
                    <?php for($i=0; $i<$review['rating']; $i++) echo '<i class="fas fa-star"></i>'; ?>
                </div>
                <p class="text-gray-500 italic mb-8 leading-relaxed text-sm flex-1">
                    "<?php echo htmlspecialchars($review['review']); ?>"
                </p>
                <div class="pt-6 border-t border-gray-200 flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($review['name']); ?>&background=1B264F&color=fff" class="w-10 h-10 rounded-xl shadow-sm">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-tighter text-hero-blue"><?php echo htmlspecialchars($review['name']); ?></p>
                        <p class="text-[8px] font-bold text-hero-orange uppercase tracking-widest"><?php echo htmlspecialchars($review['title']); ?></p>
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
            else:
            ?>
            <div class="col-span-full py-12 text-center opacity-40">
                <p class="text-xs font-black uppercase tracking-widest">Synchronizing alumni feedback nodes...</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-hero-blue text-white overflow-hidden relative">
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl font-black italic uppercase tracking-tighter mb-6">Become Our Next <span class="text-hero-orange not-italic">Success Story.</span></h2>
        <p class="text-gray-400 text-sm mb-10 max-w-lg mx-auto leading-relaxed">
            Initialize your learning node today and join the network of engineers leading the industry.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="courses.php" class="bg-hero-orange text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest text-xs shadow-lg shadow-orange-500/20 active:scale-95 transition-all">Start Training</a>
            <a href="contact.php" class="bg-white/10 border border-white/20 text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-white/20 transition-all">Contact Us</a>
        </div>
    </div>
    <i class="fas fa-bolt absolute -left-10 -bottom-10 text-[15rem] text-white opacity-5"></i>
</section>

<?php include 'footer.php'; ?>