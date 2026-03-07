<?php 
require '../config.php';

// 1. Session & Identity Verification
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 2. DISCONNECT INSTRUCTOR LOGIC
if(isset($_GET['delete_id'])) {
    $del_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    // Retrieve user_id before deletion to clean up both tables
    $get_user = mysqli_query($conn, "SELECT user_id FROM instructors WHERE instructor_id = '$del_id'");
    if($u_data = mysqli_fetch_assoc($get_user)) {
        $u_id = $u_data['user_id'];
        mysqli_query($conn, "DELETE FROM instructors WHERE instructor_id = '$del_id'");
        mysqli_query($conn, "DELETE FROM user_master WHERE user_id = '$u_id'");
    }
    header("Location: manage-instructors.php?msg=instructor_terminated");
    exit();
}

// 3. INITIALIZE INSTRUCTOR LOGIC (Enhanced for New Schema)
if(isset($_POST['add_instructor'])) {
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $expertise = mysqli_real_escape_string($conn, $_POST['expertise']);
    $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin_url']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience_years']);

    // Check if node identity already exists
    $temp_pass = md5("Hero@Faculty2026"); 

    // Step A: Create Identity in user_master
    $insert_user = "INSERT INTO user_master (name, email, username, password, role) 
                    VALUES ('$name', '$email', '$username', '$temp_pass', 'instructor')";
    
    if(mysqli_query($conn, $insert_user)) {
        $new_user_id = mysqli_insert_id($conn);

        // Step B: Initialize Technical Node in instructors table
        $insert_inst = "INSERT INTO instructors (user_id, expertise, qualification, experience_years, status) 
                        VALUES ('$new_user_id', '$expertise', '$qualification', '$experience', 'active')";
        mysqli_query($conn, $insert_inst);
        
        header("Location: manage-instructors.php?msg=instructor_added");
    } else {
        header("Location: manage-instructors.php?msg=already_exists");
    }
    exit();
}

// 4. FETCH INSTRUCTOR NODES (Intelligence Query)
$query = "SELECT i.*, u.name, u.email 
          FROM instructors i 
          INNER JOIN user_master u ON i.user_id = u.user_id 
          ORDER BY i.instructor_id DESC";
$result = mysqli_query($conn, $query);

// Fetch users who are NOT yet instructors for the "Add" modal dropdown
$user_list = mysqli_query($conn, "SELECT user_id, name FROM user_master WHERE role != 'admin' AND user_id NOT IN (SELECT user_id FROM instructors)");
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor | Hero Admin Terminal</title>
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

<body class="bg-[var(--app-bg)] text-[var(--text-main)] antialiased min-h-screen flex overflow-hidden">
    
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic">
                    Instructor <span class="text-hero-orange not-italic">Management</span>
                </h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Manage technical faculty deployment</p>
            </div>
            <a href="add-instructor.php" class="bg-hero-orange text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-hero-blue cursor-pointer transition-all">
                <i class="fas fa-plus mr-2"></i>
                Add New Instructor
            </a>
        </header>

        <div class="bg-[var(--card-bg)] rounded-[3rem] border border-[var(--border-color)] shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-hero-blue/5 border-b border-[var(--border-color)]">
                    <tr>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest">Faculty Identity</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest">Core expertise</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-center">Active tracks</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-color)]">
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-hero-orange/[0.02] transition-colors">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-5">
                                    <img src="<?= !empty($row['profile_image']) ? '../assets/img/instructors/'.$row['profile_image'] : 'https://ui-avatars.com/api/?name='.urlencode($row['name']).'&background=1B264F&color=fff' ?>" class="w-10 h-10 rounded-xl object-cover">
                                    <div>
                                        <p class="text-sm font-black uppercase tracking-tight"><?= htmlspecialchars($row['name']) ?></p>
                                        <p class="text-[9px] font-mono text-slate-500 lowercase italic"><?= htmlspecialchars($row['qualification']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase text-hero-blue dark:text-hero-orange tracking-wider">
                                        <?= htmlspecialchars($row['expertise']) ?>
                                    </span>
                                    <span class="text-[8px] font-bold text-slate-400 uppercase"><?= $row['experience_years'] ?> Years Exp.</span>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span class="px-3 py-1 rounded-full text-[8px] font-black uppercase tracking-widest <?= $row['status'] == 'active' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-red-500/10 text-red-500' ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <span class="px-4 py-1.5 bg-hero-orange/10 text-hero-orange text-[10px] font-black rounded-full uppercase">
                                    <?= $row['course_count'] ?> Courses
                                </span>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="edit-instructor.php?id=<?= $row['instructor_id'] ?>" class="p-3 bg-hero-blue/5 rounded-xl text-hero-blue hover:bg-hero-blue hover:text-white transition-all">
                                        <i class="fas fa-pen-nib"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $row['instructor_id'] ?>)" class="p-3 bg-red-500/5 rounded-xl text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="px-10 py-20 text-center text-xs font-bold uppercase tracking-[0.3em] text-slate-500">No Faculty Nodes Detected</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-6 overflow-y-auto">
        <div class="bg-[var(--card-bg)] w-full max-w-2xl rounded-[3rem] p-10 border border-[var(--border-color)] shadow-2xl my-8">
            
            <header class="mb-8">
                <h2 class="text-2xl font-black uppercase italic tracking-tighter">Authorize <span class="text-hero-orange not-italic">New Faculty</span></h2>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Direct System Entry Protocol</p>
            </header>

            <form method="POST" class="space-y-6">
                <div class="space-y-4">
                    <h3 class="text-[9px] font-black uppercase tracking-[0.4em] text-hero-blue border-l-4 border-hero-orange pl-3">1. Account Identity</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Legal Name</label>
                            <input type="text" name="name" id="name" placeholder="Full Name" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                        </div>
                        <div class="space-y-2">
                            <label for="email" class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Corporate Email</label>
                            <input type="email" name="email" id="email" placeholder="email@herotech.com" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="username" class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Unique Handle</label>
                        <input type="text" name="username" id="username" placeholder="@tech_lead" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-[9px] font-black uppercase tracking-[0.4em] text-hero-blue border-l-4 border-hero-orange pl-3">2. Technical Metadata</h3>
                    <div class="space-y-2">
                        <label for="bio" class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Professional Biography</label>
                        <textarea name="bio" id="bio" rows="3" placeholder="Summarize core expertise..." required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20 resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="expertise" class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Field Expertise</label>
                            <input type="text" id="expertise" name="expertise" placeholder="e.g. Fullstack" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>
                        <div class="space-y-2">
                            <label for="qualification" class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Highest Credential</label>
                            <input type="text" id="qualification" name="qualification" placeholder="Degree/Cert" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="experience_years" class="text-[8px] font-bold uppercase tracking-widest text-slate-500 ml-2">Years Active</label>
                        <input type="number" name="experience_years" id="experience_years" placeholder="0" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                    </div>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="button" onclick="toggleModal('addModal')" class="flex-1 text-[10px] font-black uppercase text-slate-400 tracking-widest hover:text-hero-orange transition-colors">Abort Dispatch</button>
                    <button type="submit" name="add_instructor" class="flex-1 py-5 bg-hero-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all active:scale-95">
                        Deploy Instructor Node
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) { document.getElementById(id).classList.toggle('hidden'); }
        function confirmDelete(id) {
            if(confirm('Disconnect this instructor from the mainframe?')) {
                window.location.href = 'manage-instructors.php?delete_id=' + id;
            }
        }
        if(localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');
        else document.documentElement.classList.remove('dark');
    </script>
</body>
</html>