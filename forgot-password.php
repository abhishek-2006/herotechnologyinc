<?php require 'config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <title>Hero Tech | Recover Access</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;   /* Navy from Logo */
            --color-hero-orange: #EE6C4D; /* Orange from Logo */
            --color-app-bg: #F8FAFC;
            --color-card-bg: #FFFFFF;
            --color-border-dim: #E2E8F0;
            --color-text-primary: #0F172A;
            --font-display: "Inter", system-ui, sans-serif;
        }

        .dark {
            --color-app-bg: #020617;
            --color-card-bg: #0F172A;
            --color-border-dim: #1E293B;
            --color-text-primary: #F8FAFC;
        }

        @utility input-field {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 3.25rem;
            background-color: var(--color-app-bg);
            border: 1px solid var(--color-border-dim);
            border-radius: 1rem;
            color: var(--color-text-primary);
            transition: all 0.2s ease;
            outline: none;

            &:focus {
                border-color: var(--color-hero-orange);
                box-shadow: 0 0 0 4px rgba(238, 108, 77, 0.1);
            }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--color-app-bg)] font-display antialiased transition-colors duration-500">

    <div class="min-h-screen flex flex-col items-center justify-center p-6 relative">
        
        <button id="theme-toggle" class="absolute top-6 right-6 w-12 h-12 rounded-2xl bg-[var(--color-card-bg)] border border-[var(--color-border-dim)] flex items-center justify-center text-hero-orange shadow-lg cursor-pointer hover:scale-105 transition-transform active:scale-95 z-50">
            <i id="theme-icon" class="fas fa-moon"></i>
        </button>

        <div class="max-w-md w-full relative z-10">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center bg-white p-4 rounded-3xl shadow-2xl mb-6 h-20 w-48 overflow-hidden">
                    <img src="assets/img/logo.png" alt="Hero Tech" class="w-full h-full object-contain">
                </div>
                <p class="text-gray-500 font-bold text-[10px] uppercase tracking-[0.4em] opacity-80">Security Protocol: Recover Access</p>
            </div>

            <div class="bg-[var(--color-card-bg)] p-8 sm:p-10 shadow-2xl rounded-[2.5rem] border border-[var(--color-border-dim)]">
                
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-[var(--color-text-primary)] uppercase italic tracking-tight">Recover Node</h2>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed">
                        Enter your registered email identity. We will verify your credentials and initialize a reset token.
                    </p>
                </div>

                <form action="process/reset_password.php" method="POST" class="space-y-6">
                    
                    <div class="relative group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Account Identity</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange transition-colors">
                                <i class="fas fa-fingerprint text-lg"></i>
                            </div>
                            <input type="email" name="email" class="input-field" placeholder="engineer@herotech.com" required />
                        </div>
                    </div>

                    <div class="bg-[var(--color-app-bg)] p-5 rounded-3xl border border-[var(--color-border-dim)] shadow-inner">
                        <div class="flex items-center justify-between mb-4 px-1">
                            <label class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-500">Identity Check</label>
                            <span class="text-hero-orange text-[9px] font-bold tracking-widest opacity-50">NODE_AUTH</span>
                        </div>
                        
                        <div class="flex flex-nowrap items-center gap-3">
                            <input type="text" name="vercode" maxlength="5" placeholder="CODE" required 
                                class="w-full min-w-0 px-4 py-3 bg-[var(--color-card-bg)] border border-[var(--color-border-dim)] rounded-xl text-center font-mono text-lg text-hero-orange tracking-[0.4em] uppercase outline-none focus:border-hero-orange transition-all shadow-sm" />
                            
                            <div class="flex-shrink-0 flex items-center gap-2">
                                <div class="h-12 w-28 bg-white rounded-xl overflow-hidden shadow-sm border border-[var(--color-border-dim)]">
                                    <img src="captcha.php" alt="Code" class="h-full w-full object-cover grayscale-0 opacity-100" id="captcha_node">
                                </div>
                                <button type="button" onclick="document.getElementById('captcha_node').src='captcha.php?'+Math.random();" 
                                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-[var(--color-card-bg)] border border-[var(--color-border-dim)] text-gray-400 hover:text-hero-orange transition-all active:scale-90 shadow-sm">
                                    <i class="fas fa-rotate"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="recover" class="w-full py-4 bg-hero-blue text-white font-black rounded-xl shadow-lg shadow-blue-900/20 hover:shadow-blue-900/40 hover:-translate-y-0.5 transition-all active:scale-95 uppercase tracking-[0.2em] text-xs">
                        Initialize Token Request
                    </button>

                    <div class="text-center pt-2">
                        <a href="login.php" class="text-[10px] font-black text-gray-500 hover:text-hero-orange uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left"></i> Return to Login
                        </a>
                    </div>
                </form>
            </div>

            <p class="text-center mt-10 text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] opacity-40">
                &copy; 2026 Hero Technology Inc. Auth_Recovery v4.0
            </p>
        </div>
    </div>

    <script>
        const root = document.documentElement;
        const themeBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        themeBtn.addEventListener('click', () => {
            root.classList.toggle('dark');
            const isDark = root.classList.contains('dark');
            themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
        });
    </script>
</body>
</html>