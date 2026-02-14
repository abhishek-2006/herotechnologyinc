<?php 
require '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT 
            e.enrollment_id, 
            e.status, 
            e.cashfree_order_id, 
            u.name as student_name, 
            c.title as course_title,
            p.amount as amount_paid,
            p.transaction_id as gateway_id
          FROM enrollments e
          JOIN user_master u ON e.user_id = u.user_id
          JOIN courses c ON e.course_id = c.course_id
          LEFT JOIN payments p ON e.enrollment_id = p.enrollment_id
          ORDER BY e.enrollment_id DESC";
$result = mysqli_query($conn, $query);

// 2. Fetch Global Stats
$stats_res = mysqli_query($conn, "SELECT SUM(amount) as total_rev FROM payments WHERE payment_status = 'SUCCESS'");
$stats = mysqli_fetch_assoc($stats_res);
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Ledger | Hero Admin Terminal</title>
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
        <header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase italic">
                    Revenue <span class="text-hero-orange not-italic">Ledger</span>
                </h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Financial node synchronization</p>
            </div>
            
            <div class="bg-[var(--card-bg)] px-8 py-4 rounded-2xl border border-[var(--border-color)]">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Total Revenue</p>
                <p class="text-xl font-black italic text-hero-orange">₹<?= number_format($stats['total_rev'] ?? 0, 2) ?></p>
            </div>
        </header>

        <div class="bg-[var(--card-bg)] rounded-[3rem] border border-[var(--border-color)] shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-hero-blue/5 border-b border-[var(--border-color)]">
                    <tr>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest">Transaction Node</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest">Student</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-center">Amount</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-widest text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-color)]">
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-hero-orange/[0.02] transition-colors">
                            <td class="px-10 py-6">
                                <p class="text-[10px] font-black uppercase text-hero-blue dark:text-white">
                                    <span class="opacity-40">ORD:</span> <?= $row['cashfree_order_id'] ?>
                                </p>
                                <p class="text-[9px] font-mono text-hero-orange font-bold mt-1">
                                    <span class="opacity-40 text-slate-500 uppercase">TXN:</span> <?= $row['gateway_id'] ?? '---' ?>
                                </p>
                            </td>
                            <td class="px-10 py-6">
                                <p class="text-xs text-slate-500 font-bold uppercase"><?= htmlspecialchars($row['student_name']) ?></p>
                                <p class="text-[9px] font-black uppercase text-hero-blue dark:text-blue-400 mt-1"><?= htmlspecialchars($row['course_title']) ?></p>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <p class="text-sm font-black text-hero-orange italic">
                                    ₹<?= number_format($row['amount_paid'] ?? 0, 2) ?>
                                </p>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <?php if($row['status'] == 'active'): ?>
                                    <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-500 text-[8px] font-black rounded-full uppercase border border-emerald-500/20">Success</span>
                                <?php else: ?>
                                    <span class="px-4 py-1.5 bg-amber-500/10 text-amber-500 text-[8px] font-black rounded-full uppercase border border-amber-500/20">Pending</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        if(localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>