<?php 
include 'header.php'; 

$message_sent = false;

if (isset($_POST['send_message'])) {
    // 1. Sanitize Incoming Data
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Handle Custom Subject Logic
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    if ($subject === 'Other' && !empty($_POST['custom_subject'])) {
        $subject = mysqli_real_escape_string($conn, $_POST['custom_subject']);
    }

    // 2. Database Synchronization
    $sql = "INSERT INTO contact_inquiries (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";
    
    if(mysqli_query($conn, $sql)) {
        
        // 3. Email Dispatch Protocol
        $to = "shahabhishek051@gmail.com";
        $email_subject = "NEW INQUIRY: [" . $subject . "] from " . $name;
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Hero Technology Solutions <noreply@herotechnologyinc.com>" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";

        $email_body = "
        <html>
        <head><title>New Dispatch</title></head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #1B264F;'>
            <div style='max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #E2E8F0; border-radius: 20px;'>
                <h2 style='color: #EE6C4D;'>New Intelligence Dispatch Received</h2>
                <hr style='border: 0; border-top: 1px solid #E2E8F0;'>
                <p><strong>Identity:</strong> $name</p>
                <p><strong>Node Email:</strong> $email</p>
                <p><strong>Protocol:</strong> $subject</p>
                <div style='background: #F8FAFC; padding: 15px; border-radius: 10px;'>
                    <strong>Message Content:</strong><br>
                    $message
                </div>
                <p style='font-size: 10px; color: #94A3B8; margin-top: 20px;'>Hero Technology Inc. - Automated Terminal Notification</p>
            </div>
        </body>
        </html>";

        // Dispatch Email
        @mail($to, $email_subject, $email_body, $headers);
        
        $message_sent = true;
    }
}
?>

<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />

<section class="relative pt-24 pb-20 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
        <span class="animate__animated animate__fadeInDown inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">
            Global Support Terminals
        </span>
        <h1 class="animate__animated animate__fadeInUp text-6xl md:text-7xl font-black tracking-tighter mb-8 leading-[0.95] text-hero-blue italic uppercase">
            Initialize <span class="text-hero-orange not-italic">Contact.</span>
        </h1>
        <p class="animate__animated animate__fadeInUp animate__delay-1s text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed font-medium">
            Our specialized technical support nodes are active across multiple timezones to assist with your software quality assurance and training requirements.
        </p>
    </div>
</section>

<section class="pb-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="animate__animated animate__fadeInLeft p-8 bg-gray-50 rounded-[2.5rem] border border-gray-100 group hover:border-hero-orange transition-all">
                    <div class="w-12 h-12 bg-hero-blue rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-blue-900/20">
                        <i class="fas fa-map-location-dot text-xl"></i>
                    </div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mb-3">Mainframe HQ</h4>
                    <p class="text-sm font-bold text-hero-blue leading-relaxed mb-4">
                        330, hwy 7, unit 305,<br>
                        Richmond Hill, ON L4B3P8<br>
                        Northville, USA
                    </p>
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-[10px] font-black uppercase text-gray-400 mb-2">Office Hours</p>
                        <p class="text-xs font-bold text-hero-orange">9:00 AM — 5:00 PM EST</p>
                    </div>
                </div>

                <div class="animate__animated animate__fadeInRight p-8 bg-hero-blue rounded-[2.5rem] text-white shadow-xl shadow-blue-900/10">
                    <div class="w-12 h-12 bg-hero-orange rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg">
                        <i class="fas fa-headset text-xl"></i>
                    </div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40 mb-4">Voice Dispatches</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-black uppercase text-white/50">Local</span>
                            <a href="tel:4372595097" class="text-sm font-bold">437-259-5097</a>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-black uppercase text-white/50">USA</span>
                            <a href="tel:+12246001985" class="text-sm font-bold">+1 224-600-1985</a>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-black uppercase text-white/50">India</span>
                            <div class="text-right text-sm font-bold">
                                <a href="https://wa.me/8320844367" class="block text-hero-orange">WhatsApp</a>
                                <a href="tel:+917383103800" class="block">+91 73831 03800</a>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-black uppercase text-white/50">UK</span>
                            <a href="tel:+447449860876" class="text-sm font-bold">+44 7449860876</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="animate__animated animate__fadeInUp bg-white p-8 sm:p-12 rounded-[3.5rem] border border-gray-100 shadow-[0_40px_100px_-20px_rgba(27,38,79,0.1)] relative overflow-hidden">
                    
                    <?php if ($message_sent): ?>
                        <div class="absolute inset-0 bg-white/95 backdrop-blur-md z-20 flex flex-col items-center justify-center p-8 text-center">
                            <img src="backpanel/assets/img/logo.png" class="h-10 mb-8" alt="Logo">
                            <div class="w-20 h-20 bg-emerald-500 rounded-full flex items-center justify-center text-white text-3xl mb-6 shadow-xl shadow-emerald-500/20">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <h3 class="text-3xl font-black uppercase italic text-hero-blue mb-2">Transmission Logged</h3>
                            <p class="text-gray-500 font-medium">Our engineering team will synchronize with your request shortly.</p>
                            <button onclick="window.location.reload()" class="mt-8 px-8 py-3 bg-hero-blue text-white rounded-xl font-black uppercase text-[10px] tracking-widest">Send New Dispatch</button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-8 relative z-10">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Full Name</label>
                                <input type="text" name="name" required placeholder="John Doe" 
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-hero-orange transition-all font-bold text-hero-blue">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Email Address</label>
                                <input type="email" name="email" required placeholder="johndoe@example.com" 
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-hero-orange transition-all font-bold text-hero-blue">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="relative">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Subject Protocol</label>
                                <div class="relative">
                                    <select name="subject" id="subject-select" required 
                                        class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-hero-orange transition-all font-black text-xs text-hero-blue uppercase appearance-none cursor-pointer">
                                        <option value="Corporate QA Solutions">Corporate QA Solutions</option>
                                        <option value="Course Inquiry">Course Inquiry</option>
                                        <option value="Partner Opportunities">Partner Opportunities</option>
                                        <option value="Technical Support">Technical Support</option>
                                        <option value="Other">Other (Specify Below)</option>
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-hero-blue/30">
                                        <i class="fas fa-chevron-down text-[10px]"></i>
                                    </div>
                                </div>
                            </div>

                            <div id="custom-subject-container" class="hidden animate__animated animate__fadeIn">
                                <label class="text-[10px] font-black uppercase tracking-widest text-hero-orange ml-2">Specify Custom Subject</label>
                                <input type="text" name="custom_subject" id="custom_subject" placeholder="Enter custom subject..." 
                                    class="w-full px-6 py-4 bg-gray-50 border border-hero-orange/30 rounded-2xl outline-none focus:border-hero-orange transition-all font-bold text-hero-blue">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Message Content</label>
                            <textarea name="message" required rows="5" placeholder="Enter your technical inquiry details here..." 
                                class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-hero-orange transition-all font-medium resize-none text-hero-blue"></textarea>
                        </div>

                        <button type="submit" name="send_message" class="w-full py-5 bg-hero-blue text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all uppercase tracking-[0.2em] text-[10px]">
                            Transmit Intelligence Node
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Intersection Observer for scroll-triggered animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.form-group-node').forEach((el) => observer.observe(el));

    // Validate.js Implementation for Contact Form
    const contactConstraints = {
        name: { presence: { allowEmpty: false, message: "^Identity Name required" } },
        email: { email: { message: "^Invalid Email Node" } },
        message: { length: { minimum: 10, message: "^Message content too short for processing" } }
    };

    const contactForm = document.querySelector('form');
    contactForm.addEventListener('submit', function(ev) {
        const values = validate.collectFormValues(contactForm);
        const errors = validate(values, contactConstraints);

        if (errors) {
            ev.preventDefault();
            alert(Object.values(errors)[0][0]);
        } else {
            // High-fidelity feedback: Change button text on transmit
            const btn = contactForm.querySelector('button');
            btn.innerHTML = '<i class="fas fa-sync fa-spin"></i> TRANSMITTING...';
            btn.style.opacity = '0.7';
        }
    });

    const subjectSelect = document.getElementById('subject-select');
    const customContainer = document.getElementById('custom-subject-container');
    const customInput = document.getElementById('custom_subject');

    subjectSelect.addEventListener('change', function() {
        if (this.value === 'Other') {
            customContainer.classList.remove('hidden');
            customInput.setAttribute('required', 'required');
            customInput.focus();
        } else {
            customContainer.classList.add('hidden');
            customInput.removeAttribute('required');
        }
    });
</script>

<?php include 'footer.php'; ?>