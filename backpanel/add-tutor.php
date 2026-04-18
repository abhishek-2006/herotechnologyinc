<?php 
require '../config.php';

// 1. Session & Identity Verification
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

$error = '';

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

// 2. DIRECT INITIALIZATION LOGIC
if(isset($_POST['deploy_tutor'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $expertise = mysqli_real_escape_string($conn, $_POST['expertise']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience_years']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin_url'] ?? '');

    $profile_image = "";

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $uploadDir = "../assets/img/tutors/";
        
        $tutor_raw_name = mysqli_real_escape_string($conn, $_POST['name']);
        $name_slug = generateTechnicalSlug($tutor_raw_name);
        
        $fileExtension = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        
        // Final Filename: tutor_john-doe.jpg
        $fileName = "tutor_" . $name_slug . "." . $fileExtension; 
        $targetPath = $uploadDir . $fileName;
        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileExtension, $allowedTypes)) {
            
            if (!empty($course['profile_image']) && file_exists($uploadDir . $course['profile_image'])) {
                unlink($uploadDir . $course['profile_image']); 
            }

            // 4. Transmission to Repository
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
                $profile_image = $fileName; 
            }
        } else {
            $error = "Only JPG, JPEG, PNG, and WEBP files are allowed.";
        }
    }
    
    if(empty($error)) {
        $insert_inst = "INSERT INTO tutors (name, email, bio, expertise, qualification, experience_years, profile_image, linkedin_url, status) 
                        VALUES ( '$name', '$email', '$bio', '$expertise', '$qualification', '$experience', '$profile_image', '$linkedin', 'active')";
            
        if(mysqli_query($conn, $insert_inst)) {
            header("Location: manage-tutors.php?msg=tutor_added");
            exit();
        } else {
            $error = "FACULTY_TABLE_SYNC_ERROR: " . mysqli_error($conn);
        }
    }
}

require 'sidebar.php';
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deploy Faculty | Hero Admin Terminal</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
        }
        :root {
            --app-bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-main: #1B264F;
            --border-color: #E2E8F0;
        }
        .dark {
            --app-bg: #020617;
            --card-bg: #0F172A;
            --text-main: #F8FAFC;
            --border-color: #1E293B;
        }
    </style>
</head>

<body class="bg-[var(--app-bg)] text-[var(--text-main)] antialiased min-h-screen flex transition-colors duration-500">
    
    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex justify-between items-center mb-10">
            <div>
                <a href="manage-tutors.php" class="text-hero-orange text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-2">
                    <i class="fas fa-arrow-left"></i> Back to Tutors
                </a>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Add <span class="text-hero-orange not-italic">Faculty</span></h1>
            </div>
        </header>

        <?php if($error): ?>
            <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-500 text-[10px] font-black uppercase tracking-widest text-center animate-pulse">
                <i class="fas fa-triangle-exclamation mr-2"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--card-bg)] p-10 rounded-[3rem] border border-[var(--border-color)] shadow-sm">
                    
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white border-l-4 border-hero-orange pl-4 mb-6">1. Account Identity</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Legal Name<span class="text-red-500"> *</span></label>
                            <input type="text" name="name" placeholder="Full Name" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Corporate Email<span class="text-red-500"> *</span></label>
                            <input type="email" name="email" placeholder="email@herotech.com" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
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
                                    onchange="updateTutorPhoto(this)">

                                <div class="flex flex-col gap-2 z-10 pointer-events-none">
                                    <div class="flex items-center">
                                        <span class="mr-4 py-2 px-4 rounded-xl text-[10px] font-black uppercase bg-hero-orange/10 text-hero-orange border border-hero-orange/20">
                                            Choose Node
                                        </span>
                                        <span id="tutor-file-name" class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter truncate max-w-[150px]">
                                            <?= !empty($tutor['profile_image']) ? htmlspecialchars($tutor['profile_image']) : 'Choose File' ?>
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
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white border-l-4 border-hero-orange pl-4 mb-6">2. Professional Biography</h3>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Technical Biography<span class="text-red-500"> *</span></label>
                        <textarea name="bio" rows="6" placeholder="Achievements and Background..." required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-8 py-6 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20 resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--card-bg)] p-10 rounded-[3rem] border border-[var(--border-color)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white border-l-4 border-hero-orange pl-4 mb-6">3. Technical Metadata</h3>
                    
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Core Expertise<span class="text-red-500"> *</span></label>
                            <input type="text" name="expertise" placeholder="e.g. .NET Core Architecture" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Highest Qualification<span class="text-red-500"> *</span></label>
                            <input type="text" name="qualification" placeholder="e.g. PhD in AI" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Years Active<span class="text-red-500"> *</span></label>
                            <input type="number" name="experience_years" placeholder="0" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" placeholder="https://linkedin.com/in/..." class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>

                        <div class="pt-6">
                            <button type="submit" name="deploy_tutor" class="w-full py-5 bg-hero-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all active:scale-95">
                                <i class="fas fa-paper-plane mr-2"></i> Add Faculty
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-hero-orange/5 p-8 rounded-[2.5rem] border border-hero-orange/10 text-center">
                    <p class="text-[10px] font-bold text-hero-orange uppercase tracking-widest mb-2">Node Compliance</p>
                    <p class="text-[9px] text-slate-500 leading-relaxed uppercase">By deploying, this faculty will be visible in the "Our Team" repository globally.</p>
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
                // 1. Update Preview Image
                preview.src = URL.createObjectURL(input.files[0]);
                
                // 2. Update Proxy Text Display
                nameDisplay.textContent = input.files[0].name;
                nameDisplay.classList.remove('text-slate-500');
                nameDisplay.classList.add('text-hero-orange');
            }
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
    </script>
    <script src="assets/js/theme.js"></script>
</body>
</html>