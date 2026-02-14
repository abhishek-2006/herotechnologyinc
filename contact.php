<?php 
include 'header.php'; 

// 1. Handle Inquiry Transmission (Procedural mysqli)
$message_sent = false;
if (isset($_POST['send_message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Logic to insert into contact_inquiries table if it exists
    $sql = "INSERT INTO contact_inquiries (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    if(mysqli_query($conn, $sql)) {
        $message_sent = true;
    }
}
?>

<link rel="icon" type="image/x-icon" href="backpanel/assets/img/favicon.ico" />

<section class="relative pt-24 pb-20 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
        <span class="inline-block px-4 py-1.5 bg-blue-50 text-hero-blue text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">
            Global Support Terminals
        </span>
        <h1 class="text-6xl md:text-7xl font-black tracking-tighter mb-8 leading-[0.95] text-hero-blue italic uppercase">
            Initialize <span class="text-hero-orange not-italic">Contact.</span>
        </h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed font-medium">
            Our specialized technical support nodes are active across multiple timezones to assist with your software quality assurance and training requirements.
        </p>
    </div>
</section>

<section class="pb-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="p-8 bg-gray-50 rounded-[2.5rem] border border-gray-100 group hover:border-hero-orange transition-all">
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

                <div class="p-8 bg-hero-blue rounded-[2.5rem] text-white shadow-xl shadow-blue-900/10">
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
                <div class="bg-white p-8 sm:p-12 rounded-[3.5rem] border border-gray-100 shadow-[0_40px_100px_-20px_rgba(27,38,79,0.1)] relative overflow-hidden">
                    
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

                    <form action="" method="POST" class="space-y-8 relative z-10">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Identity Name</label>
                                <input type="text" name="name" required placeholder="John Doe" 
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-hero-orange transition-all font-bold text-hero-blue">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Email Node</label>
                                <input type="email" name="email" required placeholder="johndoe@example.com" 
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-hero-orange transition-all font-bold text-hero-blue">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-2">Subject Protocol</label>
                            <select name="subject" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl outline-none focus:border-hero-orange transition-all font-black text-xs text-hero-blue uppercase appearance-none">
                                <option value="Corporate QA Solutions">Corporate QA Solutions</option>
                                <option value="Curriculum Inquiry">Curriculum Inquiry</option>
                                <option value="Partner Opportunities">Partner Opportunities</option>
                                <option value="Technical Support">Technical Support</option>
                            </select>
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


<?php include 'footer.php'; ?>