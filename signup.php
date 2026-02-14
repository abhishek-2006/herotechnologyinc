<?php require 'config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <title>Hero Technology | Create Account</title>
    
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;   /* Derived from Logo Text */
            --color-hero-orange: #EE6C4D; /* Derived from Logo Icon */
            --color-app-bg: #F8FAFC;
            --color-card-bg: #FFFFFF;
            --color-border-dim: #E2E8F0;
            --color-text-primary: #0F172A;
            --font-display: "Inter", "Plus Jakarta Sans", sans-serif;
        }

        .dark {
            --color-app-bg: #020617;
            --color-card-bg: #0F172A;
            --color-border-dim: #1E293B;
            --color-text-primary: #F8FAFC;
        }

        @utility input-field {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
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

    <div class="min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">
        
        <button id="theme-toggle" class="absolute top-8 right-8 w-12 h-12 rounded-2xl bg-[var(--color-card-bg)] border border-[var(--color-border-dim)] flex items-center justify-center text-hero-orange shadow-lg cursor-pointer hover:scale-105 transition-transform z-50">
            <i id="theme-icon" class="fas fa-moon"></i>
        </button>

        <div class="max-w-xl w-full relative z-10">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center bg-white p-4 rounded-3xl shadow-2xl mb-6 h-20 w-48 overflow-hidden">
                    <img src="assets/img/logo.png" alt="Hero Technology Inc" class="w-full h-full object-contain">
                </div>
                <p class="text-gray-500 font-bold text-[10px] uppercase tracking-[0.4em] opacity-80">Create Your Account</p>
            </div>

            <div class="bg-[var(--color-card-bg)] p-8 sm:p-10 shadow-2xl rounded-[3rem] border border-[var(--color-border-dim)] transition-all duration-500">
                <form action="process/add_user.php" name="student-signup" id="student-signup" method="post" class="space-y-6">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Full Name</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-id-card text-xs"></i></div>
                                <input type="text" name="name" id="name" class="input-field" placeholder="John Doe" required />
                            </div>
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Account Username</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-fingerprint text-xs"></i></div>
                                <input type="text" name="username" id="username" class="input-field" placeholder="john_doe" required />
                            </div>
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Phone Number</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-phone text-xs"></i></div>
                            <input type="tel" name="phone" id="phone" class="input-field" placeholder="+91 01234 56789" required />
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Email</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-envelope text-xs"></i></div>
                            <input type="email" name="email" id="email" class="input-field" placeholder="johndoe@example.com" required />
                        </div>
                    </div>
                    
                    <!-- Gender -->
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Gender</label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-venus-mars text-xs"></i></div>
                            <select name="gender" id="gender" class="input-field" required>
                                <option value="" disabled selected>Select your gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Password</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-key text-xs"></i></div>
                                <input type="password" name="password" id="password" class="input-field" placeholder="••••••••" required />
                            </div>
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Confirm Password</label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-shield-halved text-xs"></i></div>
                                <input type="password" name="confirmpassword" id="confirmpassword" class="input-field" placeholder="••••••••" required />
                            </div>
                        </div>
                    </div>

                    <div class="bg-[var(--color-app-bg)] p-5 rounded-2xl border border-[var(--color-border-dim)] shadow-inner">
                        <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-gray-500 mb-4 px-1">Captcha</label>
                        <div class="flex flex-nowrap items-center gap-3">
                            <input type="text" name="vercode" maxlength="5" placeholder="CODE" required 
                                class="flex-1 min-w-0 px-4 py-3 bg-[var(--color-card-bg)] border border-[var(--color-border-dim)] rounded-xl text-center font-mono text-lg text-hero-orange tracking-[0.4em] uppercase focus:border-hero-orange outline-none transition-all" />
                            
                            <div class="flex-shrink-0 flex items-center gap-2">
                                <div class="h-12 w-28 bg-white rounded-xl overflow-hidden shadow-sm border border-[var(--color-border-dim)]">
                                    <img src="captcha.php" alt="Code" class="h-full w-full object-cover grayscale-0 opacity-100" id="captcha_img">
                                </div>
                                <button type="button" onclick="document.getElementById('captcha_img').src='captcha.php?'+Math.random();" 
                                    class="w-10 h-10 flex items-center justify-center rounded-xl text-gray-400 hover:text-hero-orange transition-colors active:scale-90">
                                    <i class="fas fa-rotate"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="signup" class="w-full py-4 bg-hero-blue text-white font-black rounded-xl shadow-lg shadow-blue-900/20 hover:shadow-blue-900/40 hover:-translate-y-0.5 transition-all active:scale-95 uppercase tracking-widest text-xs">
                        Register
                    </button>

                    <p class="text-center text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                        Already Have an Account? 
                        <a href="login.php" class="text-hero-orange hover:underline ml-1">Login now</a>
                    </p>
                </form>
            </div>
            
            <p class="text-center mt-8 text-gray-500 text-[10px] font-black uppercase tracking-[0.4em] opacity-40">
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