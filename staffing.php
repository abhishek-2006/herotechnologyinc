<?php include 'header.php'; 

// 1. Fetch Live Job Nodes (Procedural mysqli)
$sqlJobs = "SELECT * FROM courses WHERE category_id = (SELECT category_id FROM course_category WHERE category_name LIKE '%Staffing%' OR category_name LIKE '%Job%' LIMIT 1) AND status = 'publish' LIMIT 4";
$resJobs = mysqli_query($conn, $sqlJobs);
?>

<section class="relative pt-12 pb-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-4">
            Deployment Division
        </span>
        <h1 class="text-4xl md:text-6xl font-black tracking-tighter mb-6 leading-tight text-hero-blue italic uppercase">
            Sourcing <span class="text-hero-orange not-italic">Elite Talent.</span>
        </h1>
        <p class="text-base text-gray-500 max-w-2xl mx-auto leading-relaxed px-4 font-medium">
            We don't just train engineers; we deploy them. Our staffing node connects Hero-certified professionals with global technology partners.
        </p>
    </div>
</section>

<section class="py-16 bg-gray-50 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <i class="fas fa-user-check text-2xl text-hero-orange mb-4"></i>
                <h3 class="text-sm font-black uppercase tracking-widest text-hero-blue mb-3">Direct Hire</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Permanent placement of verified engineers into your core technical teams.</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <i class="fas fa-file-contract text-2xl text-hero-blue mb-4"></i>
                <h3 class="text-sm font-black uppercase tracking-widest text-hero-blue mb-3">Contract-to-Hire</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Risk-free trial periods to ensure technical and cultural alignment before full onboarding.</p>
            </div>
            <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <i class="fas fa-users-gear text-2xl text-hero-orange mb-4"></i>
                <h3 class="text-sm font-black uppercase tracking-widest text-hero-blue mb-3">Managed Teams</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Scalable, project-based engineering pods managed directly by our technical leads.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div class="text-center md:text-left">
                <span class="text-hero-orange font-black uppercase tracking-[0.3em] text-[10px]">Career Nodes</span>
                <h2 class="text-3xl font-black tracking-tight mt-2 italic uppercase">Current Openings</h2>
            </div>
            <a href="contact.php" class="text-[10px] font-black uppercase tracking-widest border-b-2 border-hero-blue pb-1">Register as Partner</a>
        </div>

        <div class="space-y-4">
            <?php 
            if (mysqli_num_rows($resJobs) > 0):
                while($job = mysqli_fetch_assoc($resJobs)): 
            ?>
            <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 active:scale-[0.98] transition-all">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-hero-blue border border-gray-100">
                        <i class="fas fa-code"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-sm uppercase text-hero-blue mb-1"><?php echo htmlspecialchars($job['title']); ?></h4>
                        <div class="flex gap-3 items-center">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest"><i class="fas fa-location-dot mr-1"></i> Remote / Node-01</span>
                            <span class="text-[9px] font-bold text-hero-orange uppercase tracking-widest"><i class="fas fa-bolt mr-1"></i> Full-Time</span>
                        </div>
                    </div>
                </div>
                <a href="contact.php?subject=Job_Application&ref=<?php echo $job['course_id']; ?>" class="w-full sm:w-auto text-center bg-hero-blue text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-[9px]">Apply Node</a>
            </div>
            <?php 
                endwhile; 
            else:
            ?>
            <div class="p-12 border-2 border-dashed border-gray-100 rounded-[3rem] text-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">New opportunities are currently synchronizing...</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-hero-blue text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/3 text-center lg:text-left">
                <h2 class="text-3xl font-black italic uppercase tracking-tighter mb-6">Partner <br><span class="text-hero-orange not-italic">Feedback.</span></h2>
                <p class="text-gray-400 text-sm leading-relaxed">How Hero Technology is transforming technical recruitment for our corporate nodes.</p>
            </div>
            <div class="lg:w-2/3">
                <div class="bg-white/5 border border-white/10 p-8 sm:p-10 rounded-[3rem]">
                    <i class="fas fa-quote-right text-3xl text-hero-orange mb-6"></i>
                    <p class="text-lg text-gray-300 italic mb-8 leading-relaxed">
                        "The quality of engineers we've hired through Hero's staffing pipeline is unparalleled. They don't just know how to code; they know how to build systems."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center overflow-hidden p-1">
                            <img src="assets/img/logo.jpg" class="w-full h-full object-contain grayscale" alt="Client Logo">
                        </div>
                        <div>
                            <p class="font-black uppercase text-xs tracking-tight">HR Director</p>
                            <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">InnovateX Engineering Group</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>