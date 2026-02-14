<?php 
require '../config.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 1. Fetch Aggregated Financial Data
$totalRevenue = mysqli_fetch_row(mysqli_query($conn, "SELECT SUM(amount) FROM payments WHERE payment_status='success'"))[0] ?: 0;
$pendingRevenue = mysqli_fetch_row(mysqli_query($conn, "SELECT SUM(amount) FROM payments WHERE payment_status='pending'"))[0] ?: 0;
$totalTransactions = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM payments WHERE payment_status='success'"))[0] ?: 0;

// 2. Fetch Recent Transactions with Student and Course Context
$sqlTransactions = "
    SELECT p.*, u.name as student_name, c.title as course_title 
    FROM payments p
    JOIN user_master u ON p.user_id = u.user_id
    JOIN courses c ON p.course_id = c.course_id
    ORDER BY p.payment_date DESC
    LIMIT 10
";
$resTransactions = mysqli_query($conn, $sqlTransactions);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Reports | Hero Admin Terminal</title>
    
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    
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
                <h1 class="text-4xl font-black tracking-tighter uppercase italic text-hero-blue dark:text-white">Revenue <span class="text-hero-orange not-italic">Audit</span></h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Monitoring global transaction dispatches</p>
            </div>
            <button class="px-8 py-4 bg-hero-orange text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-orange-500/20 hover:-translate-y-1 transition-all">
                <i class="fas fa-download mr-2"></i> Export CSV
            </button>
        </header>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-[var(--color-side-bg)] p-8 rounded-[2.5rem] border border-[var(--color-border-dim)] shadow-sm">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2">Verified Revenue</p>
                <h3 class="text-3xl font-black text-emerald-500 italic uppercase">₹<?php echo number_format($totalRevenue, 2); ?></h3>
                <p class="text-[8px] font-bold text-slate-500 mt-2 uppercase tracking-widest">Total Successful Dispatches</p>
            </div>
            <div class="bg-[var(--color-side-bg)] p-8 rounded-[2.5rem] border border-[var(--color-border-dim)] shadow-sm">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2">Pending Nodes</p>
                <h3 class="text-3xl font-black text-amber-500 italic uppercase">₹<?php echo number_format($pendingRevenue, 2); ?></h3>
                <p class="text-[8px] font-bold text-slate-500 mt-2 uppercase tracking-widest">Awaiting System Verification</p>
            </div>
            <div class="bg-[var(--color-side-bg)] p-8 rounded-[2.5rem] border border-[var(--color-border-dim)] shadow-sm">
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-2">Transaction Count</p>
                <h3 class="text-3xl font-black text-hero-blue dark:text-white italic uppercase"><?php echo $totalTransactions; ?></h3>
                <p class="text-[8px] font-bold text-slate-500 mt-2 uppercase tracking-widest">Active Enrollment Invoices</p>
            </div>
        </section>

        <div class="bg-[var(--color-side-bg)] rounded-[3rem] border border-[var(--color-border-dim)] shadow-sm overflow-hidden">
            <div class="p-10 border-b border-[var(--color-border-dim)]">
                <h2 class="text-xl font-black uppercase italic tracking-tighter text-hero-blue dark:text-white">Transaction <span class="text-hero-orange">Ledger</span></h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-hero-blue/5 border-b border-[var(--color-border-dim)]">
                        <tr>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reference ID</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Student Node</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Amount</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Timestamp</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Method</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--color-border-dim)]">
                        <?php while($row = mysqli_fetch_assoc($resTransactions)): ?>
                        <tr class="hover:bg-hero-orange/[0.02] transition-colors group">
                            <td class="px-10 py-6">
                                <p class="text-[10px] font-mono font-bold text-hero-blue dark:text-white uppercase">#TXN-<?php echo $row['payment_id']; ?></p>
                            </td>
                            <td class="px-10 py-6">
                                <p class="text-sm font-black uppercase tracking-tight text-slate-700 dark:text-slate-300"><?php echo htmlspecialchars($row['student_name']); ?></p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase"><?php echo htmlspecialchars($row['course_title']); ?></p>
                            </td>
                            <td class="px-10 py-6">
                                <span class="font-black text-hero-blue dark:text-white">₹<?php echo number_format($row['amount'], 2); ?></span>
                            </td>
                            <td class="px-10 py-6 text-center text-[10px] font-bold text-slate-500 uppercase">
                                <?php echo date('d M Y | H:i', strtotime($row['payment_date'])); ?>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <span class="px-4 py-1.5 bg-hero-blue/10 text-hero-blue text-[9px] font-black rounded-full uppercase tracking-widest">
                                    <?php echo $row['payment_method']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>