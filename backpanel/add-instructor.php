<?php
require '../config.php';

// 1. Session & Identity Verification
if (!isset($_SESSION['user_id']) && !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

require 'sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Instructors | Hero Tech</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
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
<body class="flex">
    <div class="flex-1 p-10">
        <h1 class="text-2xl font-black text-hero-blue mb-6">Instructor Management</h1>
        <p class="text-gray-500 mb-8">Add, edit, or remove instructors from your training platform.</p>

        <!-- Instructor Management Interface -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-700">Instructors</h2>
                <a href="add-instructor.php" class="px-4 py-2 bg-hero-orange text-white rounded-lg text-sm font-semibold hover:bg-orange-600 transition-colors">
                    <i class="fas fa-plus mr-1"></i> Add Instructor
                </a>
            </div>

            <!-- Placeholder for instructor list table -->
        </div>
    </div>
</body>
</html>