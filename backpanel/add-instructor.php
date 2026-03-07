<?php 
require '../config.php';

// 1. Session & Identity Verification
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

// 2. DIRECT INITIALIZATION LOGIC
if(isset($_POST['deploy_instructor'])) {
    // Sanitize Identity Inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    // Sanitize Technical Metadata
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $expertise = mysqli_real_escape_string($conn, $_POST['expertise']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience_years']);
    
    // Auto-generate temporary access key (MD5 for system alignment)
    $temp_pass = md5("Hero@Faculty2026"); 

    // Step A: Create Identity in user_master node
    $insert_user = "INSERT INTO user_master (name, email, username, password, role) 
                    VALUES ('$name', '$email', '$username', '$temp_pass', 'instructor')";
    
    if(mysqli_query($conn, $insert_user)) {
        $new_user_id = mysqli_insert_id($conn);

        // Step B: Initialize Technical Node in instructors table
        $insert_inst = "INSERT INTO instructors (user_id, bio, expertise, qualification, experience_years, status) 
                        VALUES ('$new_user_id', '$bio', '$expertise', '$qualification', '$experience', 'active')";
        
        if(mysqli_query($conn, $insert_inst)) {
            header("Location: manage-instructors.php?msg=node_deployed");
            exit();
        } else {
            $error = "FACULTY_TABLE_SYNC_ERROR: " . mysqli_error($conn);
        }
    } else {
        $error = "IDENTITY_NODE_DUPLICATE: This email or username already exists in the mainframe.";
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
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
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
                <a href="manage-instructors.php" class="text-hero-orange text-[10px] font-black uppercase tracking-widest flex items-center gap-2 mb-2">
                    <i class="fas fa-arrow-left"></i> Back to Node Manager
                </a>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter">Initialize <span class="text-hero-orange not-italic">Faculty Node</span></h1>
            </div>
        </header>

        <?php if($error): ?>
            <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-500 text-[10px] font-black uppercase tracking-widest text-center">
                <i class="fas fa-triangle-exclamation mr-2"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--card-bg)] p-10 rounded-[3rem] border border-[var(--border-color)] shadow-sm">
                    <h3 class="text-[9px] font-black uppercase tracking-[0.4em] text-hero-blue border-l-4 border-hero-orange pl-3 mb-8">1. Account Identity</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="space-y-2">
                            <label class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Legal Name</label>
                            <input type="text" name="name" placeholder="Legal Full Name" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Corporate Email</label>
                            <input type="email" name="email" placeholder="email@herotech.com" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">System Handle</label>
                        <input type="text" name="username" placeholder="@unique_identifier" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                    </div>
                </div>

                <div class="bg-[var(--card-bg)] p-10 rounded-[3rem] border border-[var(--border-color)] shadow-sm">
                    <h3 class="text-[9px] font-black uppercase tracking-[0.4em] text-hero-blue border-l-4 border-hero-orange pl-3 mb-8">2. Professional Narrative</h3>
                    <div class="space-y-2">
                        <label class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Technical Biography</label>
                        <textarea name="bio" rows="6" placeholder="Describe the instructor's background and achievements..." required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-8 py-6 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20 resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-[var(--card-bg)] p-10 rounded-[3rem] border border-[var(--border-color)] shadow-sm">
                    <h3 class="text-[9px] font-black uppercase tracking-[0.4em] text-hero-blue border-l-4 border-hero-orange pl-3 mb-8">3. Technical Metadata</h3>
                    
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Core Expertise</label>
                            <input type="text" name="expertise" placeholder="e.g. AI/ML Architecture" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Academic Qualification</label>
                            <input type="text" name="qualification" placeholder="e.g. M.Tech in CS" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Years Active</label>
                            <input type="number" name="experience_years" placeholder="0" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>

                        <div class="pt-6">
                            <button type="submit" name="deploy_instructor" class="w-full py-5 bg-hero-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all active:scale-95">
                                Deploy Instructor Node
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-hero-orange/5 p-8 rounded-[2.5rem] border border-hero-orange/10 text-center">
                    <p class="text-[10px] font-bold text-hero-orange uppercase tracking-widest mb-2">Protocol Note</p>
                    <p class="text-[9px] text-slate-500 leading-relaxed uppercase">Initialization will automatically generate a temporary access key for this node.</p>
                </div>
            </div>
        </form>
    </main>

    <script>
        if(localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
        else document.documentElement.classList.remove('dark');
    </script>
</body>
</html>