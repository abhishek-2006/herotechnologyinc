<?php 
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 1. Delete Logic
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM course_category WHERE category_id = '$id'");
    header("Location: manage-categories.php?msg=category_removed");
    exit();
}

// 2. Fetch Categories
$query = "SELECT * FROM course_category ORDER BY category_id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Category Nodes | Hero Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <style type="text/tailwindcss">
        @theme { --color-hero-blue: #1B264F; --color-hero-orange: #EE6C4D; }
        :root { --app-bg: #F8FAFC; --card-bg: #FFFFFF; --text-main: #1B264F; --border-color: #E2E8F0; }
        .dark { --app-bg: #020617; --card-bg: #0F172A; --text-main: #F8FAFC; --border-color: #1E293B; }
    </style>
</head>
<body class="bg-[var(--app-bg)] text-[var(--text-main)] antialiased min-h-screen flex overflow-hidden">
    <?php include 'sidebar.php'; ?>
    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12">
        <header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic leading-none">Category <span class="text-hero-orange not-italic">Nodes</span></h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Classify learning architectures</p>
            </div>
            <a href="add-category.php" class="bg-hero-blue text-white px-8 py-4 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl shadow-blue-900/20 hover:bg-hero-orange transition-all">
                Add New Category
            </a>
        </header>

        <div class="bg-[var(--card-bg)] rounded-[3rem] border border-[var(--border-color)] shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-hero-blue/5 border-b border-[var(--border-color)]">
                    <tr>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest">Category Name</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-center">System Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-color)]">
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="hover:bg-hero-orange/[0.02] transition-colors">
                        <td class="px-10 py-6 font-black uppercase text-sm tracking-tight"><?= htmlspecialchars($row['category_name']) ?></td>
                        <td class="px-10 py-6 text-center">
                            <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-500 text-[9px] font-black rounded-full uppercase"><?= $row['status'] ?></span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <a href="?delete=<?= $row['category_id'] ?>" onclick="return confirm('Delete this category?')" class="p-3 bg-red-500/5 rounded-xl text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        if(localStorage.getItem('theme') === 'light') document.documentElement.classList.remove('dark');

        themeToggle.addEventListener('click', toggleLocalTheme);
        const toggleBtn = document.getElementById("theme-toggle");
        const root = document.documentElement;

        // load saved theme
        if (localStorage.getItem("theme") === "dark") {
            root.classList.add("dark");
        }

        toggleBtn.addEventListener("click", () => {
            root.classList.toggle("dark");

            if (root.classList.contains("dark")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });
    </script>
</body>
</html>