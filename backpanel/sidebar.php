<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />

<aside class="w-72 h-screen bg-[var(--color-side-bg)] border-r border-[var(--color-border-dim)] flex flex-col hidden lg:flex sticky top-0">
    <div class="p-10">
        <div class="bg-white p-3 rounded-2xl shadow-xl inline-block mb-6">
            <img src="assets/img/logo.png" alt="Hero Tech Logo" class="h-10 w-auto object-contain">
        </div>
        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-500">Command Center</p>
    </div>

    <nav class="flex-1 px-6 space-y-2">
        <a href="dashboard.php" 
           class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-black text-xs uppercase tracking-widest <?= ($current_page == 'dashboard.php') ? 'bg-hero-blue text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-hero-blue/5 hover:text-hero-orange' ?>">
            <i class="fas fa-chart-line"></i> Overview
        </a>

        <a href="manage-courses.php" 
           class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-black text-xs uppercase tracking-widest <?= ($current_page == 'manage-courses.php' || $current_page == 'edit-course.php' || $current_page == 'add-course.php') ? 'bg-hero-blue text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-hero-blue/5 hover:text-hero-orange' ?>">
            <i class="fas fa-microchip"></i> Manage Courses
        </a>

        <a href="manage-students.php" 
           class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-black text-xs uppercase tracking-widest <?= ($current_page == 'manage-students.php') ? 'bg-hero-blue text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-hero-blue/5 hover:text-hero-orange' ?>">
            <i class="fas fa-fingerprint"></i> Student Base
        </a>

        <a href="revenue-nodes.php" 
           class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-black text-xs uppercase tracking-widest <?= ($current_page == 'revenue-nodes.php') ? 'bg-hero-blue text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-hero-blue/5 hover:text-hero-orange' ?>">
            <i class="fas fa-wallet"></i> Revenue Nodes
        </a>

        <a href="reports.php" 
           class="flex items-center gap-4 px-6 py-4 rounded-2xl transition-all font-black text-xs uppercase tracking-widest <?= ($current_page == 'reports.php') ? 'bg-hero-blue text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-hero-blue/5 hover:text-hero-orange' ?>">
            <i class="fas fa-file-invoice-dollar"></i> Reports
        </a>
    </nav>

    <div class="p-8">
        <button id="theme-toggle" class="w-full py-4 rounded-2xl border border-[var(--color-border-dim)] text-[10px] font-black uppercase tracking-widest hover:border-hero-orange transition-all cursor-pointer">
            <i class="fas fa-circle-half-stroke mr-2"></i> Appearance
        </button>
        <a href="logout.php" class="block w-full text-center mt-4 text-[10px] font-black uppercase text-red-500 tracking-widest hover:underline">
            Logout
        </a>
    </div>
</aside>