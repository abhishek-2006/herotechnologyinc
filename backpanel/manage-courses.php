<?php 
require '../config.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 1. Handle Course Deletion
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM courses WHERE course_id = '$id'");
    header("Location: manage-courses.php?msg=deleted");
    exit();
}

// 2. Fetch All Courses with Category and Instructor Details
$query = "SELECT c.*, cat.category_name, u.name as instructor 
          FROM courses c 
          JOIN course_category cat ON c.category_id = cat.category_id 
          JOIN user_master u ON c.instructor_id = u.user_id 
          ORDER BY c.course_id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Admin | Manage Nodes</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;   /* Navy from Logo */
            --color-hero-orange: #EE6C4D; /* Orange from Logo */
            --color-app-bg: #F8FAFC;
            --color-side-bg: #FFFFFF;
            --color-border-dim: #E2E8F0;
            --color-text-main: #0F172A;
        }
        .dark {
            --color-app-bg: #020617;
            --color-side-bg: #0F172A;
            --color-border-dim: #1E293B;
            --color-text-main: #F8FAFC;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--color-app-bg)] text-[var(--color-text-main)] antialiased min-h-screen flex overflow-hidden transition-colors duration-500">
    
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic leading-none text-hero-blue dark:text-white">Curriculum <span class="text-hero-orange not-italic">Nodes</span></h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Deploy and configure new learning architectures</p>
            </div>
            
            <a href="add-course.php" class="w-full md:w-auto text-center px-8 py-4 bg-hero-orange text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-orange-500/20 hover:-translate-y-1 transition-all">
                <i class="fas fa-plus mr-2"></i> Add New Course
            </a>
        </header>

        <div class="bg-[var(--color-side-bg)] rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-hero-blue/5 border-b border-[var(--color-border-dim)]">
                        <tr>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Technical Node</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lead Instructor</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Valuation</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border-dim)]">
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-hero-orange/[0.02] transition-colors group">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 rounded-2xl overflow-hidden border border-[var(--color-border-dim)] bg-slate-100 shrink-0">
                                        <img src="../assets/img/courses/<?php echo $row['thumbnail']; ?>" class="w-full h-full object-cover transition-all">
                                    </div>
                                    <div>
                                        <p class="text-sm font-black uppercase tracking-tight text-hero-blue dark:text-white"><?php echo htmlspecialchars($row['title']); ?></p>
                                        <p class="text-[9px] font-mono text-slate-400 uppercase">UID: #NODE-<?php echo $row['course_id']; ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span class="text-[10px] font-black uppercase tracking-widest text-hero-orange"><?php echo $row['category_name']; ?></span>
                            </td>
                            <td class="px-10 py-6 text-sm font-bold text-slate-400"><?php echo $row['instructor']; ?></td>
                            <td class="px-10 py-6 font-black text-hero-blue dark:text-white italic text-lg">₹<?php echo number_format($row['price'], 0); ?></td>
                            <td class="px-10 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest <?php echo $row['status'] == 'publish' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-amber-500/10 text-amber-500'; ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <div class="flex justify-end gap-3">
                                    <a href="edit-course.php?id=<?php echo $row['course_id']; ?>" class="w-10 h-10 rounded-xl bg-hero-blue/5 flex items-center justify-center text-hero-blue hover:bg-hero-blue hover:text-white transition-all"><i class="fas fa-code-merge"></i></a>
                                    <a href="?delete=<?php echo $row['course_id']; ?>" onclick="return confirm('Decommission this learning node?')" class="w-10 h-10 rounded-xl bg-red-500/5 flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition-all"><i class="fas fa-trash-can"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="mt-12 text-center opacity-30">
            <p class="text-[9px] font-black uppercase tracking-[0.5em]">Hero Technology Inc. Administrative Layer</p>
        </footer>
    </main>

    <script>
        const themeBtn = document.getElementById('theme-toggle');
        if(localStorage.getItem('theme') === 'light') document.documentElement.classList.remove('dark');
        themeBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });
    </script>
</body>
</html>