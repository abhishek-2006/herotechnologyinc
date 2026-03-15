<?php include 'header.php'; ?>
<style>
    .parallax-bg {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    html, body {
        max-width: 100%;
        overflow-x: hidden;
        overflow-y: scroll; 
    }

    .swiper-wrapper { 
        display: flex; 
        flex-direction: row !important;
    }

    .heroSwiper { 
        width: 100%; 
        height: auto; 
        margin-top: 0; 
        position: relative;
    }
    .swiper-slide { 
        flex-shrink: 0;
        width: 100%;
        height: 100%;
        opacity: 0; 
        transition: opacity 0.8s ease-in-out; 
    }
    .swiper-slide-active { opacity: 1 !important; }
</style>

<section class="relative bg-white dark:bg-slate-950 transition-colors duration-500 overflow-hidden pt-0">
    <div class="absolute top-0 left-0 w-full h-1 z-50 bg-slate-100 dark:bg-slate-900">
        <div id="slide-progress" class="h-full bg-hero-orange transition-all duration-[6000ms] ease-linear" style="width: 0%;"></div>
    </div>

    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            
            <?php
            $slides = [
                [
                    'tag' => 'Engineering Excellence',
                    'title' => 'Empowering the <span class="italic text-hero-orange">Next Generation</span> of Engineers.',
                    'desc' => 'Hero Technology Inc. bridges the gap between academic theory and industry reality with engineer-led technical training.',
                    'img' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800',
                    'status_icon' => 'fa-microchip',
                    'status_text' => 'AI/ML Core Integration v2.0'
                ],
                [
                    'tag' => 'Cyber Defense',
                    'title' => 'Hardening Infrastructure for <span class="italic text-hero-orange">Global Security</span>.',
                    'desc' => 'Master advanced threat detection and secure architecture through our specialized cybersecurity nodes.',
                    'img' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=800',
                    'status_icon' => 'fa-shield-halved',
                    'status_text' => 'Firewall Protocol X-7 active'
                ],
                [
                    'tag' => 'Full-Stack Development',
                    'title' => 'Architecting <span class="italic text-hero-orange">Scalable Ecosystems</span>.',
                    'desc' => 'Learn to build and deploy enterprise-grade applications using industry-standard tech stacks and DevOps workflows.',
                    'img' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&q=80&w=800',
                    'status_icon' => 'fa-code',
                    'status_text' => 'Deployment Node: Stable'
                ]
            ];

            foreach ($slides as $slide):
            ?>
            <div class="swiper-slide pt-12 pb-20 lg:pt-16 lg:pb-32">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                        <div class="text-center lg:text-left order-2 lg:order-1">
                            <span class="inline-block px-4 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-hero-blue dark:text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-6">
                                <?= $slide['tag'] ?>
                            </span>
                            <h1 class="slide-title text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black tracking-tighter mb-6 lg:mb-8 leading-[1.1] text-hero-blue dark:text-white">
                                <?= $slide['title'] ?>
                            </h1>
                            <p class="slide-desc text-base sm:text-lg text-gray-500 dark:text-slate-400 mb-8 lg:mb-10 leading-relaxed max-w-lg mx-auto lg:mx-0">
                                <?= $slide['desc'] ?>
                            </p>
                            
                            <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                                <a href="courses.php" class="px-10 py-4 bg-hero-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-hero-orange transition-all shadow-xl shadow-blue-900/20">Access Repository</a>
                            </div>
                        </div>

                        <div class="order-1 lg:order-2 px-4 relative">
                            <div class="aspect-square bg-gray-900 rounded-[4rem] overflow-hidden relative shadow-2xl border border-slate-100 dark:border-slate-800">
                                <img src="<?= $slide['img'] ?>" 
                                     class="w-full h-full object-cover opacity-60 mix-blend-luminosity grayscale hover:grayscale-0 transition-all duration-1000" 
                                     alt="Tech Node">
                                <div class="absolute inset-0 bg-gradient-to-t from-hero-blue via-transparent to-transparent opacity-60"></div>
                                
                                <div class="absolute bottom-10 left-10 right-10 bg-white/10 backdrop-blur-xl p-6 rounded-3xl border border-white/20">
                                    <div class="flex items-center gap-4 text-white text-left">
                                        <div class="w-12 h-12 rounded-xl bg-hero-orange/20 flex items-center justify-center">
                                            <i class="fas <?= $slide['status_icon'] ?> text-2xl text-hero-orange"></i>
                                        </div>
                                        <div>
                                            <p class="text-[9px] font-black uppercase tracking-widest opacity-60">System Status</p>
                                            <p class="text-xs font-bold uppercase tracking-tight"><?= $slide['status_text'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="relative py-32 md:py-48 overflow-x-hidden parallax-bg" 
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

<section class="animate__animated animate__fadeIn py-16 md:py-24 overflow-x-hidden bg-white relative">
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
            <div class="animate__animated animate__fadeInLeft animate__delay-1s p-6 md:p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-hero-orange transition-all">
                <div class="w-12 h-12 bg-hero-orange rounded-xl mb-6 flex items-center justify-center">
                    <i class="fas fa-globe text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 uppercase">Online Training</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Interactive, self-paced modules designed for the modern remote engineer. Access from anywhere.</p>
            </div>
            <div class="animate__animated animate__fadeInUp animate__delay-2s p-6 md:p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-hero-orange transition-all">
                <div class="w-12 h-12 bg-hero-orange rounded-xl mb-6 flex items-center justify-center">
                    <i class="fas fa-chalkboard-user text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 uppercase">Classroom Sessions</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Hands-on, instructor-led training at our state-of-the-art tech labs with high-performance hardware.</p>
            </div>
            <div class="animate__animated animate__fadeInRight animate__delay-3s p-6 md:p-8 rounded-3xl bg-white/5 border border-white/10 hover:border-hero-orange transition-all">
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
                $delay = 0;
                $result = mysqli_query($conn, "SELECT c.*, cat.category_name FROM courses c JOIN course_category cat ON c.category_id = cat.category_id WHERE c.status = 'publish' AND c.is_featured = 1 ORDER BY RAND() LIMIT 3");
                $delay_class = ($delay == 0) ? "" : "animate__delay-{$delay}s";
                while($course = mysqli_fetch_assoc($result)): 
            ?>
            <div class="animate__animated animate__fadeInUp <?= $delay_class ?> group relative bg-[var(--card-bg)] rounded-[2.5rem] border border-[var(--border)] overflow-hidden transition-all duration-500 hover:border-hero-orange/50 shadow-2xl shadow-black/5">
                
                <div class="h-64 relative overflow-hidden bg-slate-900">
                    <a href="course-details.php?id=<?= $course['course_id']; ?>" class="absolute inset-0 z-10">
                        <img src="assets/img/courses/<?= htmlspecialchars($course['thumbnail']); ?>" class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110 cursor-pointer" alt="Course Thumbnail">
                    </a>
                    
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-hero-orange/10 to-transparent h-full w-full -translate-y-full group-hover:animate-[scan_3s_linear_infinite] pointer-events-none"></div>
                    
                    <div class="absolute top-6 left-6 px-4 py-1.5 bg-black/40 backdrop-blur-md border border-white/10 rounded-full">
                        <span class="text-[8px] font-black uppercase tracking-widest text-white"><?= htmlspecialchars($course['category_name']); ?></span>
                    </div>
                </div>

                <div class="p-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex gap-1">
                            <div class="w-1 h-1 bg-hero-orange rounded-full animate-ping"></div>
                            <div class="w-1 h-1 bg-hero-orange rounded-full"></div>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-black uppercase tracking-tight mb-4 leading-snug">
                        <?= htmlspecialchars($course['title']); ?>
                    </h3>
                    
                    <p class="text-sm text-slate-500 font-medium leading-relaxed line-clamp-2 mb-8">
                        <?= htmlspecialchars($course['summary']); ?>
                    </p>

                    <p class="text-[8px] font-black uppercase tracking-widest text-slate-400 mb-1">Course Duration</p>
                    <span class="text-sm font-bold uppercase tracking-tight text-hero-blue">
                        <?php 
                            $minutes = $course['duration'] ?? 0;
                            $hours = $minutes / 60;
                            echo htmlspecialchars(number_format($hours, 2)) . ' Hrs';
                        ?>
                    </span>
                    
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
            <?php 
                $delay++;
                endwhile; 
                ?>
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

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const progressBar = document.getElementById('slide-progress');
        const slideDelay = 6000;

        const swiper = new Swiper('.heroSwiper', {
            direction: 'horizontal',
            loop: true,
            effect: 'fade',
            speed: 1000,
            fadeEffect: { crossFade: true },
            autoplay: {
                delay: slideDelay,
                disableOnInteraction: false,
            },
            on: {
                init: function() {
                    // Start first progress bar animation
                    setTimeout(() => progressBar.style.width = '100%', 50);
                },
                slideChangeTransitionStart: function () {
                    // Reset Progress Bar
                    progressBar.style.transition = 'none';
                    progressBar.style.width = '0%';
                    
                    // Re-trigger Title/Desc Animations
                    const titles = document.querySelectorAll('.slide-title');
                    titles.forEach(el => {
                        el.classList.remove('animate__fadeInDown');
                        void el.offsetWidth;
                        el.classList.add('animate__fadeInDown');
                    });
                },
                slideChangeTransitionEnd: function() {
                    // Restart Progress Bar Animation
                    progressBar.style.transition = `width ${slideDelay}ms linear`;
                    progressBar.style.width = '100%';
                }
            }
        });
    });
</script>