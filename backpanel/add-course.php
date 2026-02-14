<?php 
require '../config.php';

// Authentication & Identity Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit_course'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $instructor_id = mysqli_real_escape_string($conn, $_POST['instructor_id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);
    
    // 1. Handle Thumbnail Upload
    $thumbnail = time() . "_" . $_FILES['thumbnail']['name'];
    $thumb_target = "../assets/img/courses/" . $thumbnail;
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumb_target);

    // 2. Handle Video File Upload (Optional if URL is provided)
    $video_file = "";
    if (!empty($_FILES['video_file']['name'])) {
        $video_file = time() . "_" . $_FILES['video_file']['name'];
        $video_target = "../assets/video/nodes/" . $video_file;
        move_uploaded_file($_FILES['video_file']['tmp_name'], $video_target);
    }

    $sql = "INSERT INTO courses (category_id, instructor_id, title, description, price, thumbnail, video_url, video_file, status) 
            VALUES ('$category_id', '$instructor_id', '$title', '$description', '$price', '$thumbnail', '$video_url', '$video_file', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: manage-courses.php?msg=node_deployed");
    } else {
        $error = "System Error: " . mysqli_error($conn);
    }
}

// Fetch Dropdown Data
$categories = mysqli_query($conn, "SELECT * FROM course_category WHERE status='active'");
$instructors = mysqli_query($conn, "SELECT user_id, name FROM user_master WHERE role IN ('admin', 'manager')");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Admin | Deploy Node</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
            --color-app-bg: #F8FAFC;
            --color-side-bg: #FFFFFF;
            --color-border-dim: #E2E8F0;
        }
        .dark {
            --color-app-bg: #020617;
            --color-side-bg: #0F172A;
            --color-border-dim: #1E293B;
        }
        @utility input-field {
            width: 100%;
            padding: 0.85rem 1rem;
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
<body class="bg-[var(--color-app-bg)] text-slate-400 antialiased min-h-screen flex overflow-hidden">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black tracking-tighter uppercase italic text-hero-blue dark:text-white leading-none">Initialize <span class="text-hero-orange not-italic">Deployment</span></h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] mt-2">New Curriculum Node Setup</p>
            </div>
        </header>

        <form action="" method="post" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--color-side-bg)] p-8 rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white mb-6 border-l-4 border-hero-orange pl-4">Core Metadata</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Node Title</label>
                            <input type="text" name="title" class="input-field" placeholder="Full technical title..." required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Description Dispatch</label>
                            <textarea name="description" rows="5" class="input-field resize-none" placeholder="Explain the curriculum architecture..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-[var(--color-side-bg)] p-8 rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white mb-6 border-l-4 border-hero-orange pl-4">Video Intelligence Hub</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">External URL (YouTube/Vimeo)</label>
                            <input type="url" name="video_url" class="input-field" placeholder="https://youtube.com/watch?v=...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Internal Raw File (.mp4)</label>
                            <input type="file" name="video_file" accept="video/mp4" class="input-field file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[9px] file:font-black file:bg-hero-blue/10 file:text-hero-blue">
                        </div>
                    </div>
                    <p class="mt-4 text-[9px] font-bold text-slate-400 italic">Note: Use External URL for streaming efficiency or Raw File for localized secure hosting.</p>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--color-side-bg)] p-8 rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Technical Category</label>
                            <select name="category_id" class="input-field" required>
                                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                    <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Node Valuation (INR)</label>
                            <input type="number" name="price" class="input-field" placeholder="0.00" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Lead Instructor</label>
                            <select name="instructor_id" class="input-field" required>
                                <?php while($ins = mysqli_fetch_assoc($instructors)): ?>
                                    <option value="<?= $ins['user_id'] ?>"><?= $ins['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Node Visual Identity</label>
                            <input type="file" name="thumbnail" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-hero-blue/10 file:text-hero-blue hover:file:bg-hero-blue hover:file:text-white transition-all cursor-pointer" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Deployment Status</label>
                            <select name="status" class="input-field" required>
                                <option value="publish">Publish Node</option>
                                <option value="draft">Save to Drafts</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit_course" class="w-full py-5 bg-hero-blue text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all uppercase tracking-[0.2em] text-[10px]">
                    Authorize Deployment
                </button>
            </div>
        </form>
    </main>
</body>
</html>