<?php 
require '../config.php';

// Authentication & Identity Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

function createSlug($string) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    return $slug;
}

if (isset($_POST['submit_course'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $instructor_id = mysqli_real_escape_string($conn, $_POST['instructor_id']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $summary = mysqli_real_escape_string($conn, $_POST['summary']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);
    $demo_video_url = mysqli_real_escape_string($conn, $_POST['demo_video_url']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $slug = createSlug($title);
    
    // 1. Handle Thumbnail Upload 
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {

        $uploadDir = "../assets/img/courses/";

        $fileName = time() . "_" . basename($_FILES['thumbnail']['name']);
        $targetPath = $uploadDir . $fileName;

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileExt, $allowed)) {

            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetPath)) {
                $thumbnail = "assets/img/courses/" . $fileName;
            }

        } else {
            echo "Only JPG, JPEG, PNG, and WEBP files are allowed.";
        }
    }


    // 2. Handle Video File Upload (Optional Internal Asset)
    $video_file = "";

    if (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === 0) {

        $uploadDir = "../assets/video/courses/";

        $fileName = time() . "_" . basename($_FILES['video_file']['name']);
        $targetPath = $uploadDir . $fileName;

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['mp4', 'webm', 'mov'];

        if (in_array($fileExt, $allowed)) {

            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $targetPath)) {
                $video_file = "assets/video/courses/" . $fileName;
            }

        } else {
            echo "Only MP4, WEBM, and MOV files are allowed.";
        }
    }

    // 3. Intelligence Insert Protocol
    $sql = "INSERT INTO courses (category_id, instructor_id, title, slug, summary, description, duration, video_url, video_file, demo_video_url, price, thumbnail, status, is_featured) 
            VALUES ('$category_id', '$instructor_id', '$title', '$slug', '$summary', '$description', '$duration', '$video_url', '$video_file', '$demo_video_url', '$price', '$thumbnail', '$status', $is_featured)";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: manage-courses.php?msg=course_deployed");
        exit();
    } else {
        $error = "System Error: " . mysqli_error($conn);
    }
}

// Fetch Dropdown Data Nodes
$categories = mysqli_query($conn, "SELECT * FROM course_category WHERE status='active'");
$instructors = mysqli_query($conn, "SELECT * FROM instructors WHERE status='active'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Admin | Deploy Course</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
        }
        :root {
            --app-bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --border-dim: #E2E8F0;
        }
        .dark {
            --app-bg: #020617;
            --card-bg: #0F172A;
            --border-dim: #1E293B;
        }
        @utility input-field {
            width: 100%;
            padding: 0.85rem 1.25rem;
            background-color: var(--app-bg);
            border: 1px solid var(--border-dim);
            border-radius: 1.25rem;
            color: inherit;
            outline: none;
            transition: all 0.2s;
            &:focus { border-color: var(--color-hero-orange); box-shadow: 0 0 0 4px rgba(238, 108, 77, 0.1); }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--app-bg)] text-slate-400 antialiased min-h-screen flex overflow-hidden transition-colors duration-500">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black tracking-tighter uppercase italic text-hero-blue dark:text-white leading-none">Course <span class="text-hero-orange not-italic">Deployment</span></h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] mt-2">Initialize New Learning Architecture</p>
            </div>
        </header>

        <?php if(isset($error)): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-500 text-[10px] font-black uppercase tracking-widest text-center">
                <i class="fas fa-exclamation-triangle mr-2"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
            
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue dark:text-white mb-6 border-l-4 border-hero-orange pl-4">Core Metadata</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Course Title</label>
                            <input type="text" name="title" class="input-field" placeholder="Full technical title..." required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Technical Summary</label>
                            <input type="text" name="summary" class="input-field" placeholder="Brief overview for catalog preview..." required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Course Description</label>
                            <textarea name="description" id="summernote" rows="5" class="input-field resize-none" placeholder="Deep dive into the module architecture..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white mb-6 border-l-4 border-hero-orange pl-4">Media Dispatch Hub</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Full Course URL (Vimeo/YouTube)</label>
                            <input type="url" name="video_url" class="input-field" placeholder="https://source.com/...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Internal Node Asset (.mp4)</label>
                            <input type="file" name="video_file" accept="video/mp4" class="input-field file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[9px] file:font-black file:bg-hero-blue/10 file:text-hero-blue">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Demo Lecture URL</label>
                        <input type="url" name="demo_video_url" class="input-field" placeholder="Public preview URL for demo modules...">
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Temporal Scale (Duration)</label>
                            <input type="text" name="duration" class="input-field" placeholder="e.g. 15 Hours" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Technical Category</label>
                            <select name="category_id" class="input-field" required>
                                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                    <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Valuation (INR)</label>
                            <input type="number" name="price" class="input-field" placeholder="0.00" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Instructor</label>
                            <select name="instructor_id" class="input-field" required>
                                <?php while($ins = mysqli_fetch_assoc($instructors)): ?>
                                    <option value="<?= $ins['instructor_id'] ?>"><?= $ins['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Visual Identity (Thumbnail)</label>
                            <input type="file" name="thumbnail" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-hero-blue/10 file:text-hero-blue hover:file:bg-hero-blue hover:file:text-white transition-all cursor-pointer" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Network Status</label>
                            <select name="status" class="input-field" required>
                                <option value="publish">Online (Publish)</option>
                                <option value="draft">Offline (Draft)</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_featured" id="is_featured" class="w-4 h-4 text-hero-orange bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-offset-0 focus:ring-hero-orange">
                            <label for="is_featured" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Flag as Featured Course</label>
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit_course" class="w-full py-5 bg-hero-blue text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all uppercase tracking-[0.2em] text-[10px]">
                    <i class="fas fa-rocket mr-2"></i> Add Course
                </button>
            </div>
        </form>
    </main>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Write your content here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        if(localStorage.getItem('theme') === 'light') document.documentElement.classList.remove('dark');

        const toggleBtn = document.getElementById("theme-toggle");
        const root = document.documentElement;

        // load saved theme
        if (localStorage.getItem("theme") === "dark") {
            root.classList.add("dark");
        }

        toggleBtn.addEventListener("click", () => {
            root.classList.toggle("dark");

            if (root.classList.contains("dark")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });
    </script>
</body>
</html>