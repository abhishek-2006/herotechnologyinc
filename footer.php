</main> <footer class="bg-hero-blue text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-20 h-12 rounded-lg bg-white p-1 flex items-center justify-center overflow-hidden">
                            <img src="assets/img/logo.png" alt="Hero Tech" class="w-full h-full object-contain">
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs leading-relaxed font-medium">
                        Hero Technology Inc. provides industry-standard technical training designed by engineers, for engineers.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-hero-orange transition-colors"><i class="fab fa-linkedin-in text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-hero-orange transition-colors"><i class="fab fa-x-twitter text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-hero-orange transition-colors"><i class="fab fa-youtube text-xs"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-hero-orange mb-6">Training Nodes</h4>
                    <ul class="space-y-4 text-xs font-bold text-gray-400">
                        <li><a href="courses.php" class="hover:text-white transition-colors">All Courses</a></li>
                        <li><a href="training.php" class="hover:text-white transition-colors">Online Training</a></li>
                        <li><a href="classroom.php" class="hover:text-white transition-colors">Classroom Sessions</a></li>
                        <li><a href="corporate.php" class="hover:text-white transition-colors">Corporate Solutions</a></li>
                        <li><a href="signup.php" class="hover:text-white transition-colors">Register & Pay</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-hero-orange mb-6">Engineering Services</h4>
                    <ul class="space-y-4 text-xs font-bold text-gray-400">
                        <li><a href="staffing.php" class="hover:text-white transition-colors">Staffing Solutions</a></li>
                        <li><a href="staffing.php#jobs" class="hover:text-white transition-colors">Open Jobs</a></li>
                        <li><a href="clients.php" class="hover:text-white transition-colors">Our Clients</a></li>
                        <li><a href="certifications.php" class="hover:text-white transition-colors">Certifications</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-hero-orange mb-6">Support Terminal</h4>
                    <ul class="space-y-4 text-xs font-bold text-gray-400">
                        <li><a href="faqs.php" class="hover:text-white transition-colors">Common FAQs</a></li>
                        <li><a href="blog.php" class="hover:text-white transition-colors">Technical Blog</a></li>
                        <li><a href="contact.php" class="hover:text-white transition-colors">Contact Us</a></li>
                        <li class="pt-2">
                            <span class="block text-white mb-1">HQ Location</span>
                            <span class="text-[10px] font-medium leading-loose tracking-wider">
                                330, Hwy 7, Unit 305,
                                Richmond Hill, ON L4B3P8
                                Northville, USA
                            </span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="pt-10 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                    © 2026 Hero Technology Inc. All rights reserved.
                </p>
                <div class="flex items-center gap-8 grayscale opacity-40">
                    <i class="fas fa-certificate text-xl"></i>
                    <i class="fas fa-shield-halved text-xl"></i>
                    <i class="fas fa-medal text-xl"></i>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>