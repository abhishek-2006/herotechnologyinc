<?php
require '../config.php';

// 1. Session & Identity Verification
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 2. Fetch Instructor Intelligence Node
$instructor_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// Join with user_master to edit both identity and metadata
$qry = "SELECT i.* FROM instructors i 
        WHERE i.instructor_id = '$instructor_id'";
$result = mysqli_query($conn, $qry);

if(mysqli_num_rows($result) == 0) {
    header("Location: manage-instructors.php?msg=not_found");
    exit();
}

$instructor = mysqli_fetch_assoc($result);

// 3. Configuration Update Logic
if(isset($_POST['update_instructor'])) {
    // Identity Inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Technical Metadata Inputs
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $expertise = mysqli_real_escape_string($conn, $_POST['expertise']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience_years']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin_url']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {

        $uploadDir = "../assets/img/tutors/";

        $fileName = time() . "_" . basename($_FILES['profile_image']['name']);
        $targetPath = $uploadDir . $fileName;

        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileType, $allowedTypes)) {

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
                $profile_image = "../assets/img/tutors/" . $fileName;
            }

        } else {
            echo "Only JPG, JPEG, PNG, and WEBP files are allowed.";
        }
    }
    
    $update_inst = "UPDATE instructors SET 
                    name='$name', 
                    email='$email',
                    bio='$bio', 
                    expertise='$expertise', 
                    qualification='$qualification', 
                    experience_years='$experience', 
                    profile_image='$profile_image',
                    linkedin_url='$linkedin', 
                    status='$status'
                    WHERE instructor_id = '$instructor_id'";
    
    if(mysqli_query($conn, $update_inst)) {
        header("Location: manage-instructors.php?msg=update_success");
        exit();
    } else {
        $error = "SYNC_ERROR: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Faculty | Hero Admin Terminal</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
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
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--app-bg)] text-[var(--text-main)] antialiased min-h-screen flex overflow-hidden transition-colors duration-500">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex justify-between items-center mb-10">
            <div>
                <a href="manage-instructors.php" class="text-hero-orange text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-2">
                    <i class="fas fa-arrow-left"></i> Back to Instructors
                </a>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Modify <span class="text-hero-orange not-italic">Instructor</span></h1>
            </div>
            
            <button id="theme-toggle" class="w-10 h-10 rounded-xl bg-[var(--card-bg)] border border-[var(--border-dim)] flex items-center justify-center text-hero-orange shadow-sm cursor-pointer">
                <i class="fas fa-circle-half-stroke"></i>
            </button>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--card-bg)] p-10 rounded-[3rem] border border-[var(--border-color)] shadow-sm">
                    
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white border-l-4 border-hero-orange pl-4 mb-6">1. Account Identity</h3>    
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Legal Name<span class="text-red-500"> *</span></label>
                            <input type="text" name="name" value="<?= htmlspecialchars($instructor['name']) ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Corporate Email<span class="text-red-500"> *</span></label>
                            <input type="email" name="email" value="<?= htmlspecialchars($instructor['email']) ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                    </div>
                    <div class="space-y-2 mt-4">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">
                            Faculty Identity Photo<span class="text-red-500"> *</span>
                        </label>

                        <div class="flex items-center gap-6 p-6 bg-slate-50 dark:bg-black/40 rounded-3xl border-2 border-dashed border-[var(--border-color)]">

                            <label for="imgInput" class="w-20 h-20 rounded-2xl bg-[var(--card-bg)] flex items-center justify-center overflow-hidden border border-[var(--border-color)] cursor-pointer">
                                <img id="preview"
                                    src="<?= !empty($instructor['profile_image']) 
                                        ? 'uploads/tutors/' . htmlspecialchars($instructor['profile_image']) 
                                        : 'https://ui-avatars.com/api/?name=H+F&background=1B264F&color=fff' ?>"
                                    class="w-full h-full object-cover">
                            </label>

                            <div class="flex-1">
                                <input
                                    type="file"
                                    name="profile_image"
                                    id="imgInput"
                                    accept="image/*"
                                    required
                                    class="text-xs text-slate-500 cursor-pointer
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-[10px] file:font-black
                                    file:uppercase file:bg-hero-orange/10
                                    file:text-hero-orange
                                    hover:file:bg-hero-orange
                                    hover:file:text-white
                                    file:cursor-pointer
                                    transition-all"
                                >

                                <p class="text-[8px] text-slate-400 mt-2 uppercase tracking-widest">
                                    Recommended: Square Aspect Ratio (512x512px)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[var(--card-bg)] p-10 rounded-[3rem] border border-[var(--border-color)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue dark:text-white border-l-4 border-hero-orange pl-4 mb-6">2. Professional Biography</h3>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Professional Biography<span class="text-red-500"> *</span></label>
                        <textarea name="bio" rows="6" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required><?= htmlspecialchars($instructor['bio']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white border-l-4 border-hero-orange pl-4 mb-6">3. Technical Metadata</h3>
                    
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Core Expertise<span class="text-red-500"> *</span></label>
                            <input type="text" name="expertise" value="<?= htmlspecialchars($instructor['expertise']) ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Qualification<span class="text-red-500"> *</span></label>
                            <input type="text" name="qualification" value="<?= htmlspecialchars($instructor['qualification']) ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Years Active<span class="text-red-500"> *</span></label>
                            <input type="number" name="experience_years" value="<?= $instructor['experience_years'] ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" value="<?= htmlspecialchars($instructor['linkedin_url']) ?>" placeholder="https://www.linkedin.com/in/username" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Node Status</label>
                            <select name="status" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                                <option value="active" <?= ($instructor['status'] == 'active') ? 'selected' : '' ?>>Active (Authorize)</option>
                                <option value="suspended" <?= ($instructor['status'] == 'suspended') ? 'selected' : '' ?>>Suspended</option>
                                <option value="inactive" <?= ($instructor['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" name="update_instructor" class="w-full py-4 bg-hero-blue text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all uppercase tracking-widest text-[10px]">
                                <i class="fas fa-save mr-2"></i> Update Faculty
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        const imgInput = document.getElementById('imgInput');
        const preview = document.getElementById('preview');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        }

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