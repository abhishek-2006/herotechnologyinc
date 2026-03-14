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
    
    $update_inst = "UPDATE instructors SET 
                    name='$name', 
                    email='$email',
                    bio='$bio', 
                    expertise='$expertise', 
                    qualification='$qualification', 
                    experience_years='$experience', 
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
            
            <button onclick="toggleLocalTheme()" class="w-10 h-10 rounded-xl bg-[var(--card-bg)] border border-[var(--border-dim)] flex items-center justify-center text-hero-orange shadow-sm cursor-pointer">
                <i class="fas fa-circle-half-stroke"></i>
            </button>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Legal Name</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($instructor['name']) ?>" class="form-input" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Corporate Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($instructor['email']) ?>" class="form-input" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Professional Biography</label>
                            <textarea name="bio" rows="6" class="form-input resize-none"><?= htmlspecialchars($instructor['bio']) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-hero-blue dark:text-white mb-6 border-l-4 border-hero-orange pl-4">Technical Links</h3>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">LinkedIn Professional URL</label>
                            <input type="url" name="linkedin_url" value="<?= $instructor['linkedin_url'] ?>" class="form-input" placeholder="https://linkedin.com/in/...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--card-bg)] p-8 rounded-[3rem] border border-[var(--border-dim)] shadow-sm">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Core Expertise</label>
                            <input type="text" name="expertise" value="<?= htmlspecialchars($instructor['expertise']) ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Qualification</label>
                            <input type="text" name="qualification" value="<?= htmlspecialchars($instructor['qualification']) ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Years Active</label>
                            <input type="number" name="experience_years" value="<?= $instructor['experience_years'] ?>" class="form-input">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3 ml-2">Node Status</label>
                            <select name="status" class="form-input">
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
        if(localStorage.getItem('theme') === 'light') document.documentElement.classList.remove('dark');

        themeToggle.addEventListener('click', toggleLocalTheme);
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