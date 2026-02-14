<?php 
include 'header.php';

// Fetch Classroom-specific tracks
$sqlClass = "SELECT c.*, cat.category_name 
             FROM courses c 
             JOIN course_category cat ON c.category_id = cat.category_id 
             WHERE cat.category_name LIKE '%Classroom%' OR cat.category_name LIKE '%Offline%'
             AND c.status = 'publish' 
             LIMIT 4";
$resClass = mysqli_query($conn, $sqlClass);
?>

<section class="relative pt-12 pb-20 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-4">
            Physical Infrastructure
        </span>
        <h1 class="text-4xl md:text-6xl font-black tracking-tighter mb-6 leading-tight text-hero-blue italic uppercase">
            On-Site <span class="text-hero-orange not-italic">Tech Labs.</span>
        </h1>
        <p class="text-base text-gray-500 max-w-2xl mx-auto leading-relaxed px-4 font-medium">
            Experience immersive, instructor-led training at our state-of-the-art engineering hubs. High-performance hardware meets expert mentorship.
        </p>
    </div>
</section>

<section class="py-16 bg-gray-50 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 bg-hero-blue rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-blue-900/10">
                    <i class="fas fa-microchip"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black uppercase tracking-tight text-hero-blue mb-2">Pro Hardware Nodes</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Access to dedicated high-performance workstations optimized for heavy engineering stacks.</p>
                </div>
            </div>
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 bg-hero-orange rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-orange-500/10">
                    <i class="fas fa-network-wired"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black uppercase tracking-tight text-hero-blue mb-2">Gigabit Sandbox</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Zero-latency internal networking for real-time collaborative project deployments.</p>
                </div>
            </div>
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 bg-hero-blue rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-blue-900/10">
                    <i class="fas fa-users-viewfinder"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black uppercase tracking-tight text-hero-blue mb-2">1:1 Mentorship</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Direct interaction with senior engineers to troubleshoot logic and architectural hurdles in person.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 text-center md:text-left gap-4">
            <div>
                <span class="text-hero-orange font-black uppercase tracking-[0.3em] text-[10px]">Active Hubs</span>
                <h2 class="text-3xl font-black tracking-tight mt-2 italic uppercase">Classroom Tracks</h2>
            </div>
            <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest border-l-2 border-hero-orange pl-4">Limited Seats Per Node</p>
        </div>

        <div class="space-y-4">
            <?php 
            if (mysqli_num_rows($resClass) > 0):
                while($class = mysqli_fetch_assoc($resClass)): 
            ?>
            <div class="p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 group hover:border-hero-blue transition-all">
                <div class="flex items-center gap-6 w-full md:w-auto">
                    <div class="w-16 h-16 bg-gray-50 rounded-2xl overflow-hidden shrink-0 border border-gray-100">
                        <img src="assets/img/courses/<?php echo $class['thumbnail']; ?>" class="w-full h-full object-cover transition-all">
                    </div>
                    <div>
                        <h4 class="font-black text-sm uppercase text-hero-blue mb-1"><?php echo htmlspecialchars($class['title']); ?></h4>
                        <div class="flex flex-wrap gap-3">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest"><i class="fas fa-calendar-day text-hero-orange mr-1"></i> Starting Mon</span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest"><i class="fas fa-clock text-hero-orange mr-1"></i> 09:00 - 13:00</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end">
                    <span class="text-xl font-black text-hero-blue">₹<?php echo number_format($class['price'], 0); ?></span>
                    <a href="course-details.php?id=<?php echo $class['course_id']; ?>" class="bg-hero-blue text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-[9px] shadow-lg shadow-blue-900/10 hover:bg-hero-orange transition-all">Register Node</a>
                </div>
            </div>
            <?php 
                endwhile; 
            else:
            ?>
            <div class="p-12 border-2 border-dashed border-gray-100 rounded-[3rem] text-center opacity-40">
                <p class="text-xs font-black uppercase tracking-widest">New Lab Batches Synchronizing...</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-hero-blue text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
        <h2 class="text-3xl font-black italic uppercase tracking-tighter mb-4">The Training <span class="text-hero-orange not-italic">Mainframe.</span></h2>
        <p class="text-gray-400 max-w-xl mx-auto text-sm leading-relaxed mb-12">Designed for concentration and high-intensity technical output.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="aspect-video bg-white/5 rounded-[3rem] border border-white/10 flex items-center justify-center p-4">
                 <i class="fas fa-desktop text-[10rem] opacity-5"></i>
            </div>
            <div class="aspect-video bg-white/5 rounded-[3rem] border border-white/10 flex items-center justify-center p-4">
                 <i class="fas fa-server text-[10rem] opacity-5"></i>
            </div>
        </div>
    </div>
    <i class="fas fa-bolt-lightning absolute -right-20 -bottom-20 text-[25rem] opacity-5 text-white"></i>
</section>

<?php include 'footer.php'; ?>