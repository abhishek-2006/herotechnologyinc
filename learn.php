<?php
include 'header.php'; 
// 1. Authentication
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 1;
$user_email = $_SESSION['email'];

// Fetch User Identity
$user_res = mysqli_query($conn, "SELECT user_id, name FROM user_master WHERE email = '$user_email' LIMIT 1");
$user_data = mysqli_fetch_assoc($user_res);
$user_id = $user_data['user_id'];

// 2. Verify Enrollment
$enroll_check = mysqli_query($conn, "SELECT status FROM enrollments WHERE user_id = '$user_id' AND course_id = '$course_id' AND status = 'active'");
if (mysqli_num_rows($enroll_check) == 0) {
    header("Location: courses.php?error=access_denied");
    exit();
}

// 3. Fetch Course Media Node (Pulling from the table you provided)
$course_res = mysqli_query($conn, "SELECT * FROM courses WHERE course_id = '$course_id'");
$course = mysqli_fetch_assoc($course_res);

if (!$course) {
    header("Location: courses.php?error=not_found");
    exit();
}
?>

<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">

<div class="min-h-screen bg-[#F8FAFC] dark:bg-[#0A0A0B] transition-colors duration-500">
    <main class="max-w-6xl mx-auto px-4 py-10">
        <div class="aspect-video bg-black rounded-[2.5rem] overflow-hidden shadow-2xl border border-gray-200 dark:border-zinc-800 relative group">
            
            <div id="feedbackPopup" class="hidden absolute inset-0 bg-hero-blue/90 backdrop-blur-2xl flex flex-col items-center justify-center text-center p-12 z-50">
                <img src="backpanel/assets/img/logo.png" class="h-10 mb-6 brightness-0 invert opacity-20" alt="Hero Tech">
                <h2 class="text-3xl font-black uppercase italic text-white mb-2 tracking-tighter">Node Completed!</h2>
                <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-8">Your feedback helps maintain our curriculum intelligence.</p>
                
                <form action="process/save_review.php" method="POST" class="w-full max-w-sm">
                    <input type="hidden" name="course_id" value="<?= $course_id ?>">
                    
                    <div class="flex flex-row-reverse justify-center gap-2 mb-8 group/rating">
                        <?php for($i=5; $i>=1; $i--): ?>
                            <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" class="hidden peer" required>
                            <label for="star<?= $i ?>" 
                                class="cursor-pointer text-3xl text-zinc-600 
                                        peer-hover:text-hero-orange 
                                        peer-hover:~peer-hover:text-hero-orange
                                        peer-checked:text-hero-orange 
                                        peer-checked:~peer:text-hero-orange
                                        hover:scale-110 transition-all duration-200">
                                <i class="fas fa-star"></i>
                            </label>
                        <?php endfor; ?>
                    </div>

                    <textarea name="review" required 
                            placeholder="How was your learning experience? Share your technical insights..." 
                            class="w-full bg-white/10 border border-white/20 rounded-2xl p-4 text-white text-sm placeholder:text-white/30 focus:outline-none focus:border-hero-orange mb-6 h-32 transition-all"></textarea>
                    
                    <button type="submit" class="w-full py-4 bg-hero-orange text-white rounded-xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-orange-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Submit Intelligence Review
                    </button>
                </form>
            </div>

            <?php if (!empty($course['video_file'])): ?>
                <video id="mainVideo" controls autoplay class="w-full h-full" poster="assets/img/courses/<?php echo $course['thumbnail']; ?>">
                    <source src="assets/video/courses/<?php echo $course['video_file']; ?>" type="video/mp4">
                </video>

            <?php elseif (!empty($course['video_url'])): ?>
                <?php 
                    // Improved ID Parsing
                    preg_match("/(?:v=|\/embed\/|youtu\.be\/)([\w-]+)/", $course['video_url'], $matches);
                    $video_id = $matches[1] ?? "";
                    $embed_url = "https://www.youtube.com/embed/" . $video_id . "?enablejsapi=1&rel=0&modestbranding=1&autoplay=1";
                ?>
                <iframe id="ytPlayer" class="w-full h-full" src="<?= $embed_url ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php endif; ?>
        </div>
        
        </main>
</div>

<script>
    const popup = document.getElementById('feedbackPopup');

    // 1. Logic for HTML5 Local Video
    const localVideo = document.getElementById('mainVideo');
    if (localVideo) {
        localVideo.onended = function() {
            popup.classList.remove('hidden');
        };
    }

    // 2. Logic for YouTube IFrame
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('ytPlayer', {
            events: {
                'onStateChange': function(event) {
                    if (event.data == YT.PlayerState.ENDED) {
                        popup.classList.remove('hidden');
                    }
                }
            }
        });
    }

    function openManualReview() {
        popup.classList.remove('hidden');
    }
</script>

<?php include 'footer.php'; ?>