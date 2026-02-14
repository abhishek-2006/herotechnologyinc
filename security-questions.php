<?php 
    require 'config.php';
    
    $questions_res = mysqli_query($conn, "SELECT * FROM security_questions");
    if (!$questions_res) {
        die("Database Error: " . mysqli_error($conn));
    }
    $questions = mysqli_fetch_all($questions_res, MYSQLI_ASSOC);
    $user_id = $_SESSION['user_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Security Vault | Hero Technology</title>
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
        }

        /* Logic for Light & Dark Theme Variables */
        :root {
            --app-bg: radial-gradient(circle at top, #F8FAFC 0%, #E2E8F0 100%);
            --card-bg: rgba(255, 255, 255, 0.8);
            --text-main: #1B264F;
            --text-muted: #64748B;
            --input-bg: rgba(255, 255, 255, 0.5);
            --border: rgba(0, 0, 0, 0.05);
        }

        .dark {
            --app-bg: radial-gradient(circle at top, #0F172A 0%, #020617 100%);
            --card-bg: rgba(15, 23, 42, 0.6);
            --text-main: #F8FAFC;
            --text-muted: #94A3B8;
            --input-bg: rgba(0, 0, 0, 0.2);
            --border: rgba(255, 255, 255, 0.05);
        }

        body {
            background: var(--app-bg);
            color: var(--text-main);
            transition: background 0.5s ease;
        }

        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
        }

        .input-node {
            background: var(--input-bg);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 antialiased">

    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-hero-orange/10 dark:bg-hero-orange/5 blur-[120px] pointer-events-none"></div>

    <div class="max-w-2xl w-full">
        <div class="flex justify-between items-center mb-10">
            <div class="glass-card px-6 py-3 rounded-2xl flex items-center gap-3">
                <img src="assets/img/logo.png" alt="Hero Tech" class="h-6 dark:invert">
                <span class="text-[9px] font-black uppercase tracking-[0.4em] opacity-40">Vault</span>
            </div>
            
            <button onclick="toggleTheme()" class="glass-card w-12 h-12 rounded-2xl flex items-center justify-center cursor-pointer hover:scale-110 transition-transform">
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:block text-hero-orange"></i>
            </button>
        </div>
    
        <div class="glass-card rounded-[3rem] p-12 relative overflow-hidden shadow-2xl">
            <header class="mb-12">
                <h1 class="text-4xl font-black italic tracking-tighter uppercase leading-none">
                    Security <span class="text-hero-orange not-italic">Protocol</span>
                </h1>
                <p class="text-[10px] font-bold opacity-50 uppercase tracking-widest mt-4 flex items-center gap-2">
                    <i class="fas fa-shield-halved text-hero-orange"></i> Secure your identity markers
                </p>
            </header>

            <form action="process/verify_security.php" method="POST" class="space-y-8">
                <?php for($i = 1; $i <= 3; $i++): ?>
                <div class="space-y-3">
                    <label class="text-[9px] font-black uppercase tracking-widest opacity-40 ml-1">Question 0<?= $i ?></label>
                    
                    <div class="input-node rounded-2xl overflow-hidden focus-within:ring-2 focus-within:ring-hero-orange/50">
                        <select name="q_id_<?= $i ?>" class="question-selector w-full bg-transparent px-5 py-4 text-sm font-bold outline-none cursor-pointer dark:text-white">
                            <option value="" disabled selected class="dark:bg-slate-900">Choose a question...</option>
                            <?php foreach($questions as $q): ?>
                                <option value="<?= $q['id'] ?>" class="text-black dark:bg-slate-900 dark:text-white">
                                    <?= htmlspecialchars($q['question_text']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-node rounded-2xl px-5 focus-within:bg-white/10">
                        <input type="text" name="answer_<?= $i ?>" 
                            class="w-full bg-transparent py-4 text-sm font-medium outline-none placeholder:opacity-30" 
                            placeholder="Your secure response..." required>
                    </div>
                </div>
                <?php endfor; ?>

                <button type="submit" class="w-full bg-hero-blue dark:bg-hero-orange text-white py-6 rounded-3xl font-black uppercase tracking-[0.2em] text-[11px] shadow-xl hover:scale-[1.02] transition-all">
                    Submit Answers
                </button>
            </form>
        </div>
    </div>

    <script>
        // Theme Management Logic
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        }

        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark');

        // No-Repeat Logic
        const selectors = document.querySelectorAll('.question-selector');
        selectors.forEach(selector => {
            selector.addEventListener('change', () => {
                const selectedValues = Array.from(selectors).map(s => s.value);
                selectors.forEach(s => {
                    const currentVal = s.value;
                    Array.from(s.options).forEach(option => {
                        if (option.value !== "" && selectedValues.includes(option.value) && option.value !== currentVal) {
                            option.style.display = 'none';
                        } else {
                            option.style.display = 'block';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>