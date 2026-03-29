<?php 
require 'config.php'; 

$error = '';
$step = isset($_GET['step']) ? $_GET['step'] : 'identity';

if ($step === 'reset' && !isset($_SESSION['recovery_user_id'])) {
    header("Location: forgot-password.php?error=unauthorized access");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recover'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $sql = "SELECT user_id FROM user_master WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION['recovery_user_id'] = $user_data['user_id'];
        header("Location: security-questions.php");
        exit();
    } else {
        $error = "IDENTITY_NOT_FOUND: This email identity is not registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <title>Hero Tech | Recover Access</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --color-hero-blue: #1B264F;   /* Navy from Logo */
            --color-hero-orange: #EE6C4D; /* Orange from Logo */
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
        
        .error-text {
            @apply text-[9px] text-red-500 font-black uppercase mt-1 ml-1;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[var(--color-app-bg)] font-sans antialiased transition-colors duration-500">
    <div class="min-h-screen flex flex-col items-center justify-center p-6 relative">
        <div class="max-w-md w-full relative z-10">
            <div class="bg-[var(--color-card-bg)] p-8 sm:p-10 shadow-2xl rounded-[2.5rem] border border-[var(--color-border-dim)]">
                
                <?php if($error || isset($_GET['error'])): ?>
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-[10px] font-black uppercase tracking-widest text-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> 
                        <?= $error ?: htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <?php if ($step === 'reset'): ?>
                    <div class="mb-8">
                        <h2 class="text-2xl font-black text-[var(--color-text-primary)] uppercase italic tracking-tight">Reset Password</h2>
                        <p class="text-sm text-gray-500 font-medium leading-relaxed">
                            Identity verified. Please enter a new password for your account.
                        </p>
                    </div>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-[10px] font-black uppercase tracking-widest text-center animate-pulse">
                            <i class="fas fa-exclamation-circle mr-2"></i> 
                            <?php 
                                // Mapping system errors to user-friendly messages
                                $err = $_GET['error'];
                                if ($err == 'no_change') echo "NODE_SYNC_ERROR: The new password cannot be the same as the old one.";
                                elseif ($err == 'unauthorized access') echo "ACCESS_DENIED: Security challenge not completed.";
                                else echo htmlspecialchars($err);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form id="reset-password-form" action="process/reset_password.php" method="POST" class="space-y-6">
                        <div class="relative group">
                            <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange transition-colors">
                                    <i class="fas fa-key text-lg"></i>
                                </div>
                                <input type="password" name="password" id="password" class="input-field" placeholder="••••••••"/>
                            </div>
                            <div class="error-text" id="password-error"></div>
                        </div>

                        <div class="relative group">
                            <label for="confirmpassword" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange transition-colors">
                                    <i class="fas fa-shield-check text-lg"></i>
                                </div>
                                <input type="password" name="confirmpassword" id="confirmpassword" class="input-field" placeholder="••••••••" />
                            </div>
                            <div id="confirmpassword-error" class="error-text"></div>
                        </div>

                        <button type="submit" name="finalize" class="w-full py-4 bg-emerald-600 text-white font-black rounded-xl shadow-lg shadow-emerald-900/20 hover:bg-emerald-500 transition-all active:scale-95 uppercase tracking-[0.2em] text-xs">
                            Update Password
                        </button>
                    </form>

                <?php else: ?>
                    <div class="mb-8">
                        <h2 class="text-2xl font-black text-[var(--color-text-primary)] uppercase italic tracking-tight">Reset Password</h2>
                        <p class="text-sm text-gray-500 font-medium leading-relaxed">
                            Enter your registered email to reset password.
                        </p>
                    </div>

                    <form id="recover-form" method="POST" class="space-y-6">
                        <div class="relative group">
                            <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">
                                Account Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <div class="absolute left-4 text-gray-400 group-focus-within:text-hero-orange transition-colors">
                                    <i class="fas fa-fingerprint text-lg"></i>
                                </div>
                                <input type="email" name="email" id="email" class="input-field" placeholder="johndoe@example.com" />
                            </div>
                            <div id="email-error" class="error-text"></div>
                        </div>

                        <button type="submit" name="recover" class="w-full py-4 bg-hero-blue text-white font-black rounded-xl shadow-lg hover:bg-hero-orange transition-all active:scale-95 uppercase tracking-[0.2em] text-xs">
                            Validate Identity
                        </button>
                    </form>
                <?php endif; ?>

                <div class="text-center pt-6 border border-t border-[var(--color-border-dim)] mt-6">
                    <a href="login.php" class="text-[10px] font-black text-gray-500 hover:text-hero-orange uppercase tracking-widest transition-colors">
                        <i class="fas fa-arrow-left text-gray-400 mr-2"></i> Return to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        const recoverConstraints = {
            email: {
                presence: { allowEmpty: false, message: "^Email identity required" },
                email: { message: "^Invalid email format" }
            }
        };

        const resetConstraints = {
            password: {
                presence: { allowEmpty: false, message: "^Password required" },
                length: { minimum: 6, message: "^Must be at least 6 characters" }
            },
            confirmpassword: {
                presence: { allowEmpty: false, message: "^Confirm password required" },
                equality: { attribute: "password", message: "^Password and Confirm password do not match" }
            }
        };

        function handleValidation(formId, constraints) {
            const form = document.getElementById(formId);
            if (!form) return;

            form.addEventListener('submit', function(ev) {
                document.querySelectorAll('.error-text').forEach(el => el.innerHTML = '');
                const values = validate.collectFormValues(form);
                const errors = validate(values, constraints);

                if (errors) {
                    ev.preventDefault();
                    Object.keys(errors).forEach(key => {
                        const errorDiv = document.getElementById(key + '-error');
                        if (errorDiv) errorDiv.innerHTML = errors[key][0];
                    });
                }
            });
        }

        handleValidation('recover-form', recoverConstraints);
        handleValidation('reset-password-form', resetConstraints);
    </script>
</body>
</html>