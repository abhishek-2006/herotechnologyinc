<?php 
require '../config.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 1. DELETE LOGIC
if(isset($_GET['delete_id'])) {
    $del_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM user_master WHERE user_id = '$del_id' AND role = 'student'");
    header("Location: manage-students.php?msg=node_deleted");
    exit();
}

// 2. ADD STUDENT LOGIC
if(isset($_POST['add_student'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $insert = "INSERT INTO user_master (name, email, username, password, role) 
               VALUES ('$name', '$email', '$user', '$pass', 'student')";
    mysqli_query($conn, $insert);
    header("Location: manage-students.php?msg=node_added");
    exit();
}

// 3. FETCH STUDENTS DATA (The Dynamic Part)
$query = "SELECT u.user_id, u.name, u.email, u.username, 
          (SELECT COUNT(*) FROM enrollments e WHERE e.user_id = u.user_id) as node_count
          FROM user_master u 
          WHERE u.role = 'student' 
          ORDER BY u.user_id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Base | Hero Admin Terminal</title>
    
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
        }
        /* Fixing visibility for Dark/Light mode */
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
        <header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic">
                    Student <span class="text-hero-orange not-italic">Base</span>
                </h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Manage verified identities</p>
            </div>
            <button onclick="toggleModal('addModal')" class="bg-hero-orange text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:scale-105 transition-all">
                Add New Identity
            </button>
        </header>

        <div class="bg-[var(--card-bg)] rounded-[3rem] border border-[var(--border-color)] shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-hero-blue/5 border-b border-[var(--border-color)]">
                    <tr>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest">Student Identity</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest">Contact Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-center">Active Nodes</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-color)]">
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-hero-orange/[0.02] transition-colors">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-5">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['name']) ?>&background=1B264F&color=fff" class="w-10 h-10 rounded-xl">
                                    <div>
                                        <p class="text-sm font-black uppercase tracking-tight"><?= htmlspecialchars($row['name']) ?></p>
                                        <p class="text-[9px] font-mono text-slate-500 lowercase">@<?= htmlspecialchars($row['username']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-xs text-slate-500">
                                <?= htmlspecialchars($row['email']) ?>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <span class="px-4 py-1.5 bg-hero-orange/10 text-hero-orange text-[10px] font-black rounded-full uppercase">
                                    <?= $row['node_count'] ?> Modules
                                </span>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="edit-student.php?id=<?= $row['user_id'] ?>" class="p-3 bg-hero-blue/5 rounded-xl text-hero-blue hover:bg-hero-blue hover:text-white transition-all">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $row['user_id'] ?>)" class="p-3 bg-red-500/5 rounded-xl text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-10 py-20 text-center text-xs font-bold uppercase tracking-[0.3em] text-slate-500">
                                No Student Nodes Found in Database
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-6">
        <div class="bg-[var(--card-bg)] w-full max-w-lg rounded-[3rem] p-10 border border-[var(--border-color)]">
            <h2 class="text-2xl font-black uppercase italic mb-6">Register <span class="text-hero-orange">Node</span></h2>
            <form method="POST" class="space-y-4">
                <input type="text" name="name" placeholder="Full Name" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                <input type="email" name="email" placeholder="Email" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                <input type="text" name="username" placeholder="Username" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                <input type="password" name="password" placeholder="Password" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none">
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="toggleModal('addModal')" class="flex-1 text-[10px] font-black uppercase text-slate-400">Cancel</button>
                    <button type="submit" name="add_student" class="flex-1 py-4 bg-hero-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest">Initialize</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) { document.getElementById(id).classList.toggle('hidden'); }
        function confirmDelete(id) {
            if(confirm('Terminate this student node?')) {
                window.location.href = 'manage-students.php?delete_id=' + id;
            }
        }
        if(localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>