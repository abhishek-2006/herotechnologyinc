<?php require 'config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <title>Hero Technology | Create Account</title>
    
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>

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

        .error-text {
            @apply text-[9px] text-red-500 font-bold uppercase mt-1 ml-1;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--color-app-bg)] font-sans antialiased transition-colors duration-500">

    <div class="min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">
        
        <button id="theme-toggle" class="animate__animated animate__bounceInDown absolute top-8 right-8 w-12 h-12 rounded-2xl bg-[var(--color-card-bg)] border border-[var(--color-border-dim)] flex items-center justify-center text-hero-orange shadow-lg cursor-pointer hover:scale-105 transition-transform z-50">
            <i id="theme-icon" class="fas fa-moon"></i>
        </button>

        <div class="max-w-xl w-full relative z-10">
            <div class="text-center mb-8 animate__animated animate__fadeInDown">
                <div class="inline-flex items-center justify-center bg-white p-4 rounded-3xl shadow-2xl mb-6 h-20 w-48 overflow-hidden">
                    <img src="assets/img/logo.png" alt="Hero Technology Inc" class="w-full h-full object-contain">
                </div>
                <p class="text-gray-500 font-bold text-[10px] uppercase tracking-[0.4em] opacity-80">Create Your Account</p>
            </div>

            <div class="animate__animated animate__zoomIn bg-[var(--color-card-bg)] p-8 sm:p-10 shadow-2xl rounded-[3rem] border border-[var(--color-border-dim)] transition-all duration-500">
                <form action="process/add_user.php" name="student-signup" id="student-signup" method="post" class="space-y-4">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Full Name <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-id-card text-xs"></i></div>
                                <input type="text" name="name" id="name" class="input-field" placeholder="John Doe" />
                            </div>
                            <div id="name-error" class="error-text"></div>
                        </div>
                        <div class="group" id="user-container">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Username <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-fingerprint text-xs"></i></div>
                                <input type="text" name="username" id="username" class="input-field" placeholder="john_doe" />
                            </div>
                            <p id="user-status" class="text-[9px] font-bold uppercase tracking-tight mt-1 ml-1 min-h-[12px]"></p>
                            <div id="username-error" class="error-text"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Phone <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-phone text-xs"></i></div>
                                <input type="tel" name="phone" id="phone" class="input-field" placeholder="9876543210" />
                            </div>
                            <div id="phone-error" class="error-text"></div>
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Email <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-envelope text-xs"></i></div>
                                <input type="email" name="email" id="email" class="input-field" placeholder="johndoe@example.com" />
                            </div>
                            <div id="email-error" class="error-text"></div>
                        </div>
                    </div>
                    
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Gender <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-venus-mars text-xs"></i></div>
                            <select name="gender" id="gender" class="input-field">
                                <option value="" disabled selected>Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div id="gender-error" class="error-text"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Password <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-key text-xs"></i></div>
                                <input type="password" name="password" id="password" class="input-field" placeholder="••••••••" />
                            </div>
                            <div id="password-error" class="error-text"></div>
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2 ml-1">Confirm <span class="text-red-500">*</span></label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange"><i class="fas fa-shield-halved text-xs"></i></div>
                                <input type="password" name="confirmpassword" id="confirmpassword" class="input-field" placeholder="••••••••" />
                            </div>
                            <div id="confirmpassword-error" class="error-text"></div>
                        </div>
                    </div>

                    <div class="bg-[var(--color-app-bg)] p-4 rounded-2xl border border-[var(--color-border-dim)] shadow-inner">
                        <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-gray-500 mb-3 px-1">Captcha <span class="text-red-500">*</span></label>
                        <div class="flex flex-nowrap items-center gap-3">
                            <input type="text" name="vercode" id="vercode" maxlength="5" placeholder="CODE" 
                                class="flex-1 min-w-0 px-4 py-2.5 bg-[var(--color-card-bg)] border border-[var(--color-border-dim)] rounded-xl text-center font-mono text-lg text-hero-orange tracking-[0.4em] uppercase focus:border-hero-orange outline-none transition-all" />
                            <div class="flex-shrink-0 flex items-center gap-2">
                                <div class="h-10 w-24 bg-white rounded-xl overflow-hidden shadow-sm border border-[var(--color-border-dim)]">
                                    <img src="captcha.php" alt="Code" class="h-full w-full object-cover" id="captcha_img">
                                </div>
                                <button type="button" onclick="document.getElementById('captcha_img').src='captcha.php?'+Math.random();" 
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-hero-orange transition-colors active:scale-90">
                                    <i class="fas fa-rotate"></i>
                                </button>
                            </div>
                        </div>
                        <div id="vercode-error" class="error-text"></div>
                    </div>

                    <button type="submit" name="signup" class="w-full py-4 bg-hero-blue text-white font-black rounded-xl shadow-lg hover:shadow-blue-900/40 hover:-translate-y-0.5 transition-all active:scale-95 uppercase tracking-widest text-xs">
                        Register
                    </button>

                    <p class="text-center text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                        Already Have an Account? 
                        <a href="login.php" class="text-hero-orange hover:underline ml-1">Login now</a>
                    </p>
                </form>
            </div>
            <p class="text-center mt-6 text-gray-500 text-[10px] font-black uppercase tracking-[0.4em] opacity-40">&copy; 2026 Hero Technology Inc.</p>
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

        // Validate.js Implementation
        validate.extend(validate.validators.datetime, {
            parse: function(value, options) { return +moment.utc(value); },
            format: function(value, options) { return moment.utc(value).format(options.dateOnly ? "YYYY-MM-DD" : "YYYY-MM-DD hh:mm:ss"); }
        });

        const constraints = {
            name: { presence: { allowEmpty: false, message: "is required" }, length: { minimum: 3 } },
            username: { presence: { allowEmpty: false, message: "is required" }, length: { minimum: 3 } },
            phone: { presence: { allowEmpty: false, message: "is required" }, format: { pattern: "[0-9]{10}", message: "must be 10 digits" } },
            email: { presence: { allowEmpty: false, message: "is required" }, email: true },
            gender: { presence: { allowEmpty: false, message: "is required" } },
            password: { presence: { allowEmpty: false, message: "is required" }, length: { minimum: 6 } },
            confirmpassword: { equality: "password" },
            vercode: { presence: { allowEmpty: false, message: "is required" }, length: { is: 5 } }
        };

        const form = document.getElementById('student-signup');
        form.addEventListener('submit', function(ev) {
            document.querySelectorAll('.error-text').forEach(el => el.innerHTML = '');
            const values = validate.collectFormValues(form);
            const errors = validate(values, constraints);

            if (errors) {
                ev.preventDefault();
                Object.keys(errors).forEach(key => {
                    const errorMsg = errors[key][0];
                    const errorDiv = document.getElementById(key + '-error');
                    if (errorDiv) errorDiv.innerHTML = errorMsg;
                });
            }
        });

        // Username Availability logic from your snippet...
        let debounceTimer;
        document.getElementById('username').addEventListener('input', function() {
            const username = this.value.trim();
            const status = document.getElementById('user-status');
            if (!username) { status.innerText = ""; return; }
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(async () => {
                try {
                    const  response = await fetch(`process/check-username.php?username=${username}`);
                    const data = await response.json();
                    status.innerText = data.message;
                    status.style.color = data.available ? "#10b981" : "#EE6C4D";
                } catch (e) { console.error("Node failure"); }
            }, 300);
        });
    </script>
</body>
</html> 