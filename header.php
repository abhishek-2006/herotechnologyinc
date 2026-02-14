<?php 
$currentPage = basename($_SERVER['PHP_SELF']); 
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Technology Inc. | Next-Gen Learning</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
            --font-sans: "Inter", system-ui, sans-serif;
        }
        @utility nav-link-wrapper {
            @apply flex items-center h-full;
        }
        @utility nav-link-item {
            @apply text-[11px] font-black uppercase tracking-[0.12em] transition-colors flex items-center relative pb-1;
        }
        @utility active-indicator {
            @apply absolute bottom-0 left-0 right-0 h-0.5 bg-hero-blue;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] font-sans text-slate-900">

    <header class="top-0 z-[100] bg-white border-b border-gray-100 shadow-sm">
        <nav class="navbar max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex items-center">
                    <a href="index.php" class="block">
                        <img src="assets/img/logo.png" alt="Hero Logo" class="h-12 w-auto object-contain">
                    </a>
                </div>

                <button class="lg:hidden text-hero-blue p-2" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <ul class="hidden lg:flex items-center space-x-8 h-full">
                    <?php if(isset($_SESSION['email'])): ?>
                        <li class="h-full nav-link-item">
                            <a href="dashboard.php" class="nav-link-item <?= ($currentPage == 'dashboard.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                                Dashboard
                                <?php if($currentPage == 'dashboard.php') echo '<div class="active-indicator"></div>'; ?>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="h-full nav-link-item">
                            <a href="index.php" class="nav-link-item <?= ($currentPage == 'index.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                                Home
                                <?php if($currentPage == 'index.php') echo '<div class="active-indicator"></div>'; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="h-full nav-link-item">
                        <a href="about.php" class="nav-link-item <?= ($currentPage == 'about.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                            About Us
                            <?php if($currentPage == 'about.php') echo '<div class="active-indicator"></div>'; ?>
                        </a>
                    </li>
                    <li class="h-full nav-link-item">
                        <a href="staffing.php" class="nav-link-item <?= ($currentPage == 'staffing.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                            Staffing
                            <?php if($currentPage == 'staffing.php') echo '<div class="active-indicator"></div>'; ?>
                        </a>
                    </li>
                    <li class="h-full nav-link-item">
                        <a href="clients.php" class="nav-link-item <?= ($currentPage == 'clients.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                            Clients
                            <?php if($currentPage == 'clients.php') echo '<div class="active-indicator"></div>'; ?>
                        </a>
                    </li>

                    <li class="h-full group relative nav-link-item">
                        <a href="training.php" class="nav-link-item <?= ($currentPage == 'training.php' || $currentPage == 'courses.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                            Training <i class="fas fa-chevron-down text-[8px] ml-1"></i>
                            <?php if($currentPage == 'training.php') echo '<div class="active-indicator"></div>'; ?>
                        </a>
                        <ul class="absolute top-full left-0 w-48 bg-white shadow-2xl rounded-b-xl border-t-2 border-hero-blue opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all p-4 z-50">
                            <li><a href="courses.php" class="block py-2 text-[10px] font-bold uppercase hover:text-hero-orange">All Courses</a></li>
                            <li><a href="training.php" class="block py-2 text-[10px] font-bold uppercase hover:text-hero-orange">Online Training</a></li>
                            <li><a href="classroom.php" class="block py-2 text-[10px] font-bold uppercase hover:text-hero-orange">Classroom</a></li>
                        </ul>
                    </li>
                    <li class="h-full nav-link-item">
                        <a href="testimonials.php" class="nav-link-item <?= ($currentPage == 'testimonials.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                            Testimonials
                            <?php if($currentPage == 'testimonials.php') echo '<div class="active-indicator"></div>'; ?>
                        </a>
                    </li>
                    <?php if(isset($_SESSION['email'])): ?>
                        <li class="h-full nav-link-item">
                            <a href="blog.php" class="nav-link-item <?= ($currentPage == 'blog.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                                Blog
                                <?php if($currentPage == 'blog.php') echo '<div class="active-indicator"></div>'; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="h-full nav-link-item">
                        <a href="contact.php" class="nav-link-item <?= ($currentPage == 'contact.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                            Contact Us
                            <?php if($currentPage == 'contact.php') echo '<div class="active-indicator"></div>'; ?>
                        </a>
                    </li>
                    <li class="h-full nav-link-item">
                        <a href="faq.php" class="nav-link-item <?= ($currentPage == 'faq.php') ? 'text-hero-blue' : 'text-gray-500 hover:text-hero-blue' ?>">
                            FAQ
                            <?php if($currentPage == 'faq.php') echo '<div class="active-indicator"></div>'; ?>
                        </a>
                    </li>
                </ul>

                <div class="hidden lg:flex items-center gap-4">
                    <?php if(isset($_SESSION['email'])): ?>
                        <a href="logout.php" class="text-[11px] font-black uppercase text-red-500 hover:underline">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="text-[11px] font-black uppercase tracking-widest text-gray-500 hover:text-hero-blue">Login</a>
                        <a href="signup.php" class="bg-hero-orange text-white px-6 py-2.5 rounded-lg text-[11px] font-black uppercase tracking-widest shadow-lg shadow-orange-500/30 hover:bg-[#D85B3D] transition-all">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    
    <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-gray-100 overflow-hidden transition-all duration-300">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <?php if(isset($_SESSION['email'])): ?>
                <a href="dashboard.php" class="block px-3 py-4 text-[11px] font-black uppercase tracking-widest <?= ($currentPage == 'dashboard.php') ? 'text-hero-blue border-l-4 border-hero-blue bg-slate-50' : 'text-gray-500' ?>">Dashboard</a>
            <?php else: ?>
                <a href="index.php" class="block px-3 py-4 text-[11px] font-black uppercase tracking-widest <?= ($currentPage == 'index.php') ? 'text-hero-blue border-l-4 border-hero-blue bg-slate-50' : 'text-gray-500' ?>">Home</a>
            <?php endif; ?>
            
            <a href="about.php" class="block px-3 py-4 text-[11px] font-black uppercase tracking-widest <?= ($currentPage == 'about.php') ? 'text-hero-blue border-l-4 border-hero-blue bg-slate-50' : 'text-gray-500' ?>">About Us</a>
            
            <div class="border-y border-gray-50">
                <p class="px-3 py-4 text-[11px] font-black uppercase tracking-widest text-gray-400">Training Modules</p>
                <div class="pl-6 space-y-1">
                    <a href="courses.php" class="block py-3 text-[10px] font-bold uppercase text-gray-500 hover:text-hero-orange">All Courses</a>
                    <a href="training.php" class="block py-3 text-[10px] font-bold uppercase text-gray-500 hover:text-hero-orange">Online Training</a>
                    <a href="classroom.php" class="block py-3 text-[10px] font-bold uppercase text-gray-500 hover:text-hero-orange">Classroom</a>
                </div>
            </div>

            <a href="staffing.php" class="block px-3 py-4 text-[11px] font-black uppercase tracking-widest <?= ($currentPage == 'staffing.php') ? 'text-hero-blue border-l-4 border-hero-blue bg-slate-50' : 'text-gray-500' ?>">Staffing</a>
            <a href="clients.php" class="block px-3 py-4 text-[11px] font-black uppercase tracking-widest <?= ($currentPage == 'clients.php') ? 'text-hero-blue border-l-4 border-hero-blue bg-slate-50' : 'text-gray-500' ?>">Clients</a>
            <a href="blog.php" class="block px-3 py-4 text-[11px] font-black uppercase tracking-widest <?= ($currentPage == 'blog.php') ? 'text-hero-blue border-l-4 border-hero-blue bg-slate-50' : 'text-gray-500' ?>">Blog</a>
            <a href="contact.php" class="block px-3 py-4 text-[11px] font-black uppercase tracking-widest <?= ($currentPage == 'contact.php') ? 'text-hero-blue border-l-4 border-hero-blue bg-slate-50' : 'text-gray-500' ?>">Contact</a>

            <div class="pt-6 pb-2 px-3">
                <?php if(isset($_SESSION['email'])): ?>
                    <a href="logout.php" class="block w-full text-center py-4 text-[11px] font-black uppercase tracking-widest text-red-500 border border-red-100 rounded-xl bg-red-50">Logout</a>
                <?php else: ?>
                    <div class="flex flex-col gap-3">
                        <a href="login.php" class="block w-full text-center py-4 text-[11px] font-black uppercase tracking-widest text-hero-blue border border-gray-100 rounded-xl">Login</a>
                        <a href="signup.php" class="block w-full text-center py-4 text-[11px] font-black uppercase tracking-widest bg-hero-orange text-white rounded-xl shadow-lg shadow-orange-500/20">Register & Pay</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <main>