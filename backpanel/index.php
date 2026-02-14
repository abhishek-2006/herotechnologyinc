<?php require '../config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Hero Technology Inc. Internal Management Node - Admin Terminal Login Portal" />
    <meta name="author" content="Hero Technology Inc." />
    <title>Hero Technology | Admin Terminal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;   
            --color-hero-orange: #EE6C4D; 
            --color-terminal-bg: #F8FAFC;
            --color-card-bg: #FFFFFF;
            --color-border-dim: #E2E8F0;
            --font-display: "Inter", "Plus Jakarta Sans", sans-serif;
        }

        @utility input-field {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 3.25rem;
            background-color: var(--color-terminal-bg);
            border: 1px solid var(--color-border-dim);
            border-radius: 1rem;
            color: var(--color-hero-blue);
            transition: all 0.3s ease;
            outline: none;

            &::placeholder { color: #94A3B8; }

            &:focus {
                border-color: var(--color-hero-orange);
                box-shadow: 0 0 0 4px rgba(238, 108, 77, 0.1);
                background-color: white;
            }
        }
    </style>
</head>
<body class="bg-[var(--color-terminal-bg)] font-display antialiased min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full">
        
        <div class="text-center mb-10">
            <div class="inline-block p-6 rounded-[2.5rem] mb-6">
                <img src="assets/img/logo.png" alt="Hero Technology" class="h-14 w-auto object-contain">
            </div>
            <h1 class="text-2xl font-black tracking-tighter text-hero-blue uppercase leading-none">
                Admin<span class="text-hero-orange">.Terminal</span>
            </h1>
            <p class="text-slate-400 text-[10px] font-black mt-4 tracking-[0.4em] uppercase opacity-70">Internal Management Node</p>
        </div>

        <div class="bg-white rounded-[3rem] p-8 sm:p-10 shadow-[0_30px_80px_-20px_rgba(27,38,79,0.12)] border border-slate-100">
            <form name="admin-login" action="process/auth.php" method="post" class="space-y-6">
                
                <div class="space-y-5">
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Personnel ID</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-5 text-slate-300 group-focus-within:text-hero-orange transition-colors">
                                <i class="fas fa-id-badge"></i>
                            </div>
                            <input type="text" name="username" class="input-field" placeholder="Admin Username" required />
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-2">Access Key</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-5 text-slate-300 group-focus-within:text-hero-orange transition-colors">
                                <i class="fas fa-shield-halved"></i>
                            </div>
                            <input type="password" name="password" class="input-field" placeholder="••••••••" required />
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 shadow-inner">
                    <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 px-2">Identity Verification</label>
                    
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <input type="text" name="vercode" maxlength="5" placeholder="CODE" required 
                            class="flex-1 min-w-0 px-4 py-3 bg-white border border-slate-200 rounded-xl text-center font-mono text-lg text-hero-orange tracking-[0.4em] uppercase focus:border-hero-orange outline-none transition-all shadow-sm" />
                        
                        <div class="flex items-center gap-2 h-12">
                            <div class="h-full w-28 bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200">
                                <img src="../captcha.php" alt="Code" class="h-full w-full object-contain p-1">
                            </div>
                            <button type="button" onclick="this.previousElementSibling.firstElementChild.src='../captcha.php?'+Math.random();" 
                                class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-hero-orange active:scale-90 transition-all">
                                <i class="fas fa-rotate"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" name="admin_login" class="w-full py-4 bg-hero-blue text-white font-black rounded-xl shadow-lg shadow-blue-900/20 hover:bg-hero-orange hover:shadow-orange-500/20 transition-all active:scale-[0.98] tracking-[0.2em] uppercase text-[11px]">
                    Login
                </button>
            </form>
        </div>

        <div class="mt-8 text-center px-4">
            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] leading-relaxed">
                Hero Technology Inc. Security Layer 
            </p>
        </div>
    </div>
</body>
</html>