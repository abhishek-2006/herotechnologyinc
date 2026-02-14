<?php 
include 'header.php';

// Dynamic Intelligence Extraction
$course_query = mysqli_query($conn, "SELECT COUNT(*) FROM courses WHERE status = 'publish'");
$total_nodes = mysqli_fetch_row($course_query)[0];

$student_query = mysqli_query($conn, "SELECT COUNT(*) FROM user_master WHERE role = 'student'");
$total_alumni = mysqli_fetch_row($student_query)[0];

$clients_query = mysqli_query($conn, "SELECT COUNT(*) FROM corporate_clients WHERE status = 'active'");
$total_clients = mysqli_fetch_row($clients_query)[0];
?>

<link rel="icon" type="image/x-icon" href="backpanel/assets/img/favicon.ico" />

<section class="relative pt-24 pb-32 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-6">
            Establishing the Benchmark
        </span>
        <h1 class="text-6xl md:text-7xl font-black tracking-tighter mb-8 leading-[0.95] text-hero-blue italic uppercase">
            Quality. <span class="text-hero-orange not-italic">Efficiency.</span> Excellence.
        </h1>
        <p class="text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed font-medium">
            Hero Technology Solutions Inc. is a specialized technical node dedicated to helping clients deliver outstanding customer interactions through superior Software Quality Assurance.
        </p>
    </div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full opacity-5 pointer-events-none">
        <img src="backpanel/assets/img/logo.png" class="w-full h-full object-contain p-40" alt="Watermark">
    </div>
</section>

<section class="py-24 bg-hero-blue text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
            <div class="space-y-12">
                <div>
                    <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-orange mb-4">Our Mission</h2>
                    <p class="text-2xl md:text-3xl font-bold leading-snug italic">
                        "To provide our clients with the quality and efficiency that sets the benchmark for Software Quality Assurance and help deliver outstanding customer interactions."
                    </p>
                </div>
                <div class="pt-10 border-t border-white/10">
                    <h2 class="text-xs font-black uppercase tracking-[0.4em] text-hero-orange mb-4">Our Vision</h2>
                    <p class="text-xl text-gray-300 leading-relaxed">
                        To represent ourselves as the most preferred partner for corporate performance, people, services, and solutions for our clients to meet their IT challenges.
                    </p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white/5 p-8 rounded-[2.5rem] border border-white/10 backdrop-blur-sm">
                    <div class="w-12 h-12 bg-hero-orange rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-users-gear text-xl"></i>
                    </div>
                    <h4 class="text-lg font-black uppercase italic mb-2">Clients: First Priority</h4>
                    <p class="text-sm text-gray-400 leading-relaxed">Our priority is to improve clients’ management and control of costs to increase their business performance to maximum.</p>
                </div>
                <div class="bg-white/5 p-8 rounded-[2.5rem] border border-white/10 backdrop-blur-sm">
                    <div class="w-12 h-12 bg-hero-orange rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-gem text-xl"></i>
                    </div>
                    <h4 class="text-lg font-black uppercase italic mb-2">People: Most Valuable Asset</h4>
                    <p class="text-sm text-gray-400 leading-relaxed">We attract, inspire, and challenge the best people for our business and provide them with a supportive environment.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="text-5xl font-black text-hero-blue mb-2 transition-transform group-hover:scale-110">
                    <?= number_format($total_nodes); ?>+
                </div>
                <div class="flex items-center justify-center gap-2">
                    <img src="backpanel/assets/img/favicon.ico" class="w-3 h-3 opacity-30" alt="Fav">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-[0.3em]">Technical Nodes</p>
                </div>
            </div>

            <div class="text-center group border-l border-gray-50 md:border-l-0">
                <div class="text-5xl font-black text-hero-orange mb-2 transition-transform group-hover:scale-110">
                    <?= ($total_alumni >= 1000) ? number_format($total_alumni/1000, 1) . 'k+' : $total_alumni . '+'; ?>
                </div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-[0.3em]">Verified Alumni</p>
            </div>

            <div class="text-center group border-t border-gray-50 pt-8 md:pt-0 md:border-t-0">
                <div class="text-5xl font-black text-hero-blue mb-2 transition-transform group-hover:scale-110">
                    <?= $total_clients; ?>+
                </div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-[0.3em]">Corporate Clients</p>
            </div>

            <div class="text-center group border-t border-gray-50 border-l border-gray-50 pt-8 md:pt-0 md:border-t-0 md:border-l-0">
                <div class="text-5xl font-black text-hero-orange mb-2 transition-transform group-hover:scale-110">98%</div>
                <p class="text-[10px] font-black uppercase text-gray-400 tracking-[0.3em]">Deployment Rate</p>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="text-hero-blue font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">Global Partnerships</span>
        <h2 class="text-4xl font-black tracking-tight italic uppercase mb-16">Trusted by <span class="text-hero-orange">Industry Giants</span></h2>
        
        <div class="flex flex-wrap justify-center items-center gap-x-12 gap-y-10 opacity-50 grayscale hover:grayscale-0 transition-all duration-700">
            <?php 
                $clients = ['AT&T', 'Pfizer', 'Citigroup', 'Nestle', 'Bayer', 'Bosch', 'Cisco', 'Hitachi', 'Verizon', 'Energizer'];
                foreach($clients as $client):
            ?>
            <span class="text-xl md:text-2xl font-black tracking-tighter text-hero-blue uppercase italic"><?= $client ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-white">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <div class="p-16 bg-hero-blue rounded-[4rem] relative overflow-hidden group">
            <div class="relative z-10 text-white">
                <img src="backpanel/assets/img/logo.png" class="h-10 mx-auto mb-8 brightness-0 invert" alt="Hero Logo">
                <h2 class="text-4xl font-black tracking-tight mb-8 italic uppercase">Ready to join the <span class="text-hero-orange not-italic">Curriculum?</span></h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="courses.php" class="bg-hero-orange text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest text-xs shadow-xl shadow-orange-500/20 active:scale-95 transition-all">Initialize Learning</a>
                    <a href="contact.php" class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-10 py-4 rounded-xl font-black uppercase tracking-widest text-xs hover:bg-white/20 transition-all">Request Consultation</a>
                </div>
            </div>
            <i class="fas fa-bolt-lightning absolute -right-10 -bottom-10 text-[15rem] text-hero-orange opacity-10 rotate-12"></i>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>