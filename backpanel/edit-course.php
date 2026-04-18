<?php 
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

function generateTechnicalSlug($text) {
    // 1. Convert to lowercase and trim whitespace
    $text = strtolower(trim($text));

    // 2. Replace non-letters/numbers (Unicode) with a hyphen
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // 3. Remove duplicate hyphens (e.g. --- to -)
    $text = preg_replace('~-+~', '-', $text);

    // 4. Trim leading/trailing hyphens
    return trim($text, '-');
}

$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// Fetch Existing Intelligence Node
$course_query = mysqli_query($conn, "SELECT * FROM courses WHERE course_id = '$course_id'");
$course = mysqli_fetch_assoc($course_query);

if (!$course) {
    header("Location: manage-courses.php?error=not_found");
    exit();
}

// Configuration Update Logic
if (isset($_POST['update_course'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $instructor_id = mysqli_real_escape_string($conn, $_POST['instructor_id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $summary = mysqli_real_escape_string($conn, $_POST['summary']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);
    $slug = generateTechnicalSlug($title);

    // Asset Management: Thumbnail
    $thumb_name = $course['thumbnail'];
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumb_name = time() . "_" . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "../assets/img/courses/" . $thumb_name);
    }

    $video_file = $course['video_file']; 

    if (!empty($_FILES['video_file']['name'])) {
        // 1. Prepare Metadata
        $ext = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
        $new_video_name = $slug . "." . $ext;
        $target_dir = "../assets/video/courses/";
        $target_path = $target_dir . $new_video_name;

        // 2. Cleanup Protocol: Delete the old file if it exists and is different
        if (!empty($course['video_file']) && file_exists($target_dir . $course['video_file'])) {
            unlink($target_dir . $course['video_file']); 
        }

        // 3. Move the fresh dispatch to the repository
        if (move_uploaded_file($_FILES['video_file']['tmp_name'], $target_path)) {
            $video_file = $new_video_name;
        }
    } else {
        // 4. Handle Title Changes: If the title (slug) changed but no new file was uploaded, 
        // we should rename the existing file to match the new slug.
        if (!empty($course['video_file']) && $course['slug'] !== $slug) {
            $old_ext = pathinfo($course['video_file'], PATHINFO_EXTENSION);
            $renamed_video = $slug . "." . $old_ext;
            
            if (file_exists("../assets/video/courses/" . $course['video_file'])) {
                rename("../assets/video/courses/" . $course['video_file'], "../assets/video/courses/" . $renamed_video);
                $video_file = $renamed_video;
            }
        }
    }

    $update_sql = "UPDATE courses SET 
                   title='$title', slug='$slug', category_id='$category_id', instructor_id='$instructor_id', 
                   price='$price', status='$status', description='$description', 
                   video_url='$video_url', thumbnail='$thumb_name', video_file='$video_file', 
                   duration='$duration', summary='$summary'
                   WHERE course_id='$course_id'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: manage-courses.php?msg=updated");
        exit();
    }
}

// Fetch Supportive Data Nodes
$categories = mysqli_query($conn, "SELECT * FROM course_category");
$instructors = mysqli_query($conn, "SELECT * FROM instructors");
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course | Hero Admin Terminal</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
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
            --text-main: #1B264F;
            --border-dim: #E2E8F0;
        }
        .dark {
            --app-bg: #020617;
            --card-bg: #0F172A;
            --text-main: #F8FAFC;
            --border-dim: #1E293B;
        }
        @utility form-input {
            width: 100%;
            padding: 0.85rem 1.25rem;
            background-color: var(--app-bg);
            border: 1px solid var(--border-dim);
            border-radius: 1.25rem;
            color: inherit;
            outline: none;
            transition: all 0.2s;
            font-size: 0.875rem;
            &:focus { border-color: var(--color-hero-orange); box-shadow: 0 0 0 4px rgba(238, 108, 77, 0.1); }
        }
        .note-editor {
            background: var(--app-bg) !important;
            border: 1px solid var(--border-dim) !important;
            border-radius: 1.5rem !important;
            overflow: hidden;
        }
        .note-toolbar {
            background: var(--card-bg) !important;
            border-bottom: 1px solid var(--border-dim) !important;
        }
        .note-editable {
            background: var(--app-bg) !important;
            color: var(--text-main) !important;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--app-bg)] text-[var(--text-main)] antialiased min-h-screen flex overflow-hidden transition-colors duration-500">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex justify-between items-center mb-10">
            <div>
                <a href="manage-courses.php" class="text-hero-orange text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-2">
                    <i class="fas fa-arrow-left"></i> Back to Courses
                </a>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Modify <span class="text-hero-orange not-italic">Course</span></h1>
            </div>
            
            <button id="theme-toggle" class="w-10 h-10 rounded-xl bg-[var(--card-bg)] border border-[var(--border-dim)] flex items-center justify-center text-hero-orange shadow-sm cursor-pointer">
                <i class="fas fa-circle-half-stroke"></i>
            </button>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Course Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Technical Summary (Short Description)</label>
                            <input type="text" name="summary" value="<?= htmlspecialchars($course['summary']) ?>" class="form-input" placeholder="Brief technical overview for catalog display">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Full Course Description</label>
                            <textarea name="description" id="summernote" rows="6" class="form-input"><?= htmlspecialchars($course['description']) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white mb-6 border-l-4 border-hero-orange pl-4">Media Stream</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">External Stream URL</label>
                            <div class="relative">
                                <input type="url" name="video_url" 
                                    value="<?= htmlspecialchars($course['video_url']) ?>" 
                                    class="form-input pr-12" 
                                    placeholder="Enter YouTube/Vimeo Source">
                                <?php if (!empty($course['video_url'])): ?>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-hero-blue opacity-50">
                                        <i class="fas fa-link text-xs"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="relative group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Internal Video File (.mp4)</label>
                            <div class="relative flex items-center">
                                <input type="file" name="video_file" id="video_file" 
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="updateFileName(this)">
                                
                                <div class="form-input flex items-center justify-between pr-4 z-10 pointer-events-none overflow-hidden">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <span class="px-3 py-1 bg-hero-blue text-white text-[9px] font-black rounded-lg uppercase whitespace-nowrap">Choose File</span>
                                        <span id="file-name-display" class="text-xs font-bold truncate opacity-70">
                                            <?= !empty($course['video_file']) ? htmlspecialchars($course['video_file']) : 'No file chosen' ?>
                                        </span>
                                    </div>
                                    <?php if (!empty($course['video_file'])): ?>
                                        <i class="fas fa-file-video text-hero-orange text-xs"></i>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Deployment Valuation (INR)</label>
                            <input type="number" name="price" value="<?= $course['price'] ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Duration (in Minutes)</label>
                            <input type="text" name="duration" value="<?= htmlspecialchars($course['duration']) ?>" class="form-input" placeholder="e.g. 120 for 2 hours">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Assigned Instructor</label>
                            <select name="instructor_id" class="form-input">
                                <?php while($inst = mysqli_fetch_assoc($instructors)): ?>
                                    <option value="<?= $inst['instructor_id'] ?>" <?= ($inst['instructor_id'] == $course['instructor_id']) ? 'selected' : '' ?>><?= $inst['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Course Category</label>
                            <select name="category_id" class="form-input">
                                <?php mysqli_data_seek($categories, 0); ?>
                                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                    <option value="<?= $cat['category_id'] ?>" <?= ($cat['category_id'] == $course['category_id']) ? 'selected' : '' ?>><?= $cat['category_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Network Status</label>
                            <select name="status" class="form-input">
                                <option value="publish" <?= ($course['status'] == 'publish') ? 'selected' : '' ?>>Publish </option>
                                <option value="draft" <?= ($course['status'] == 'draft') ? 'selected' : '' ?>>Draft Mode</option>
                            </select>
                        </div>
                        <button type="submit" name="update_course" class="cursor-pointer w-full py-4 bg-hero-blue text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all uppercase tracking-widest text-[10px]">
                            Update Course
                        </button>
                    </div>
                </div>

                <div class="bg-[var(--card-bg)] p-6 rounded-[2.5rem] border border-[var(--border-dim)]">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4 ml-1">Thumbnail</label>
                    <div class="rounded-2xl overflow-hidden border border-[var(--border-dim)] aspect-video bg-slate-50 dark:bg-black/20">
                        <img src="../assets/img/courses/<?= $course['thumbnail'] ?>" class="w-full h-full object-cover">
                    </div>
                    <input type="file" name="thumbnail" class="cursor-pointer mt-4 text-[9px] file:bg-hero-blue/10 file:text-hero-blue file:border-0 file:px-3 file:py-1 file:rounded-lg">
                </div>
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
 
        function updateFileName(input) {
            const display = document.getElementById('file-name-display');
            if (input.files && input.files[0]) {
                display.textContent = input.files[0].name;
                display.classList.remove('opacity-70');
                display.classList.add('text-hero-orange');
            }
        }
    </script>
    <script src="assets/js/theme.js"></script>
</body>
</html>