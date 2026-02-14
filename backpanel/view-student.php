<?php 
require '../config.php';

// 1. Session and Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 2. Dynamic Identity Extraction
$student_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// 3. Fetch Student Metadata
$user_res = mysqli_query($conn, "SELECT * FROM user_master WHERE user_id = '$student_id' AND role = 'student' LIMIT 1");
$student = mysqli_fetch_assoc($user_res);

if (!$student) {
    header("Location: manage-students.php?error=identity_not_found");
    exit();
}

// 4. Fetch Synchronized Learning Nodes
$sqlNodes = "SELECT e.*, c.title, c.thumbnail, cat.category_name 
             FROM enrollments e
             JOIN courses c ON e.course_id = c.course_id
             JOIN course_category cat ON c.category_id = cat.category_id
             WHERE e.user_id = '$student_id'
             ORDER BY e.enrolled_at DESC";
$resNodes = mysqli_query($conn, $sqlNodes);
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identity Profile: <?php echo $student['name']; ?> | Hero Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
            --color-app-bg: #F8FAFC;
            --color-side-bg: #FFFFFF;
            --color-border-dim: #E2E8F0;
        }
        .dark {
            --color-app-bg: #020617;
            --color-side-bg: #0F172A;
            --color-border-dim: #1E293B;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--color-app-bg)] text-slate-400 antialiased min-h-screen flex overflow-hidden transition-colors duration-500">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex justify-between items-center mb-12">
            <div>
                <a href="manage-students.php" class="text-hero-orange text-[10px] font-black uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Back to Student Base
                </a>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic text-hero-blue dark:text-white">Identity <span class="text-hero-orange not-italic">Profile</span></h1>
            </div>
            <div class="flex gap-3">
                <button class="px-6 py-3 bg-red-500/10 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-red-500 hover:text-white transition-all">
                    Deactivate Account
                </button>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="space-y-8">
                <div class="bg-[var(--color-side-bg)] p-10 rounded-[3rem] border border-[var(--color-border-dim)] text-center shadow-sm">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($student['name']); ?>&background=1B264F&color=fff&size=256" class="w-32 h-32 rounded-[2.5rem] mx-auto mb-6 shadow-xl border-4 border-white dark:border-slate-800">
                    <h2 class="text-xl font-black uppercase italic text-hero-blue dark:text-white mb-1"><?php echo htmlspecialchars($student['name']); ?></h2>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">@<?php echo htmlspecialchars($student['username']); ?></p>
                    
                    <div class="space-y-3 pt-6 border-t border-[var(--color-border-dim)]">
                        <div class="flex justify-between text-[9px] font-bold uppercase tracking-widest">
                            <span class="text-slate-400">Identity Email</span>
                            <span class="text-hero-blue dark:text-slate-200"><?php echo htmlspecialchars($student['email']); ?></span>
                        </div>
                        <div class="flex justify-between text-[9px] font-bold uppercase tracking-widest">
                            <span class="text-slate-400">Mobile No.</span>
                            <span class="text-hero-blue dark:text-slate-200"><?php echo htmlspecialchars($student['mobile'] ?? 'Not Linked'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-[var(--color-side-bg)] rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-[var(--color-border-dim)] flex justify-between items-center">
                        <h3 class="text-xs font-black uppercase tracking-[0.3em] text-hero-blue dark:text-white">Assigned Learning Nodes</h3>
                        <span class="bg-hero-orange/10 text-hero-orange px-4 py-1.5 rounded-full text-[9px] font-black uppercase"><?php echo mysqli_num_rows($resNodes); ?> Tracks</span>
                    </div>

                    <div class="divide-y divide-[var(--color-border-dim)]">
                        <?php if (mysqli_num_rows($resNodes) > 0): while($node = mysqli_fetch_assoc($resNodes)): ?>
                        <div class="p-8 flex flex-col md:flex-row items-center gap-6 group hover:bg-hero-orange/[0.02] transition-all">
                            <div class="w-20 h-20 rounded-2xl overflow-hidden border border-[var(--color-border-dim)] shrink-0">
                                <img src="../assets/img/courses/<?php echo $node['thumbnail']; ?>" class="w-full h-full object-cover transition-all">
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <span class="text-[9px] font-black text-hero-orange uppercase tracking-[0.2em] mb-1 block"><?php echo $node['category_name']; ?></span>
                                <h4 class="text-lg font-black text-hero-blue dark:text-white uppercase italic leading-tight mb-2"><?php echo $node['title']; ?></h4>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Enrolled: <?php echo date('d M Y', strtotime($node['enrolled_at'])); ?></p>
                            </div>
                            <div class="text-right">
                                <span class="px-5 py-2 bg-emerald-500/10 text-emerald-500 text-[9px] font-black rounded-xl uppercase tracking-widest">
                                    <?php echo $node['status']; ?> Node
                                </span>
                            </div>
                        </div>
                        <?php endwhile; else: ?>
                        <div class="p-20 text-center opacity-30">
                            <p class="text-xs font-black uppercase tracking-widest">No curriculum nodes synchronized for this identity.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        if(localStorage.getItem('theme') === 'light') document.documentElement.classList.remove('dark');
    </script>
</body>
</html>