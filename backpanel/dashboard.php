<?php 
require '../config.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Data Intelligence: Procedural mysqli
$totalStudents = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM user_master WHERE role='student'"))[0];
$totalCourses = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM courses WHERE status='publish'"))[0];
$totalRevenue = mysqli_fetch_row(mysqli_query($conn, "SELECT SUM(amount) FROM payments WHERE payment_status='success'"))[0] ?: 0;
$avgRating = round(mysqli_fetch_row(mysqli_query($conn, "SELECT AVG(rating) FROM course_reviews"))[0], 1) ?: 0;

$recentActivities = [];
$result = mysqli_query($conn, "
    SELECT u.name, c.title, e.enrolled_at, e.status 
    FROM enrollments e
    JOIN user_master u ON e.user_id = u.user_id
    JOIN courses c ON e.course_id = c.course_id
    ORDER BY e.enrolled_at DESC
    LIMIT 5
");
while ($row = mysqli_fetch_assoc($result)) { $recentActivities[] = $row; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Admin | Global Control</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;   /* From Logo Text */
            --color-hero-orange: #EE6C4D; /* From Logo Icon */
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
        @utility stat-card {
            background-color: var(--color-side-bg);
            border: 1px solid var(--color-border-dim);
            border-radius: 2rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            &:hover { border-color: var(--color-hero-orange); transform: translateY(-2px); }
        }
    </style>
</head>
<body class="bg-[var(--color-app-bg)] text-[var(--color-text-main)] antialiased min-h-screen flex overflow-hidden transition-colors duration-500">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic leading-none">Global <span class="text-hero-orange not-italic">Intelligence</span></h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Node Status: <span class="text-emerald-500">Synchronized</span></p>
            </div>
            
            <div class="flex items-center gap-4 bg-[var(--color-side-bg)] p-3 pr-8 rounded-3xl border border-[var(--color-border-dim)] shadow-sm">
                <img src="https://ui-avatars.com/api/?name=Admin&background=1B264F&color=fff" class="w-12 h-12 rounded-2xl">
                <div>
                    <p class="text-[10px] font-black uppercase text-hero-blue leading-none mb-1">Abhishek</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Level 4 Access</p>
                </div>
            </div>
        </header>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="stat-card group">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-hero-blue/10 rounded-2xl flex items-center justify-center text-hero-blue group-hover:bg-hero-blue group-hover:text-white transition-all">
                        <i class="fas fa-user-group"></i>
                    </div>
                </div>
                <p class="text-slate-400 text-[9px] font-black uppercase tracking-widest">Total Student Nodes</p>
                <h3 class="text-4xl font-black mt-2 tracking-tighter italic uppercase"><?php echo number_format($totalStudents); ?></h3>
            </div>

            <div class="stat-card group">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-hero-orange/10 rounded-2xl flex items-center justify-center text-hero-orange group-hover:bg-hero-orange group-hover:text-white transition-all">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
                <p class="text-slate-400 text-[9px] font-black uppercase tracking-widest">Active Curriculum</p>
                <h3 class="text-4xl font-black mt-2 tracking-tighter italic uppercase"><?php echo $totalCourses; ?></h3>
            </div>

            <div class="stat-card group">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
                <p class="text-slate-400 text-[9px] font-black uppercase tracking-widest">Revenue Dispatched</p>
                <h3 class="text-4xl font-black mt-2 tracking-tighter italic uppercase">₹<?php echo number_format($totalRevenue, 0); ?></h3>
            </div>

            <div class="stat-card group">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-all">
                        <i class="fas fa-bolt"></i>
                    </div>
                </div>
                <p class="text-slate-400 text-[9px] font-black uppercase tracking-widest">Avg Node Score</p>
                <h3 class="text-4xl font-black mt-2 tracking-tighter italic uppercase"><?php echo $avgRating; ?>/5</h3>
            </div>
        </section>

        <div class="bg-[var(--color-side-bg)] rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm overflow-hidden">
            <div class="p-10 border-b border-[var(--color-border-dim)] flex justify-between items-center">
                <h2 class="text-xl font-black uppercase italic tracking-tighter">Live Enrollment <span class="text-hero-orange">Stream</span></h2>
                <a href="manage-students.php" class="text-[10px] font-black text-hero-blue uppercase tracking-widest border-b-2 border-hero-orange pb-1">Analyze All Data</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-hero-blue/5">
                        <tr>
                            <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Student Identity</th>
                            <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Curriculum Node</th>
                            <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Timestamp</th>
                            <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Node Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border-dim)]">
                        <?php foreach($recentActivities as $row): ?>
                        <tr class="hover:bg-hero-orange/[0.02] transition-colors">
                            <td class="px-10 py-6">
                                <p class="text-sm font-black uppercase tracking-tight text-hero-blue"><?php echo htmlspecialchars($row['name']); ?></p>
                            </td>
                            <td class="px-10 py-6 text-sm font-bold text-slate-400">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </td>
                            <td class="px-10 py-6 text-xs font-bold text-slate-500">
                                <?php echo date('M d, Y | H:i', strtotime($row['enrolled_at'])); ?>
                            </td>
                            <td class="px-10 py-6">
                                <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-500 text-[9px] font-black rounded-full uppercase tracking-widest">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        const themeBtn = document.getElementById('theme-toggle');
        themeBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });
    </script>
</body>
</html>