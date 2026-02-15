<?php 
require 'config.php';

// Determine Mode: Recovery vs. First-time Setup
$recovery_mode = isset($_SESSION['recovery_user_id']);
$target_user_id = $recovery_mode ? $_SESSION['recovery_user_id'] : ($_SESSION['user_id'] ?? null);

// Guard: Ensure an identity node is present
if (!$target_user_id) {
    header("Location: login.php?error=identity_missing");
    exit();
}

if ($recovery_mode) {
    // Fetch ONLY the questions previously answered by this specific user
    $sql = "SELECT sq.id, sq.question_text 
            FROM user_security_answers ua 
            JOIN security_questions sq ON ua.question_id = sq.id 
            WHERE ua.user_id = '$target_user_id'";
} else {
    // Fetch the FULL pool for initial setup
    $sql = "SELECT * FROM security_questions";
}

$questions_res = mysqli_query($conn, $sql);
$questions = mysqli_fetch_all($questions_res, MYSQLI_ASSOC);
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
    <div class="glass-card rounded-[3rem] p-12 relative overflow-hidden shadow-2xl max-w-2xl w-full">
    <header class="mb-12">
        <h1 class="text-4xl font-black italic tracking-tighter uppercase leading-none text-hero-blue dark:text-white">
            Security <span class="text-hero-orange not-italic"><?= $recovery_mode ? 'Challenge' : 'Vault' ?></span>
        </h1>
    </header>

    <form action="process/verify_security.php" method="POST" class="space-y-8">
        <?php 
        $loop_count = $recovery_mode ? count($questions) : 3;
        for($i = 0; $i < $loop_count; $i++): 
            $display_index = $i + 1;
        ?>
        <div class="space-y-3">
            <label class="text-[9px] font-black uppercase tracking-widest opacity-40">Marker 0<?= $display_index ?></label>
            
            <div class="input-node rounded-2xl overflow-hidden px-5 py-4">
                <?php if($recovery_mode): ?>
                    <p class="text-sm font-bold"><?= htmlspecialchars($questions[$i]['question_text']) ?></p>
                    <input type="hidden" name="q_id_<?= $display_index ?>" value="<?= $questions[$i]['id'] ?>">
                <?php else: ?>
                    <select name="q_id_<?= $display_index ?>" class="question-selector w-full bg-transparent text-sm font-bold outline-none cursor-pointer">
                        <option value="" disabled selected>Select a security question...</option>
                        <?php foreach($questions as $q): ?>
                            <option value="<?= $q['id'] ?>"><?= htmlspecialchars($q['question_text']) ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>

            <div class="input-node rounded-2xl px-5">
                <input type="text" name="answer_<?= $display_index ?>" 
                       class="w-full bg-transparent py-4 text-sm font-medium outline-none" 
                       placeholder="Response..." required>
            </div>
        </div>
        <?php endfor; ?>

        <button type="submit" name="<?= $recovery_mode ? 'verify_recovery' : 'setup_vault' ?>" class="w-full bg-hero-blue dark:bg-hero-orange text-white py-6 rounded-3xl font-black uppercase tracking-widest text-[11px]">
            <?= $recovery_mode ? 'Validate Identity' : 'Lock Security Vault' ?>
        </button>
    </form>
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