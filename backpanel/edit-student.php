<?php
require '../config.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 1. Fetch Student Data
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;
$query = "SELECT * FROM user_master WHERE user_id = '$id' AND role = 'student' LIMIT 1";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    header("Location: manage-students.php?error=not_found");
    exit();
}

// 2. Update Logic
if (isset($_POST['update_student'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $update = "UPDATE user_master SET name='$name', email='$email', username='$username' WHERE user_id='$id'";
    
    if (mysqli_query($conn, $update)) {
        header("Location: manage-students.php?msg=node_updated");
    } else {
        $error = "Update Failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Identity | Hero Admin Terminal</title>
    
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
            --border-dim: #E2E8F0;
        }
        .dark {
            --app-bg: #020617;
            --card-bg: #0F172A;
            --text-main: #F8FAFC;
            --border-dim: #1E293B;
        }
        body {
            background-color: var(--app-bg);
            color: var(--text-main);
        }
    </style>
</head>

<body class="antialiased min-h-screen flex overflow-hidden transition-colors duration-500">
    
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12 flex items-center justify-center">
        <div class="w-full max-w-2xl">
            
            <header class="flex justify-between items-center mb-8">
                <a href="manage-students.php" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-hero-orange transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Return to Base
                </a>
                <img src="assets/img/logo.png" class="h-6 opacity-80" alt="Hero Tech">
            </div>

            <div class="bg-[var(--card-bg)] rounded-[3rem] border border-[var(--border-dim)] p-12 shadow-2xl relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-5 dark:opacity-[0.02] pointer-events-none">
                    <i class="fas fa-user-edit text-[12rem]"></i>
                </div>

                <div class="relative z-10">
                    <h1 class="text-3xl font-black italic uppercase tracking-tighter mb-2">
                        Update <span class="text-hero-orange not-italic">Identity</span>
                    </h1>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-10">
                        Modifying Node: <span class="text-hero-blue dark:text-blue-400">#<?= $student['user_id'] ?></span>
                    </p>

                    <form method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest ml-4 text-slate-400">Full Name</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required 
                                       class="w-full bg-hero-blue/5 dark:bg-black/40 border border-[var(--border-dim)] rounded-2xl px-6 py-4 text-sm focus:border-hero-orange outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest ml-4 text-slate-400">Username</label>
                                <input type="text" name="username" value="<?= htmlspecialchars($student['username']) ?>" required 
                                       class="w-full bg-hero-blue/5 dark:bg-black/40 border border-[var(--border-dim)] rounded-2xl px-6 py-4 text-sm focus:border-hero-orange outline-none transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest ml-4 text-slate-400">Contact Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required 
                                   class="w-full bg-hero-blue/5 dark:bg-black/40 border border-[var(--border-dim)] rounded-2xl px-6 py-4 text-sm focus:border-hero-orange outline-none transition-all">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="submit" name="update_student" 
                                    class="flex-1 bg-hero-orange text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-orange-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                                Sync Identity Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="text-center mt-8 text-[9px] font-bold text-slate-500 uppercase tracking-[0.4em] opacity-40">
                Hero Technology Intelligent Node Management
            </p>
        </div>
    </main>

    <script>
        // Theme Persistence
        if (localStorage.getItem('theme') === 'dark' || !('theme' in localStorage)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>