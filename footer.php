</main> 
<footer class="bg-hero-blue text-white pt-20 pb-10 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-20 h-12 rounded-lg bg-white p-1 flex items-center justify-center overflow-hidden shadow-lg">
                        <?php if (isset($_SESSION['username']) || isset($_SESSION['email']) || isset($_SESSION['user_id'])): ?>
                            <a href="dashboard.php" class="w-full h-full flex items-center justify-center">
                                <img src="assets/img/logo.png" alt="Hero Tech" class="animate__animated animate__fadeInLeft animate__delay-500ms w-full h-full object-contain">
                            </a>
                        <?php else: ?>
                            <a href="index.php" class="w-full h-full flex items-center justify-center">
                                <img src="assets/img/logo.png" alt="Hero Tech" class="animate__animated animate__fadeInLeft animate__delay-500ms w-full h-full object-contain">
                            </a>
                        <?php endif; ?>
                        </a>
                    </div>
                </div>
                <p class="text-gray-400 text-xs leading-relaxed font-medium">
                    Hero Technology Inc. provides industry-standard technical training designed by engineers, for engineers.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-hero-orange transition-all hover:-translate-y-1"><i class="fab fa-linkedin-in text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-hero-orange transition-all hover:-translate-y-1"><i class="fab fa-x-twitter text-xs"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-hero-orange transition-all hover:-translate-y-1"><i class="fab fa-youtube text-xs"></i></a>
                </div>
            </div>

            <div>
                <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-hero-orange mb-6">Training Nodes</h4>
                <ul class="space-y-4 text-xs font-bold text-gray-400">
                    <li><a href="courses.php" class="hover:text-white hover:pl-2 transition-all duration-300">All Courses</a></li>
                    <li><a href="training.php" class="hover:text-white hover:pl-2 transition-all duration-300">Online Training</a></li>
                    <li><a href="classroom.php" class="hover:text-white hover:pl-2 transition-all duration-300">Classroom Sessions</a></li>
                    <li><a href="corporate.php" class="hover:text-white hover:pl-2 transition-all duration-300">Corporate Solutions</a></li>
                    <?php if (isset($_SESSION['username']) || isset($_SESSION['email']) || isset($_SESSION['user_id'])): ?>
                        <li><a href="dashboard.php" class="hover:text-white hover:pl-2 transition-all duration-300">My Dashboard</a></li>
                    <?php else: ?>
                        <li><a href="signup.php" class="hover:text-white hover:pl-2 transition-all duration-300">Register</a></li>
                        <li><a href="login.php" class="hover:text-white hover:pl-2 transition-all duration-300">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div>
                <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-hero-orange mb-6">Engineering Services</h4>
                <ul class="space-y-4 text-xs font-bold text-gray-400">
                    <li><a href="staffing.php" class="hover:text-white hover:pl-2 transition-all duration-300">Staffing Solutions</a></li>
                    <li><a href="staffing.php#jobs" class="hover:text-white hover:pl-2 transition-all duration-300">Open Jobs</a></li>
                    <li><a href="clients.php" class="hover:text-white hover:pl-2 transition-all duration-300">Our Clients</a></li>
                    <li><a href="certifications.php" class="hover:text-white hover:pl-2 transition-all duration-300">Certifications</a></li>
                    <li><a href="our-team.php" class="hover:text-white hover:pl-2 transition-all duration-300">Our Team</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-hero-orange mb-6">Support Terminal</h4>
                <ul class="space-y-4 text-xs font-bold text-gray-400">
                    <li><a href="faqs.php" class="hover:text-white transition-colors">Common FAQs</a></li>
                    <li><a href="blog.php" class="hover:text-white transition-colors">Technical Blog</a></li>
                    <li><a href="contact.php" class="hover:text-white transition-colors">Contact Us</a></li>
                    <li class="pt-2 border-t border-white/5 mt-4">
                        <span class="block text-white mb-1">HQ Location</span>
                        <span class="text-[10px] font-medium leading-loose tracking-wider opacity-60">
                            330, Hwy 7, Unit 305, Richmond Hill, ON<br>Northville, USA
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-10 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
            <a href="https://itsoulinfotech.com" target="_blank" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest hover:text-white transition-colors">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest hover:text-white transition-colors">
                    Made with <i class="fas fa-heart text-red-500 mx-1"></i> by ItSoul Infotech
                </p>
            </a>

            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest transition-colors">
                © 2026 Hero Technology Inc. All rights reserved.
            </p>
            <div class="flex items-center gap-8 grayscale opacity-40 hover:opacity-100 transition-opacity">
                <i class="fas fa-certificate text-xl"></i>
                <i class="fas fa-shield-halved text-xl"></i>
                <i class="fas fa-medal text-xl"></i>
            </div>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        /** 1. Search Logic Node (Safe Initialization) **/
        const searchInput = document.getElementById('courseSearch');
        const courseGrid = document.getElementById('courseGrid');
        
        if (searchInput && courseGrid) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const cards = document.querySelectorAll('.course-card');
                let visibleCount = 0;

                cards.forEach(card => {
                    const title = card.getAttribute('data-title') || "";
                    if (title.includes(searchTerm)) {
                        card.style.display = 'block';
                        card.classList.remove('animate__fadeInUp'); 
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (visibleCount === 0 && searchTerm !== "") {
                    courseGrid.classList.add('animate__animated', 'animate__headShake');
                    setTimeout(() => courseGrid.classList.remove('animate__headShake'), 500);
                }
            });
        }

        /** 2. Intersection Observer (Global Reveal Node) **/
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    
                    if (el.classList.contains('reveal')) el.classList.add('animate__fadeInUp');
                    if (el.classList.contains('reveal-obj')) el.classList.add('animate__fadeInUp');
                    if (el.classList.contains('reveal-rev')) el.classList.add('animate__zoomIn');
                    if (el.classList.contains('animate-on-scroll')) el.classList.add('animate__fadeIn');
                    if (el.id === 'newsletter-node') el.classList.add('animate__fadeIn');
                    
                    revealObserver.unobserve(el); // Performance: stop watching once triggered
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal, .reveal-obj, .reveal-rev, .animate-on-scroll, #newsletter-node').forEach(el => {
            revealObserver.observe(el);
        });

        /** 3. Smooth Scroll Node **/
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });
    });

    /** 4. Identity Copy Function **/
    function copyNodeLink(btn, text) {
        navigator.clipboard.writeText(text);
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check-circle mr-2 text-emerald-500"></i> NODE COPIED';
        btn.classList.add('bg-emerald-50', 'border-emerald-200');
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.classList.remove('bg-emerald-50', 'border-emerald-200');
        }, 2000);
    }
</script>
</body>
</html>