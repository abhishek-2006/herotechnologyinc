<?php 
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit();
}
if (isset($_POST['submit_category'])) {
    $name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "INSERT INTO course_category (category_name, status) VALUES ('$name', '$status')";
    if (mysqli_query($conn, $sql)) {
        header("Location: manage-categories.php?msg=category_added");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>Add Category | Hero Admin</title>
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
    <main class="flex-1 h-screen overflow-y-auto p-6 lg:p-12 flex items-center justify-center">
        <div class="w-full max-w-md bg-[var(--card-bg)] rounded-[3rem] p-12 border border-[var(--border-color)] shadow-2xl">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter mb-8">Add <span class="text-hero-orange">Category</span></h1>
            <form method="POST" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-4">Category Name</label>
                    <input type="text" name="category_name" placeholder="e.g. Cybersecurity" required class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none focus:ring-2 focus:ring-hero-orange/20">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-4">Status</label>
                    <select name="status" class="w-full bg-slate-100 dark:bg-black rounded-2xl px-6 py-4 text-sm border-none outline-none appearance-none">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit" name="submit_category" class="w-full py-5 bg-hero-blue text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:bg-hero-orange transition-all">
                    <i class="fas fa-plus mr-2"></i> Add Category
                </button>
            </form>
        </div>
    </main>
    <script src="assets/js/theme.js"></script>
</body>
</html>