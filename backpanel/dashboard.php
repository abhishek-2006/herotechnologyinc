<?php 
require '../config.php';

// Authentication Logic
if (!isset($_SESSION['user_id']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

// Data Intelligence: Optimized Procedural mysqli
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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <style type="text/tailwindcss">
        @theme { 
            --color-hero-blue: #1B264F; 
            --color-hero-orange: #EE6C4D; 
        }

        /* 1. Global Variable Architecture */
        :root { 
            --app-bg: #F8FAFC; 
            --card-bg: #FFFFFF; 
            --text-main: #1B264F; 
            --text-muted: #64748B;
            --border-dim: #E2E8F0; 
            --stat-icon-bg: #1B264F;
        }

        /* 2. Dark Theme Command Center Colors */
        .dark { 
            --app-bg: #020617; /* Deepest Navy */
            --card-bg: #0F172A; /* Slate Navy */
            --text-main: #F8FAFC; 
            --text-muted: #94A3B8;
            --border-dim: #1E293B; 
            --stat-icon-bg: #EE6C4D; /* Icons pop in orange in dark mode */
        }

        @layer utilities {
            .stat-card {
                background-color: var(--card-bg);
                border: 1px solid var(--border-dim);
                @apply relative overflow-hidden rounded-[2.5rem] p-8 transition-all duration-500;
            }
            .stat-card:hover {
                @apply border-hero-orange -translate-y-2 shadow-2xl;
                box-shadow: 0 25px 50px -12px rgba(238, 108, 77, 0.15);
            }
        }
    </style>
</head>
<body class="bg-[var(--app-bg)] text-[var(--text-main)] antialiased min-h-screen flex overflow-hidden">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto px-8 lg:px-12 pb-12">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 py-8 mb-8">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic leading-none text-hero-blue dark:text-white">Global <span class="text-hero-orange not-italic">Control</span></h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Real-time Analytics & Management</p>
            </div>
            
            <div class="group flex items-center gap-4 bg-[var(--card-bg)] p-3 pr-10 rounded-[2rem] border border-[var(--border-dim)] shadow-sm hover:border-hero-orange transition-all cursor-pointer">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=Abhishek&background=EE6C4D&color=fff" class="w-14 h-14 rounded-2xl object-cover">
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-4 border-[var(--card-bg)] rounded-full"></div>
                </div>
                <div>
                    <p class="text-xs font-black uppercase text-hero-blue dark:text-white leading-none mb-1"><?= $_SESSION['name'] ?></p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Admin</p>
                </div>
            </div>
        </header>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <div class="stat-card group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-hero-blue/5 rounded-full blur-3xl group-hover:bg-hero-blue/20 transition-all"></div>
                <div class="w-14 h-14 bg-hero-blue/10 rounded-2xl flex items-center justify-center text-hero-blue mb-8 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-astronaut text-xl"></i>
                </div>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Total Students</p>
                <h3 class="text-5xl font-black mt-2 tracking-tighter italic uppercase"><?= number_format($totalStudents); ?></h3>
            </div>

            <div class="stat-card group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-hero-orange/5 rounded-full blur-3xl group-hover:bg-hero-orange/20 transition-all"></div>
                <div class="w-14 h-14 bg-hero-orange/10 rounded-2xl flex items-center justify-center text-hero-orange mb-8 group-hover:scale-110 transition-transform">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Active Courses</p>
                <h3 class="text-5xl font-black mt-2 tracking-tighter italic uppercase"><?= $totalCourses; ?></h3>
            </div>

            <div class="stat-card group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all"></div>
                <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500 mb-8 group-hover:scale-110 transition-transform">
                    <i class="fas fa-rupee-sign text-xl"></i>
                </div>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Revenue (INR)</p>
                <h3 class="text-5xl font-black mt-2 tracking-tighter italic uppercase">₹<?= number_format($totalRevenue / 1000, 1); ?>K</h3>
            </div>

            <div class="stat-card group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/20 transition-all"></div>
                <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-500 mb-8 group-hover:scale-110 transition-transform">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Average Rating</p>
                <h3 class="text-5xl font-black mt-2 tracking-tighter italic uppercase"><?= $avgRating; ?><span class="text-sm">/5</span></h3>
            </div>
        </section>

        <div class="bg-[var(--card-bg)] rounded-[3rem] border border-[var(--border-dim)] shadow-2xl shadow-black/5 overflow-hidden">
            <div class="p-10 border-b border-[var(--border-dim)] flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-black uppercase italic tracking-tighter">Live Enrollment <span class="text-hero-orange">Stream</span></h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Real-time Data Splicing</p>
                </div>
                <a href="manage-students.php" class="px-8 py-3 bg-hero-blue/5 text-hero-blue dark:text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-hero-orange hover:text-white transition-all">
                    Full Repository Access
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-white/5">
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Personnel ID</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Target Curriculum</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Timestamp</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Auth Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border-dim)]">
                        <?php foreach($recentActivities as $row): ?>
                        <tr class="hover:bg-hero-orange/[0.03] transition-colors group">
                            <td class="px-10 py-8">
                                <p class="text-sm font-black uppercase text-hero-blue dark:text-white group-hover:text-hero-orange transition-colors"><?= htmlspecialchars($row['name']); ?></p>
                            </td>
                            <td class="px-10 py-8 text-xs font-bold text-slate-500 uppercase tracking-tight">
                                <?= htmlspecialchars($row['title']); ?>
                            </td>
                            <td class="px-10 py-8 text-[10px] font-bold text-slate-500">
                                [ <?= date('d.m.y | H:i', strtotime($row['enrolled_at'])); ?> ]
                            </td>
                            <td class="px-10 py-8">
                                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-500/10 text-emerald-500 text-[9px] font-black rounded-lg uppercase tracking-tighter">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <?= $row['status']; ?>
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
        document.addEventListener("DOMContentLoaded", () => {
            const root = document.documentElement;
            const toggleBtn = document.getElementById("theme-toggle");

            // 1. Initial State Sync
            const currentTheme = localStorage.getItem('theme') || 'dark';
            if (currentTheme === 'dark') {
                root.classList.add('dark');
            } else {
                root.classList.remove('dark');
            }

            // 2. Toggle Protocol
            if (toggleBtn) {
                toggleBtn.addEventListener("click", () => {
                    root.classList.toggle("dark");
                    const theme = root.classList.contains("dark") ? "dark" : "light";
                    localStorage.setItem("theme", theme);
                });
            }
        });
    </script>
</body>
</html>