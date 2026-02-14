<?php 
include 'header.php'; 

$sqlClients = "SELECT client_name FROM corporate_clients WHERE status = 'active' ORDER BY is_featured DESC, client_name ASC";
$resClients = mysqli_query($conn, $sqlClients);
?>

<link rel="icon" type="image/x-icon" href="backpanel/assets/img/favicon.ico" />

<section class="relative pt-20 pb-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">
            Institutional Trust & Deployment
        </span>
        <h1 class="text-6xl md:text-7xl font-black tracking-tighter mb-8 leading-[0.95] text-hero-blue italic uppercase">
            Global <span class="text-hero-orange not-italic">Alliances.</span>
        </h1>
        <p class="text-lg text-gray-500 max-w-3xl mx-auto leading-relaxed font-medium">
            Hero Technology Solutions Inc. serves as the primary technical upskilling node and software quality assurance partner for the world's leading enterprises.
        </p>
    </div>
</section>

<section class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-xs font-black uppercase tracking-[0.5em] text-gray-300 mb-4">The Manifest</h2>
            <h3 class="text-4xl font-black text-hero-blue italic uppercase">Trusted by <span class="text-hero-orange not-italic">Industry Giants</span></h3>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-8 gap-y-12">
            <?php while($client = mysqli_fetch_assoc($resClients)): ?>
            <div class="text-center group">
                <p class="text-sm font-black text-slate-400 uppercase tracking-tighter group-hover:text-hero-blue transition-colors cursor-default">
                    <?= htmlspecialchars($client['client_name']) ?>
                </p>
                <div class="h-0.5 w-0 group-hover:w-full bg-hero-orange mx-auto mt-2 transition-all duration-500"></div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-hero-blue text-white overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-16 items-center">
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-black tracking-tight mb-8 uppercase italic leading-tight">
                    Human Capital <br><span class="text-hero-orange not-italic">Optimization.</span>
                </h2>
                <p class="text-gray-300 mb-10 leading-relaxed font-medium">
                    Our priority is to improve clients’ management and control of costs to increase their business performance to maximum.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10 hover:bg-white/10 transition-all">
                        <i class="fas fa-layer-group text-hero-orange"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Enterprise Learning Paths</span>
                    </div>
                    <div class="flex items-center gap-4 bg-white/5 p-4 rounded-2xl border border-white/10 hover:bg-white/10 transition-all">
                        <i class="fas fa-user-plus text-hero-orange"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Direct-to-Hire Pipelines</span>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-1/2 w-full">
                <div class="bg-white rounded-[3.5rem] p-10 md:p-16 text-center shadow-2xl">
                    <img src="backpanel/assets/img/logo.png" class="h-10 mx-auto mb-8" alt="Hero Logo">
                    <i class="fas fa-handshake-angle text-6xl text-hero-orange mb-6"></i>
                    <h3 class="text-2xl font-black text-hero-blue uppercase mb-4 italic">Initialize Partnership</h3>
                    <p class="text-gray-400 text-xs mb-10 leading-relaxed font-bold uppercase tracking-widest">Bridging Information Technology Challenges Together.</p>
                    <a href="contact.php" class="inline-block w-full bg-hero-blue text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-[10px] shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all active:scale-95">
                        Transmit Proposal
                    </a>
                </div>
            </div>
        </div>
    </div>
    <img src="backpanel/assets/img/favicon.ico" class="absolute -left-10 -bottom-10 w-40 opacity-5" alt="Favicon">
</section>

<?php include 'footer.php'; ?>