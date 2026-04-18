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

// 2. DISCONNECT TUTOR LOGIC
if(isset($_GET['delete_id'])) {
    $del_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $get_user = mysqli_query($conn, "SELECT user_id FROM tutors WHERE tutor_id = '$del_id'");
    if($u_data = mysqli_fetch_assoc($get_user)) {
        mysqli_query($conn, "DELETE FROM tutors WHERE tutor_id = '$del_id'");
    }
    header("Location: manage-tutors.php?msg=tutor_removed");
    exit();
}

// 4. FETCH tutor NODES (Intelligence Query)
$query = "SELECT i.*, (SELECT COUNT(*) FROM courses c WHERE c.tutor_id = i.tutor_id) AS course_count 
          FROM tutors i 
          ORDER BY i.tutor_id DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutors | Hero Admin Terminal</title>
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
                    Tutor <span class="text-hero-orange not-italic">Management</span>
                </h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Manage technical faculty deployment</p>
            </div>
            <a href="add-tutor.php" class="bg-hero-orange text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-hero-blue cursor-pointer transition-all">
                <i class="fas fa-plus mr-2"></i>
                Add New Tutor
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
                                    <img src="<?= !empty($row['profile_image']) ? '../assets/img/tutors/' . $row['profile_image'] : 'https://ui-avatars.com/api/?name='.urlencode($row['name']).'&background=1B264F&color=fff' ?>" class="w-10 h-10 rounded-xl object-cover">
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
                                    <a href="edit-tutor.php?id=<?= $row['tutor_id'] ?>" class="p-3 bg-hero-blue/5 rounded-xl text-hero-blue hover:bg-hero-blue hover:text-white transition-all">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $row['tutor_id'] ?>)" class="p-3 bg-red-500/5 rounded-xl text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="px-10 py-20 text-center text-xs font-bold uppercase tracking-[0.3em] text-slate-500">No Faculty Detected</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function confirmDelete(id) {
            if(confirm('Remove this tutor from the system?')) {
                window.location.href = 'manage-tutors.php?delete_id=' + id;
            }
        }
    </script>
    <script src="assets/js/theme.js"></script>
</body>
</html>