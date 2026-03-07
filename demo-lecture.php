<?php
include 'header.php';

$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;
$ip = $_SERVER['REMOTE_ADDR'];
$limit_minutes = 5.0; 

// Fetch Course Data
$course_query = "SELECT title, demo_video_url FROM courses WHERE course_id = '$course_id' LIMIT 1";
$course_res = mysqli_query($conn, $course_query);
$course_data = mysqli_fetch_assoc($course_res);

// Parse YouTube ID
$v_id = "";
if ($course_data && !empty($course_data['demo_video_url'])) {
    preg_match("/(?:v=|\/embed\/|youtu\.be\/)([\w-]+)/", $course_data['demo_video_url'], $matches);
    $v_id = $matches[1] ?? "";
}

// Check initial usage
$fingerprint = isset($_COOKIE['device_node_id']) ? mysqli_real_escape_string($conn, $_COOKIE['device_node_id']) : 'unknown';
$usage_query = "SELECT minutes_watched FROM demo_usage_logs WHERE (ip_address = '$ip' OR device_fingerprint = '$fingerprint') AND course_id = '$course_id' LIMIT 1";
$usage_res = mysqli_query($conn, $usage_query);
$usage = mysqli_fetch_assoc($usage_res);
$current_minutes = $usage ? (float)$usage['minutes_watched'] : 0;

$messages = ["Did you like the course?", "Are you interested in mastering this?", "Want to see the full curriculum?", "Ready to upgrade your skills?"];
$random_msg = $messages[array_rand($messages)];
?>

<main class="bg-black min-h-screen text-white py-20 overflow-hidden">
    <div class="max-w-5xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8 animate__animated animate__fadeInDown">
            <h1 class="text-xl font-black italic uppercase tracking-widest text-hero-orange">
                <i class="fas fa-play-circle"></i> <?= htmlspecialchars($course_data['title']) ?>
            </h1>
            <img src="assets/img/logo.png" class="h-8 opacity-80 brightness-0 invert" alt="Hero Logo">
        </div>

        <div class="animate__animated animate__zoomIn aspect-video bg-zinc-900 rounded-[3rem] overflow-hidden shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-zinc-800 relative">

            <div class="absolute inset-0 pointer-events-none opacity-10 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] z-10 bg-[length:100%_2px,3px_100%]"></div>
            
            <div id="lockoutOverlay" class="<?= ($current_minutes >= $limit_minutes) ? '' : 'hidden' ?> absolute inset-0 bg-hero-blue/95 backdrop-blur-3xl flex flex-col items-center justify-center text-center p-12 z-50 animate__animated animate__fadeIn">
                <div class="animate__animated animate__bounceIn">
                    <i class="fas fa-lock text-5xl text-hero-orange mb-6"></i>
                    <h2 class="text-3xl font-black uppercase italic mb-4 tracking-tighter"><?= $random_msg ?></h2>
                    <p class="text-blue-200 text-sm max-w-sm mb-10 font-medium leading-relaxed uppercase tracking-widest opacity-60">Demo Node Access Expired</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 w-full justify-center items-center">
                        <a href="signup.php?id=<?= $course_id ?>" class="bg-hero-orange text-white px-12 py-4 rounded-xl font-black uppercase text-[10px] tracking-[0.2em] shadow-xl shadow-orange-500/20 hover:scale-105 transition-transform active:scale-95">Enroll Now</a>
                        <a href="courses.php" class="bg-white/5 border border-white/10 text-white px-10 py-4 rounded-xl font-black uppercase text-[10px] tracking-[0.2em] hover:bg-white/10 transition-colors">Explore Others</a>
                    </div>
                </div>
            </div>

            <?php if ($v_id): ?>
                <iframe id="demoPlayer" class="w-full h-full opacity-80 group-hover:opacity-100 transition-opacity duration-700" src="https://www.youtube.com/embed/<?= $v_id ?>?autoplay=1&enablejsapi=1" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>
        </div>
        <div class="mt-8 flex justify-between items-center text-[9px] font-mono uppercase tracking-[0.3em] text-zinc-500 animate__animated animate__fadeIn animate__delay-2s">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div> Stream Active</span>
                <span>Node: <?= $fingerprint ?></span>
            </div>
            <div id="timeStatus">Usage: <?= $current_minutes ?> / <?= $limit_minutes ?> MIN</div>
        </div>
    </div>
</main>

<script>
let currentMins = <?= $current_minutes ?>;
const limitMins = <?= $limit_minutes ?>;
const courseId = <?= $course_id ?>;

function generateFingerprint() {
    const canvas = document.createElement('canvas');
    const gl = canvas.getContext('webgl');
    const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
    const renderer = gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
    const id = btoa(navigator.userAgent + screen.width + renderer).substring(0, 32);
    document.cookie = "device_node_id=" + id + "; path=/; max-age=31536000";
    return id;
}

const fId = generateFingerprint();

// DYNAMIC RUNTIME CHECK
const heartbeat = setInterval(function() {
    if (currentMins >= limitMins) {
        showLockout();
        clearInterval(heartbeat);
        return;
    }

    // Update DB and get fresh time from server response
    fetch(`process/update_usage.php?cid=${courseId}&f=${fId}`)
        .then(response => response.json())
        .then(data => {
            currentMins = parseFloat(data.new_time);
            if (currentMins >= limitMins) {
                showLockout();
                clearInterval(heartbeat);
            }
        });
}, 30000); // Check every 30 seconds

function showLockout() {
    const overlay = document.getElementById('lockoutOverlay');
    const player = document.getElementById('demoPlayer');
    
    overlay.classList.remove('hidden');
    overlay.classList.add('animate__animated', 'animate__fadeIn');
    if (player) {
        player.style.transition = "all 0.5s ease";
        player.style.filter = "blur(10px) grayscale(1)";
        setTimeout(() => {
            player.src = "";
            player.remove();
        }, 500);
    }
}
</script>