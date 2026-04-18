<?php 
require 'config.php';
$pageTitle = "Our Team - Hero Technology Inc.";
include 'header.php';
?>

<section class="relative py-24 bg-slate-50 dark:bg-[#020617] transition-colors duration-500 overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-20 dark:opacity-10">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-hero-blue rounded-full blur-[120px]"></div>
        <div class="absolute top-1/2 -right-24 w-80 h-80 bg-hero-orange rounded-full blur-[100px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        
        <div class="text-center mb-24" data-aos="fade-down">
            <?php if(file_exists('assets/img/logo.png')): ?>
                <img src="assets/img/logo.png" alt="Logo" class="h-12 mx-auto mb-6 dark:brightness-200">
            <?php endif; ?>
            
            <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter text-hero-blue dark:text-white">
                Meet <span class="text-hero-orange">Our Team</span>
            </h1>
            <div class="w-24 h-2 bg-hero-orange mx-auto mt-6 rounded-full shadow-[0_0_15px_rgba(238,108,77,0.5)]"></div>
        </div>

        <div class="mb-32">
            <div class="text-center mb-16" data-aos="fade-up">
                <h3 class="text-2xl md:text-3xl font-black italic uppercase tracking-widest text-hero-blue dark:text-slate-300">Core Leadership</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php
                $coreTeam = [
                    ['name' => 'Executive Alpha', 'role' => 'Chief Strategic Officer', 'desc' => 'Overseeing the strategic direction and operational execution.'],
                    ['name' => 'Founder', 'role' => 'Founder & Visionary', 'desc' => 'Leading the vision and development of Hero Technology Inc.'],
                    ['name' => 'Co-Founder', 'role' => 'Co-Founder', 'desc' => 'Supporting the growth and expansion of Hero Technology Inc.']
                ];

                foreach($coreTeam as $index => $member):
                ?>
                <div data-aos="zoom-in" data-aos-delay="<?= $index * 100 ?>" 
                     class="group relative bg-white/70 dark:bg-slate-900/50 backdrop-blur-md rounded-[2.5rem] p-10 text-center border border-white dark:border-slate-800 shadow-xl hover:shadow-hero-orange/10 transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-hero-orange/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2.5rem]"></div>
                    
                    <div class="relative mb-8 inline-block">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($member['name']) ?>&background=1B264F&color=fff&size=256" 
                             class="w-36 h-36 rounded-[3rem] mx-auto object-cover grayscale group-hover:grayscale-0 transition-all duration-700 shadow-2xl">
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-hero-orange rounded-full flex items-center justify-center text-white border-4 border-white dark:border-slate-900">
                            <i class="fas fa-crown text-xs"></i>
                        </div>
                    </div>
                    
                    <h4 class="text-2xl font-black uppercase tracking-tight text-hero-blue dark:text-white mb-2"><?= $member['name'] ?></h4>
                    <p class="text-[10px] font-black text-hero-orange uppercase tracking-[0.3em] mb-6"><?= $member['role'] ?></p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed"><?= $member['desc'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mb-40">
            <div class="text-center mb-20" data-aos="fade-up">
                <h3 class="text-3xl md:text-5xl font-black italic uppercase text-hero-blue dark:text-white leading-none">
                    Expert <span class="text-hero-orange not-italic">Faculties</span>
                </h3>
                <div class="w-32 h-2 bg-hero-orange mx-auto mt-8 rounded-full shadow-[0_0_20px_rgba(238,108,77,0.3)]"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 max-w-6xl mx-auto">
                <?php
                $tutor_query = "SELECT * FROM tutors WHERE status = 'active' ORDER BY tutor_id ASC";
                $tutor_result = mysqli_query($conn, $tutor_query);

                if(mysqli_num_rows($tutor_result) > 0):
                    $delay = 0;
                    while ($tutor = mysqli_fetch_assoc($tutor_result)):
                        $tutor_photo = "assets/img/tutors/" . $tutor['profile_image'];
                ?>
                <div data-aos="fade-up" data-aos-delay="<?= $delay ?>" 
                     class="group relative bg-white dark:bg-slate-900 rounded-[4rem] overflow-hidden border border-slate-100 dark:border-slate-800 transition-all duration-700 hover:shadow-[0_40px_80px_-20px_rgba(27,38,79,0.3)] hover:-translate-y-5">
                    
                    <div class="absolute top-0 left-0 w-full h-3 bg-gradient-to-r from-hero-blue to-hero-orange group-hover:h-4"></div>

                    <div class="p-12">
                        <div class="relative w-56 h-56 mx-auto mb-10">
                            <div class="absolute inset-0 rounded-[3.5rem] animate-spin-slow transition-transform duration-700"></div>
                            
                            <img src="<?= $tutor_photo ?>" alt="<?= htmlspecialchars($tutor['name']) ?>" 
                                class="relative z-10 w-full h-full rounded-[3.8rem] object-cover shadow-2xl grayscale group-hover:grayscale-0 group-hover:rotate-2 transition-all duration-700"/>
                        </div>
                        
                        <div class="text-center">
                            <h4 class="text-2xl md:text-3xl font-black uppercase tracking-tight text-hero-blue dark:text-white group-hover:text-hero-orange transition-colors duration-300">
                                <?= htmlspecialchars($tutor['name']) ?>
                            </h4>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-2 mb-6">
                                <?= htmlspecialchars($tutor['qualification']) ?>
                            </p>
                            
                            <div class="mb-8">
                                <span class="px-6 py-2.5 bg-hero-blue/5 dark:bg-white/5 text-hero-blue dark:text-slate-200 text-xs font-black uppercase tracking-widest rounded-2xl border border-hero-blue/10 dark:border-white/10 group-hover:bg-hero-orange group-hover:text-white group-hover:border-hero-orange transition-all duration-500">
                                    <?= htmlspecialchars($tutor['expertise']) ?>
                                </span>
                            </div>

                            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-3xl p-6 flex items-center justify-between border border-slate-100 dark:border-slate-800 group-hover:border-hero-orange/20 transition-all duration-500">
                                <div class="text-left">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Industry Exp.</p>
                                    <p class="text-lg font-black text-hero-blue dark:text-white"><?= htmlspecialchars($tutor['experience_years']) ?>+ Years</p>
                                </div>
                                <a href="mailto:<?= htmlspecialchars($tutor['email']) ?>" class="w-12 h-12 rounded-2xl bg-hero-orange text-white flex items-center justify-center hover:scale-110 active:scale-95 shadow-lg shadow-hero-orange/20 transition-all">
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <?php 
                    $delay += 150;
                    endwhile; 
                endif; 
                ?>
            </div>
        </div>

        <div class="relative py-20" data-aos="zoom-in-up">
            <div class="bg-hero-blue dark:bg-slate-900 text-white rounded-[4rem] p-1 max-w-6xl mx-auto shadow-2xl overflow-hidden group">
                <div class="bg-white/5 backdrop-blur-2xl rounded-[3.8rem] p-10 md:p-16 flex flex-col lg:flex-row items-center gap-12">
                    
                    <div class="relative shrink-0">
                        <div class="absolute -inset-4 bg-hero-orange rounded-[4rem] opacity-30 blur-2xl group-hover:opacity-50 transition-all duration-700"></div>
                        <div class="relative z-10 w-56 h-56 md:w-72 md:h-72 rounded-[3.5rem] overflow-hidden border-4 border-white/20 shadow-2xl">
                            <a href="https://abhishekshah-portfolio.vercel.app" target="_blank" rel="noopener noreferrer">
                                <img src="assets/img/abhishek.jpg" alt="Abhishek Shah" class="w-full h-full object-cover">
                            </a>
                        </div>
                    </div>

                    <div class="text-center lg:text-left">
                        <span class="inline-block px-4 py-1 bg-hero-orange/20 text-hero-orange text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-4">Lead Developer</span>
                        <h2 class="text-4xl md:text-5xl font-black italic uppercase tracking-tighter mb-4 text-white">
                            Abhishek Shah
                        </h2>
                        <p class="text-slate-300 leading-relaxed mb-8 max-w-2xl text-base font-medium">
                            Technical architect specializing in high-fidelity interface deployment. Designed and engineered the 
                            <span class="text-hero-orange">Hero Technology Inc.</span> ecosystem during an intensive software engineering internship at 
                            <a href="https://itsoulinfotech.com" target="_blank" class="text-white font-bold italic underline decoration-hero-orange decoration-2 underline-offset-4">ItSoul Infotech</a>.
                        </p>

                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                            <a href="mailto:shahabhishek051@gmail.com" class="px-10 py-4 bg-hero-orange text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-white hover:text-hero-blue transition-all active:scale-95 shadow-lg shadow-hero-orange/20">
                                <i class="fas fa-paper-plane mr-2"></i> Hire Me
                            </a>
                            <div class="flex gap-3">
                                <a href="https://github.com/abhishek-2006" target="_blank" class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center hover:bg-white hover:text-hero-blue transition-all border border-white/10">
                                    <i class="fab fa-github text-xl"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/abhishekshah-dev" target="_blank" class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center hover:bg-[#0077b5] transition-all border border-white/10">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>
                                <a href="https://x.com/shahabhishek409" target="_blank" class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center hover:bg-black dark:hover:bg-gray-800 transition-all border border-white/10">
                                    <i class="fab fa-x-twitter text-xl"></i>
                                </a>
                                <a href="https://instagram.com/abhishekshah_112/" target="_blank"
                                    class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center cursor-pointer hover:bg-gradient-to-br hover:from-[#f58529] hover:via-[#dd2a7b] hover:to-[#8134af] transition-all border border-white/10">
                                        <i class="fab fa-instagram text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
</script>

<?php include 'footer.php'; ?>