<?php 
include 'header.php'; 

$sqlClients = "SELECT client_name FROM corporate_clients WHERE status = 'active' ORDER BY is_featured DESC, client_name ASC";
$resClients = mysqli_query($conn, $sqlClients);
?>

<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />

<section class="relative pt-20 pb-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
        <span class="animate__animated animate__fadeInDown inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">
            Institutional Trust & Deployment
        </span>
        <h1 class="animate__animated animate__zoomIn text-6xl md:text-7xl font-black tracking-tighter mb-8 leading-[0.95] text-hero-blue italic uppercase">
            Global <span class="text-hero-orange not-italic">Alliances.</span>
        </h1>
        <p class="animate__animated animate__fadeInUp animate__delay-1s text-lg text-gray-500 max-w-3xl mx-auto leading-relaxed font-medium">
            Hero Technology Solutions Inc. serves as the primary technical upskilling node and software quality assurance partner for the world's leading enterprises.
        </p>
    </div>
</section>

<section class="py-20 bg-gray-50/50 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-xl shadow-blue-900/[0.03] group hover:border-hero-orange transition-all duration-500">
                <div class="w-12 h-12 bg-hero-blue rounded-2xl flex items-center justify-center text-white mb-6 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-handshake-angle text-xl"></i>
                </div>
                <h4 class="text-lg font-black text-hero-blue uppercase italic mb-3">Strategic <span class="text-hero-orange">Nodes</span></h4>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">Co-developing next-generation QA frameworks with global technology leaders to set new industry standards.</p>
            </div>

            <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-xl shadow-blue-900/[0.03] group hover:border-hero-orange transition-all duration-500">
                <div class="w-12 h-12 bg-hero-blue rounded-2xl flex items-center justify-center text-white mb-6 group-hover:rotate-12 transition-transform">
                    <i class="fas fa-university text-xl"></i>
                </div>
                <h4 class="text-lg font-black text-hero-blue uppercase italic mb-3">Academic <span class="text-hero-orange">Uplink</span></h4>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">Partnering with premier institutions like AMTICS, UTU to bridge the gap between academia and production-grade engineering.</p>
            </div>

            <div class="bg-hero-blue p-10 rounded-[3rem] shadow-2xl shadow-blue-900/20 text-white flex flex-col justify-between group">
                <div>
                    <h4 class="text-lg font-black uppercase italic mb-3">Become a <span class="text-hero-orange">Partner</span></h4>
                    <p class="text-xs text-white/60 leading-relaxed font-medium mb-6">Initialize a partnership dispatch to integrate your organization into our global excellence network.</p>
                </div>
                <a href="contact.php?subject=Partner Opportunities" class="inline-flex items-center justify-center w-full py-4 bg-hero-orange text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-white hover:text-hero-blue transition-all">
                    Initiate Handshake <i class="fas fa-arrow-right ml-2 text-[8px]"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-xs font-black uppercase tracking-[0.5em] text-gray-300 mb-4">The Manifest</h2>
            <h3 class="text-4xl font-black text-hero-blue italic uppercase">Trusted by <span class="text-hero-orange not-italic">Industry Giants</span></h3>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-8 gap-y-12">
            <?php 
            $i=0;
            while($client = mysqli_fetch_assoc($resClients)):
                $delay = ($i % 10) * 0.1; 
            ?>
            <div class="text-center group">
                <p class="animate__animated animate__fadeInUp text-sm font-black text-slate-400 uppercase tracking-tighter group-hover:text-hero-blue transition-colors cursor-default" style="animation-delay: <?= $delay ?>s;">
                    <?= htmlspecialchars($client['client_name']) ?>
                </p>
                <div class="h-0.5 w-0 group-hover:w-full bg-hero-orange mx-auto mt-2 transition-all duration-500"></div>
            </div>
            <?php 
                $i++;
                endwhile; 
            ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>