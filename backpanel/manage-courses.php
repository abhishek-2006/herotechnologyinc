<?php 
require '../config.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

// 1. Handle Course Deletion
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM enrollments WHERE course_id = '$id'");
    mysqli_query($conn, "DELETE FROM course_reviews WHERE course_id = '$id'");
    mysqli_query($conn, "DELETE FROM courses WHERE course_id = '$id'");
    header("Location: manage-courses.php?msg=Course+Deleted+Successfully");
    exit();
}

// 2. Fetch All Courses
// We join directly to user_master for the instructor's name to avoid empty rows
$query = "SELECT c.*, cat.category_name, u.name as instructor_name 
          FROM courses c 
          LEFT JOIN course_category cat ON c.category_id = cat.category_id 
          LEFT JOIN user_master u ON c.instructor_id = u.user_id 
          ORDER BY c.course_id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses | Hero Admin Terminal</title>
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
                <h1 class="text-4xl font-black tracking-tighter uppercase italic leading-none">
                    Manage <span class="text-hero-orange not-italic">Courses</span>
                </h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Configure and deploy technical learning architectures</p>
            </div>
            
            <a href="add-course.php" class="bg-hero-blue text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all">
                <i class="fas fa-plus mr-2"></i> Add New Course
            </a>
        </header>

        <div class="bg-[var(--card-bg)] rounded-[3rem] border border-[var(--border-color)] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-hero-blue/5 border-b border-[var(--border-color)]">
                        <tr>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Course Identification</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Duration</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lead Instructor</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Valuation</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border-color)]">
                        <?php if(mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="hover:bg-hero-orange/[0.02] transition-colors group">
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden border border-[var(--border-color)] bg-slate-100 shrink-0 shadow-inner">
                                            <img src="../assets/img/courses/<?php echo !empty($row['thumbnail']) ? $row['thumbnail'] : 'default.png'; ?>" class="w-full h-full object-cover" onerror="this.src='../assets/img/logo.png'">
                                        </div>
                                        <div>
                                            <p class="text-sm font-black uppercase tracking-tight text-hero-blue dark:text-white"><?php echo htmlspecialchars($row['title']); ?></p>
                                            <p class="text-[9px] font-bold text-hero-orange uppercase tracking-widest"><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></p>
                                            <p class="text-[8px] font-mono text-slate-400 uppercase mt-1 opacity-60">ID: #<?php echo $row['course_id']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black uppercase text-slate-500 tracking-tighter">
                                            <?php 
                                                $minutes = $row['duration'] ?? 0;
                                                $hours = $minutes / 60;
                                                echo htmlspecialchars(number_format($hours, 2)) . ' Hrs';
                                            ?>
                                        </span>
                                        <span class="text-[8px] font-bold text-slate-400 uppercase opacity-40">System Time</span>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row['instructor_name'] ?? 'H'); ?>&background=1B264F&color=fff" class="w-6 h-6 rounded-lg">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase"><?php echo htmlspecialchars($row['instructor_name'] ?? 'System'); ?></span>
                                    </div>
                                </td>
                                <td class="px-10 py-6">
                                    <span class="font-black text-hero-blue dark:text-white italic text-lg tracking-tighter">₹<?php echo number_format($row['price'], 0); ?></span>
                                </td>
                                <td class="px-10 py-6 text-center">
                                    <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest <?php echo ($row['status'] == 'publish') ? 'bg-emerald-500/10 text-emerald-500' : 'bg-amber-500/10 text-amber-500'; ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="edit-course.php?id=<?php echo $row['course_id']; ?>" class="p-3 bg-hero-blue/5 rounded-xl text-hero-blue hover:bg-hero-blue hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete=<?php echo $row['course_id']; ?>" onclick="return confirm('Are you sure you want to delete this course?')" class="p-3 bg-red-500/5 rounded-xl text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-10 py-20 text-center text-slate-400 font-bold uppercase text-xs tracking-widest opacity-30">
                                    No courses found. <br>
                                    <a href="add-course.php" class="mt-4 inline-block bg-hero-blue text-white px-6 py-3 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all">
                                        <i class="fas fa-plus mr-2"></i> Add Your First Course
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="assets/js/theme.js"></script>
</body>
</html>