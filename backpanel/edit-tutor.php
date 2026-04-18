<?php
require '../config.php';

// 1. Session & Identity Verification
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

// 2. Fetch Tutor Intelligence Node
$tutor_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

$qry = "SELECT i.* FROM tutors i 
        WHERE i.tutor_id = '$tutor_id'";
$result = mysqli_query($conn, $qry);

if(mysqli_num_rows($result) == 0) {
    header("Location: manage-tutors.php?msg=not_found");
    exit();
}

$tutor = mysqli_fetch_assoc($result);

// 3. Configuration Update Logic
if(isset($_POST['update_tutor'])) {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $expertise = mysqli_real_escape_string($conn, $_POST['expertise']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience_years']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin_url']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

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

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {

        $uploadDir = "../assets/img/tutors/";
        $name_slug = generateTechnicalSlug($name);

        $fileType = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        $fileName = "tutor_" . $name_slug . "." . $fileType;
        $targetPath = $uploadDir . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileType, $allowedTypes)) {

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
                $profile_image = $fileName;
            }

        } else {
            echo "Only JPG, JPEG, PNG, and WEBP files are allowed.";
        }
    }
    
    $update_tutor = "UPDATE tutors SET 
                    name='$name', 
                    email='$email',
                    bio='$bio', 
                    expertise='$expertise', 
                    qualification='$qualification', 
                    experience_years='$experience', 
                    profile_image='$profile_image',
                    linkedin_url='$linkedin', 
                    status='$status'
                    WHERE tutor_id = '$tutor_id'";
    
    if(mysqli_query($conn, $update_tutor)) {
        header("Location: manage-tutors.php?msg=update_success");
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
                <a href="manage-tutors.php" class="text-hero-orange text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-2">
                    <i class="fas fa-arrow-left"></i> Back to Tutors
                </a>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Modify <span class="text-hero-orange not-italic">Tutor</span></h1>
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
                            <input type="text" name="name" value="<?= htmlspecialchars($tutor['name']) ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Corporate Email<span class="text-red-500"> *</span></label>
                            <input type="email" name="email" value="<?= htmlspecialchars($tutor['email']) ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                    </div>
                    <div class="space-y-2 mt-4">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">
                            Faculty Photo<span class="text-red-500"> *</span>
                        </label>

                        <div class="flex items-center gap-6 p-6 bg-slate-50 dark:bg-black/40 rounded-3xl border-2 border-dashed border-[var(--border-color)]">

                            <label for="imgInput" class="w-20 h-20 rounded-2xl bg-[var(--card-bg)] flex items-center justify-center overflow-hidden border border-[var(--border-color)] cursor-pointer">
                                <img id="preview"
                                    src="<?= !empty($tutor['profile_image']) 
                                        ? '../assets/img/tutors/' . htmlspecialchars($tutor['profile_image']) 
                                        : 'https://ui-avatars.com/api/?name=H+F&background=1B264F&color=fff' ?>"
                                    class="w-full h-full object-cover">
                            </label>

                            <div class="flex-1 relative">
                                <input type="file" name="profile_image" id="imgInput" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onChange="updateTutorPhoto(event)">

                                <div class="flex flex-col gap-2 z-10 pointer-events-none">
                                    <div class="flex items-center">
                                        <span class="mr-4 py-2 px-4 rounded-xl text-[10px] cursor-pointer font-black uppercase bg-hero-orange/10 text-hero-orange border border-hero-orange/20">
                                            Choose Photo
                                        </span>
                                        <span id="tutor-file-name" class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter truncate max-w-[150px] cursor-pointer">
                                            <?= !empty($tutor['profile_image']) ? htmlspecialchars($tutor['profile_image']) : 'Initialize Identity...' ?>
                                        </span>
                                    </div>
                                    <p class="text-[8px] text-slate-400 uppercase tracking-widest ml-2">
                                        Recommended: Square Aspect Ratio (512x512px)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[var(--card-bg)] p-10 rounded-[3rem] border border-[var(--border-color)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-[0.4em] text-hero-blue dark:text-white border-l-4 border-hero-orange pl-4 mb-6">2. Professional Biography</h3>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Professional Biography<span class="text-red-500"> *</span></label>
                        <textarea name="bio" rows="6" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required><?= htmlspecialchars($tutor['bio']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white border-l-4 border-hero-orange pl-4 mb-6">3. Technical Metadata</h3>
                    
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Core Expertise<span class="text-red-500"> *</span></label>
                            <input type="text" name="expertise" value="<?= htmlspecialchars($tutor['expertise']) ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Qualification<span class="text-red-500"> *</span></label>
                            <input type="text" name="qualification" value="<?= htmlspecialchars($tutor['qualification']) ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Years Active<span class="text-red-500"> *</span></label>
                            <input type="number" name="experience_years" value="<?= $tutor['experience_years'] ?>" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" value="<?= htmlspecialchars($tutor['linkedin_url']) ?>" placeholder="https://www.linkedin.com/in/username" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Node Status</label>
                            <select name="status" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                                <option value="active" <?= ($tutor['status'] == 'active') ? 'selected' : '' ?>>Active (Authorize)</option>
                                <option value="suspended" <?= ($tutor['status'] == 'suspended') ? 'selected' : '' ?>>Suspended</option>
                                <option value="inactive" <?= ($tutor['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" name="update_tutor" class="cursor-pointer w-full py-4 bg-hero-blue text-white font-black rounded-2xl shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all uppercase tracking-widest text-[10px]">
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

        function updateTutorPhoto(input) {
            const preview = document.getElementById('preview');
            const nameDisplay = document.getElementById('tutor-file-name');
            
            if (input.files && input.files[0]) {
                preview.src = URL.createObjectURL(input.files[0]);
                
                nameDisplay.textContent = input.files[0].name;
                nameDisplay.classList.remove('text-slate-500');
                nameDisplay.classList.add('text-hero-orange');
            }
        }
    </script>
    <script src="assets/js/theme.js"></script>
</body>
</html>