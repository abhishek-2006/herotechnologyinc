<?php 
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$course_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// Fetch Existing Data
$course_query = mysqli_query($conn, "SELECT * FROM courses WHERE course_id = '$course_id'");
$course = mysqli_fetch_assoc($course_query);

if (!$course) {
    header("Location: manage-courses.php?error=not_found");
    exit();
}

// Update Logic
if (isset($_POST['update_node'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);

    $thumb_name = $course['thumbnail'];
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumb_name = time() . "_" . $_FILES['thumbnail']['name'];
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "../assets/img/courses/" . $thumb_name);
    }

    $video_file = $course['video_file'];
    if (!empty($_FILES['video_file']['name'])) {
        $video_file = time() . "_" . $_FILES['video_file']['name'];
        move_uploaded_file($_FILES['video_file']['tmp_name'], "../assets/video/nodes/" . $video_file);
    }

    $update_sql = "UPDATE courses SET 
                   title='$title', category_id='$category_id', price='$price', 
                   status='$status', description='$description', video_url='$video_url', 
                   thumbnail='$thumb_name', video_file='$video_file' 
                   WHERE course_id='$course_id'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: manage-courses.php?msg=updated");
        exit();
    }
}

$categories = mysqli_query($conn, "SELECT * FROM course_category");
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Node | Hero Admin Terminal</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
            --color-app-bg: #F8FAFC;
            --color-side-bg: #FFFFFF;
            --color-border-dim: #E2E8F0;
            --color-text-main: #0F172A;
        }
        .dark {
            --color-app-bg: #020617;
            --color-side-bg: #0F172A;
            --color-border-dim: #1E293B;
            --color-text-main: #F8FAFC;
        }
        @utility form-input {
            width: 100%;
            padding: 0.85rem 1.25rem;
            background-color: var(--color-app-bg);
            border: 1px solid var(--color-border-dim);
            border-radius: 1rem;
            color: inherit;
            outline: none;
            transition: all 0.2s;
            &:focus { border-color: var(--color-hero-orange); box-shadow: 0 0 0 4px rgba(238, 108, 77, 0.1); }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--color-app-bg)] text-[var(--color-text-main)] antialiased min-h-screen flex overflow-hidden transition-colors duration-500">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex justify-between items-center mb-10">
            <div>
                <a href="manage-courses.php" class="text-hero-orange text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-2">
                    <i class="fas fa-arrow-left"></i> Terminal Return
                </a>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Modify <span class="text-hero-orange not-italic">Intelligence Node</span></h1>
            </div>
            
            <button onclick="toggleLocalTheme()" class="w-10 h-10 rounded-xl bg-[var(--color-side-bg)] border border-[var(--color-border-dim)] flex items-center justify-center text-hero-orange shadow-sm cursor-pointer">
                <i class="fas fa-circle-half-stroke"></i>
            </button>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--color-side-bg)] p-8 rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Node Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" class="form-input" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Curriculum Description</label>
                            <textarea name="description" rows="5" class="form-input"><?= htmlspecialchars($course['description']) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-[var(--color-side-bg)] p-8 rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white mb-6 border-l-4 border-hero-orange pl-4">Media Dispatch</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">External Stream URL</label>
                            <input type="url" name="video_url" value="<?= $course['video_url'] ?>" class="form-input" placeholder="YouTube/Vimeo">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Internal Node File (.mp4)</label>
                            <input type="file" name="video_file" class="form-input file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[9px] file:font-black file:bg-hero-blue file:text-white">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--color-side-bg)] p-8 rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Node Valuation (INR)</label>
                            <input type="number" name="price" value="<?= $course['price'] ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Category</label>
                            <select name="category_id" class="form-input">
                                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                    <option value="<?= $cat['category_id'] ?>" <?= ($cat['category_id'] == $course['category_id']) ? 'selected' : '' ?>><?= $cat['category_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Status</label>
                            <select name="status" class="form-input">
                                <option value="publish" <?= ($course['status'] == 'publish') ? 'selected' : '' ?>>Published</option>
                                <option value="draft" <?= ($course['status'] == 'draft') ? 'selected' : '' ?>>Draft</option>
                            </select>
                        </div>
                        <button type="submit" name="update_node" class="w-full py-4 bg-hero-blue text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all uppercase tracking-widest text-[10px]">
                            Save Configuration
                        </button>
                    </div>
                </div>

                <div class="bg-[var(--color-side-bg)] p-6 rounded-[2.5rem] border border-[var(--color-border-dim)]">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4 ml-1">Thumbnail Preview</label>
                    <div class="rounded-2xl overflow-hidden border border-[var(--color-border-dim)] aspect-video">
                        <img src="../assets/img/courses/<?= $course['thumbnail'] ?>" class="w-full h-full object-cover">
                    </div>
                    <input type="file" name="thumbnail" class="mt-4 text-[9px] file:bg-hero-blue/10 file:text-hero-blue file:border-0 file:px-3 file:py-1 file:rounded-lg">
                </div>
            </div>
        </form>
    </main>

    <script>
        // Use local storage to keep theme consistent with dashboard
        if(localStorage.getItem('theme') === 'light') document.documentElement.classList.remove('dark');
        
        function toggleLocalTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        }
    </script>
</body>
</html>