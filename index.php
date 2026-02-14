<?php include 'header.php'; ?>
<style>
    @keyframes scrollText {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .scrolling-text {
        white-space: nowrap;
        animation: scrollText 40s linear infinite;
        font-size: 15rem;
        opacity: 0.03;
        font-weight: 900;
        pointer-events: none;
    }
    .parallax-bg {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<header class="relative pt-12 pb-20 md:pt-20 md:pb-32 bg-white overflow-hidden">
    <div class="absolute top-20 left-0 w-full overflow-hidden no-print">
        <div class="scrolling-text uppercase italic">
            ENGINEERING • TECHNOLOGY • INNOVATION • DEVELOPMENT • SCALE • ARCHITECTURE • ENGINEERING • TECHNOLOGY • INNOVATION • DEVELOPMENT • SCALE • ARCHITECTURE
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="text-center lg:text-left order-2 lg:order-1">
                <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-6">
                    Engineering Excellence
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black tracking-tighter mb-6 lg:mb-8 leading-[1.1] text-hero-blue">
                    Empowering the <span class="italic text-hero-orange">Next Generation</span> of Engineers.
                </h1>
                <p class="text-base sm:text-lg text-gray-500 mb-8 lg:mb-10 leading-relaxed max-w-lg mx-auto lg:mx-0">
                    Hero Technology Inc. bridges the gap between academic theory and industry reality with engineer-led technical training.
                </p>
                </div>

            <div class="relative order-1 lg:order-2 px-4 group">
                <div class="absolute -inset-4 bg-hero-orange/10 blur-3xl rounded-full scale-0 group-hover:scale-100 transition-transform duration-700"></div>
                <div class="aspect-square bg-gray-900 rounded-[3rem] overflow-hidden relative shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800" 
                         class="w-full h-full object-cover opacity-60 mix-blend-luminosity hover:mix-blend-normal transition-all duration-700" 
                         alt="Advanced Engineering Lab">
                    <div class="absolute inset-0 bg-gradient-to-t from-hero-blue via-transparent to-transparent opacity-60"></div>
                    
                    <div class="absolute bottom-8 left-8 right-8 bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20">
                        <div class="flex items-center gap-4 text-white">
                            <i class="fas fa-microchip text-3xl text-hero-orange"></i>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest opacity-60">Currently Deploying</p>
                                <p class="text-sm font-bold uppercase">AI/ML Core Integration v2.0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="relative py-32 md:py-48 overflow-hidden parallax-bg" 
         style="background-image: linear-gradient(rgba(27, 38, 79, 0.95), rgba(27, 38, 79, 0.95)), url('https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=1200');">
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
        <h2 class="text-4xl md:text-6xl font-black text-white uppercase italic tracking-tighter mb-8">
            Global <span class="text-hero-orange">Infrastructure</span> Delivery
        </h2>
        <p class="max-w-2xl mx-auto text-gray-400 font-medium">
            Our multi-node delivery system ensures that whether you are learning from a remote workstation or in a physical laboratory, the experience is zero-latency and high-fidelity.
        </p>
    </div>
</section>

<section class="py-16 md:py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative h-[400px] md:h-[600px] rounded-[3rem] overflow-hidden group">
                <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?auto=format&fit=crop&q=80&w=800" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                <div class="absolute inset-0 bg-hero-blue/20 mix-blend-overlay"></div>
            </div>
            
            <div class="lg:pl-12">
                <h2 class="text-3xl md:text-5xl font-black tracking-tighter mb-8 uppercase italic leading-none text-hero-blue">
                    Bridging the <br><span class="text-hero-orange">Academic Gap</span>
                </h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Universities often focus on theoretical concepts, leaving graduates unprepared for the practical challenges of modern engineering roles. Hero Technology fills this gap with hands-on, project-based learning.
                </p>
                <p class="text-gray-600 mb-10 leading-relaxed">
                    Our curriculum is designed by engineers from top-tier firms, ensuring that every lesson translates directly to the job site. We focus on real-world applications, industry tools, and the latest technologies to prepare our students for success.
                </p>
                <a href="about.php" class="inline-flex items-center gap-2 text-sm font-black text-hero-blue uppercase tracking-widest hover:text-hero-orange transition-colors">
                    Learn more <i class="fas fa-arrow-right"></i>
                </a>
                </div>
        </div>
    </div>
</section>

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

<section class="relative py-24 md:py-32 overflow-hidden bg-[var(--app-bg)]">
    
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.07] pointer-events-none" 
         style="background-image: radial-gradient(var(--text-main) 1px, transparent 1px); background-size: 30px 30px;"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="text-left">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-12 h-[2px] bg-hero-orange"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-hero-orange">Global Repository</span>
                </div>
                <h2 class="text-4xl md:text-6xl font-black tracking-tighter uppercase italic leading-none">
                    Premium <span class="text-hero-orange not-italic">Learning Tracks</span>
                </h2>
            </div>
            <a href="courses.php" class="mono text-[12px] font-bold uppercase tracking-widest border-b border-hero-orange pb-2 hover:text-hero-orange transition-all">
                Explore All Courses
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php 
                $result = mysqli_query($conn, "SELECT c.*, cat.category_name FROM courses c JOIN course_category cat ON c.category_id = cat.category_id WHERE c.status = 'publish' LIMIT 3");
                while($course = mysqli_fetch_assoc($result)): 
            ?>
            <div class="group relative bg-[var(--card-bg)] rounded-[2.5rem] border border-[var(--border)] overflow-hidden transition-all duration-500 hover:border-hero-orange/50 shadow-2xl shadow-black/5">
                
                <div class="h-64 relative overflow-hidden bg-slate-900">
                    <img src="assets/img/courses/<?= $course['thumbnail']; ?>" 
                         class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700 mix-blend-luminosity group-hover:mix-blend-normal">
                    
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-hero-orange/10 to-transparent h-full w-full -translate-y-full group-hover:animate-[scan_3s_linear_infinite] pointer-events-none"></div>
                    
                    <div class="absolute top-6 left-6 px-4 py-1.5 bg-black/40 backdrop-blur-md border border-white/10 rounded-full">
                        <span class="text-[8px] font-black uppercase tracking-widest text-white"><?= htmlspecialchars($course['category_name']); ?></span>
                    </div>
                </div>

                <div class="p-10">
                    <div class="flex items-center justify-between mb-4">
                        <span class="mono text-[9px] font-bold text-slate-500 uppercase tracking-tighter">Node ID: #<?= $course['course_id']; ?></span>
                        <div class="flex gap-1">
                            <div class="w-1 h-1 bg-hero-orange rounded-full animate-ping"></div>
                            <div class="w-1 h-1 bg-hero-orange rounded-full"></div>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-black uppercase tracking-tight mb-4 leading-snug">
                        <?= htmlspecialchars($course['title']); ?>
                    </h3>
                    
                    <p class="text-sm text-slate-500 font-medium leading-relaxed line-clamp-2 mb-8">
                        <?= htmlspecialchars($course['description']); ?>
                    </p>

                    <div class="flex items-center justify-between pt-8 border-t border-[var(--border)]">
                        <div>
                            <p class="text-[8px] font-black uppercase tracking-widest text-slate-400 mb-1">Tuition Fee</p>
                            <span class="text-2xl font-black italic text-hero-blue dark:text-hero-orange">₹<?= number_format($course['price'], 0); ?></span>
                        </div>
                        <a href="course-details.php?id=<?= $course['course_id']; ?>" 
                           class="bg-hero-blue dark:bg-white text-white dark:text-hero-blue px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-hero-orange dark:hover:bg-hero-orange dark:hover:text-white transition-all shadow-xl shadow-blue-500/10">
                            Enroll Now
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