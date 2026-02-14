<?php require 'config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <title>Hero Technology Inc. | Login</title>
    
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;
            --color-hero-orange: #EE6C4D;
            --color-app-bg: #F8FAFC;
            --color-card-bg: #FFFFFF;
            --color-border-dim: #E2E8F0;
            --color-text-primary: #0F172A;
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
<body class="bg-[var(--color-app-bg)] font-sans antialiased transition-colors duration-500">

    <div class="min-h-screen flex flex-col items-center justify-center p-6 relative">
        
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-hero-blue/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-hero-orange/5 rounded-full blur-[120px]"></div>

        <button id="theme-toggle" class="absolute top-6 right-6 w-12 h-12 rounded-2xl bg-[var(--color-card-bg)] border border-[var(--color-border-dim)] flex items-center justify-center text-hero-orange shadow-lg cursor-pointer hover:scale-105 transition-transform active:scale-95">
            <i id="theme-icon" class="fas fa-moon"></i>
        </button>

        <div class="max-w-md w-full relative z-10">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center p-4 rounded-3xl mb-6 h-20 w-48 overflow-hidden">
                    <img src="assets/img/logo.png" alt="Hero Technology Inc" class="w-full h-full object-contain">
                </div>
                <p class="text-gray-500 font-bold text-[10px] uppercase tracking-[0.4em] opacity-80">Access Intelligence Node</p>
            </div>

            <div class="bg-[var(--color-card-bg)] p-8 sm:p-10 shadow-2xl rounded-[2.5rem] border border-[var(--color-border-dim)] transition-all duration-500">
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-[var(--color-text-primary)] uppercase italic tracking-tight">Initialize Session</h2>
                    <p class="text-gray-500 text-sm font-medium">Synchronizing credentials with core server.</p>
                </div>
                
                <form name="student-login" id="student-login" action="process/auth.php" method="POST" class="space-y-6">

                    <div class="relative group">
                        <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Account ID</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 flex items-center text-gray-400 group-focus-within:text-hero-orange transition-colors">
                                <i class="fas fa-id-badge text-lg"></i>
                            </span>
                            <input id="email" class="input-field" type="text" name="email" placeholder="Email or Username" required autocomplete="off" />
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <div class="flex justify-between items-center mb-2 ml-1">
                            <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Password</label>
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-hero-orange transition-colors">
                                <i class="fas fa-shield-halved text-lg"></i>
                            </span>
                            <input id="password" class="input-field" type="password" name="password" placeholder="••••••••" required autocomplete="off" />
                        </div>
                        <div class="forgot-passowrd">
                            <a href="forgot-password.php" class="block text-[10px] font-bold text-hero-orange hover:underline uppercase tracking-tighter text-end mt-2">Forgot Password?</a>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-[2rem] border border-gray-100 shadow-inner overflow-hidden">
                        <div class="flex items-center justify-between mb-4 px-1">
                            <label for="vercode" class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">
                                Captcha
                            </label>
                            <span class="text-hero-blue text-[9px] font-bold tracking-widest opacity-40">SECURE_NODE</span>
                        </div>
                        
                        <div class="flex flex-nowrap items-center gap-3">
                            <input id="vercode" type="text" name="vercode" maxlength="5" placeholder="CODE" required 
                                class="w-full min-w-0 px-4 py-3.5 bg-white border border-gray-200 rounded-xl text-center font-mono text-lg text-hero-blue tracking-[0.5em] uppercase outline-none focus:border-hero-orange transition-all shadow-sm" />
                            
                            <div class="flex-shrink-0 flex items-center gap-2">
                                <div class="h-12 w-28 bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200 relative group">
                                    <img src="captcha.php" alt="Code" id="captcha_img" 
                                        class="h-full w-full object-cover block grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all">
                                    
                                    <button type="button" onclick="document.getElementById('captcha_img').src='captcha.php?'+Math.random();" 
                                        class="absolute inset-0 bg-hero-blue/10 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer">
                                        <i class="fas fa-sync-alt text-hero-blue text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <button type="submit" name="login" class="w-full py-4 bg-hero-blue text-white font-black rounded-xl shadow-lg shadow-blue-900/20 hover:shadow-blue-900/40 hover:-translate-y-0.5 transition-all duration-300 active:scale-95 uppercase tracking-[0.2em] text-xs">
                        Login
                    </button>
                    
                    <div class="text-center pt-2">
                        <p class="text-xs text-gray-500 font-bold">
                            New User? 
                            <a href="signup.php" class="text-hero-orange hover:underline ml-1">Register Now</a>
                        </p>
                    </div>

                </form>
            </div>
            
            <p class="text-center mt-10 text-gray-500 text-[10px] font-black uppercase tracking-[0.4em] opacity-50">
                &copy; 2026 Hero Technology Inc.
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