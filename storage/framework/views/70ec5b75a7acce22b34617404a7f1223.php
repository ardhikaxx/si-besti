

<?php $__env->startSection('title', 'Login - SI Besti'); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-body">
                <!-- Logo -->
                <div class="auth-logo">
                    <i class="fas fa-lock"></i>
                </div>

                <!-- Header -->
                <div class="auth-header">
                    <h1 class="auth-title">Selamat Datang</h1>
                    <p class="auth-subtitle">Silakan masuk ke akun Anda</p>
                </div>

                <!-- Form -->
                <form id="loginForm" method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <!-- Error Messages -->
                    <?php if($errors->has('login_error')): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo e($errors->first('login_error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Nama Lengkap -->
                    <div class="auth-form-group">
                        <label for="fullname" class="auth-label">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </label>
                        <div class="auth-input-group">
                            <input type="text" class="auth-input <?php $__errorArgs = ['fullname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="fullname"
                                name="fullname" placeholder="Masukkan nama lengkap Anda" required autofocus
                                value="<?php echo e(old('fullname')); ?>">
                        </div>
                        <?php $__errorArgs = ['fullname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="auth-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <span id="fullnameError" class="auth-error"></span>
                    </div>

                    <!-- PIN -->
                    <div class="auth-form-group">
                        <label class="auth-label">
                            <i class="fas fa-key"></i> PIN (4 digit)
                        </label>

                        <div class="pin-container">
                            <input type="text" class="pin-input login-pin <?php $__errorArgs = ['pin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                maxlength="1" data-index="1" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input login-pin <?php $__errorArgs = ['pin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                maxlength="1" data-index="2" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input login-pin <?php $__errorArgs = ['pin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                maxlength="1" data-index="3" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input login-pin <?php $__errorArgs = ['pin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                maxlength="1" data-index="4" autocomplete="off" inputmode="numeric">
                        </div>

                        <input type="hidden" id="pin" name="pin" value="<?php echo e(old('pin')); ?>">
                        <?php $__errorArgs = ['pin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="auth-error"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <span id="pinError" class="auth-error"></span>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i> Masukkan 4 digit PIN
                            </small>
                            <button type="button" id="clearPinBtn" class="btn btn-link text-decoration-none p-0"
                                style="color: var(--blue-700); font-weight: 500;">
                                <i class="fas fa-backspace me-1"></i> Hapus PIN
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn mt-4" id="loginBtn"
                        style="
                    background: var(--gradient-primary);
                    color: var(--white);
                    box-shadow: 0 6px 20px rgba(8, 86, 200, 0.25);
                ">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk ke Sistem</span>
                    </button>

                    <!-- Register Link -->
                    <div class="text-center mt-4">
                        <p class="mb-0" style="color: var(--secondary);">
                            Belum punya akun?
                            <a href="<?php echo e(route('register')); ?>" class="auth-link">
                                <i class="fas fa-user-plus me-1"></i> Daftar di sini
                            </a>
                        </p>
                    </div>
                </form>

                <div class="auth-divider">
                    <span class="auth-divider-text">AKSES ADMIN</span>
                </div>

                <a href="<?php echo e(route('admin.login')); ?>" class="admin-login-btn">
                    <i class="fas fa-user-shield me-2"></i>
                    Login Akses Admin
                </a>

                <!-- Footer -->
                <div class="auth-footer">
                    <p>&copy; <?php echo e(date('Y')); ?> SI Besti. Hak cipta dilindungi.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* LOGIN-SPECIFIC STYLES */
        .login-pin {
            width: 70px;
            height: 70px;
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            background-color: var(--primary-lighter);
            transition: var(--transition);
            color: var(--blue-900);
        }

        .login-pin.is-invalid {
            border-color: var(--danger);
            background-color: rgba(231, 74, 59, 0.15);
        }

        .login-pin:focus {
            border-color: var(--blue-600);
            box-shadow: 0 0 0 4px rgba(38, 116, 230, 0.2);
            background-color: var(--white);
            transform: translateY(-2px);
        }

        .login-pin.filled {
            border-color: var(--blue-700);
            background-color: var(--white);
            box-shadow: 0 4px 15px rgba(8, 86, 200, 0.15);
        }

        .login-pin.shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-8px);
            }

            75% {
                transform: translateX(8px);
            }
        }

        .auth-btn:hover {
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.35) !important;
        }

        /* ADMIN LOGIN STYLES */
        .admin-toggle-container {
            background: linear-gradient(135deg, var(--blue-50) 0%, var(--blue-100) 100%);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            border: 1px solid var(--blue-200);
            box-shadow: 0 4px 12px rgba(8, 86, 200, 0.1);
        }

        .admin-toggle-card {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--blue-300);
        }

        .admin-toggle-header {
            background: linear-gradient(135deg, var(--blue-600) 0%, var(--blue-700) 100%);
            color: var(--white);
            padding: 1rem 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .admin-toggle-body {
            padding: 1.5rem;
        }

        .admin-toggle-description {
            color: var(--secondary);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .admin-login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--blue-700) 0%, var(--blue-800) 100%);
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
            box-shadow: 0 4px 15px rgba(8, 86, 200, 0.2);
        }

        .admin-login-btn:hover {
            background: linear-gradient(135deg, var(--blue-800) 0%, var(--blue-900) 100%);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(8, 86, 200, 0.3);
            text-decoration: none;
        }

        .admin-login-btn:active {
            transform: translateY(0);
        }

        /* Divider Styles */
        .auth-divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .auth-divider-text {
            padding: 0 1rem;
            color: var(--secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Alternative Admin Link Style */
        .admin-link-container {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .admin-link {
            display: inline-flex;
            align-items: center;
            color: var(--blue-700);
            text-decoration: none;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            background: var(--blue-50);
        }

        .admin-link:hover {
            color: var(--blue-900);
            background: var(--blue-100);
            text-decoration: none;
            transform: translateY(-1px);
        }

        .admin-link i {
            margin-right: 0.5rem;
        }

        @media (max-width: 576px) {
            .login-pin {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .admin-toggle-container {
                padding: 1rem;
            }

            .admin-toggle-header {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .admin-toggle-body {
                padding: 1rem;
            }

            .admin-login-btn {
                padding: 0.625rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const pinInputs = document.querySelectorAll('.login-pin');
            const hiddenPinInput = document.getElementById('pin');
            const clearPinBtn = document.getElementById('clearPinBtn');
            const fullnameInput = document.getElementById('fullname');
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const pinError = document.getElementById('pinError');
            const fullnameError = document.getElementById('fullnameError');

            // Pre-fill old values if exists
            const oldPin = hiddenPinInput.value;
            if (oldPin && oldPin.length === 4) {
                for (let i = 0; i < 4; i++) {
                    pinInputs[i].value = oldPin[i];
                    pinInputs[i].classList.add('filled');
                }
            }

            // Initialize - focus on first pin input
            pinInputs[0].focus();

            // PIN Input Handler
            function setupPinInputs() {
                pinInputs.forEach((input, index) => {
                    // Input event
                    input.addEventListener('input', function(e) {
                        const value = e.target.value;

                        // Only allow numbers
                        if (!/^\d*$/.test(value)) {
                            e.target.value = '';
                            return;
                        }

                        // Move to next input if number entered
                        if (value.length === 1 && index < pinInputs.length - 1) {
                            pinInputs[index + 1].focus();
                        }

                        updatePinValue();
                        validatePin();
                    });

                    // Keydown events for navigation
                    input.addEventListener('keydown', function(e) {
                        // Backspace
                        if (e.key === 'Backspace' && this.value === '' && index > 0) {
                            pinInputs[index - 1].focus();
                            pinInputs[index - 1].value = '';
                            updatePinValue();
                        }

                        // Arrow keys
                        if (e.key === 'ArrowLeft' && index > 0) {
                            pinInputs[index - 1].focus();
                        }

                        if (e.key === 'ArrowRight' && index < pinInputs.length - 1) {
                            pinInputs[index + 1].focus();
                        }
                    });

                    // Paste event
                    input.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const pastedData = e.clipboardData.getData('text').trim();

                        if (!/^\d+$/.test(pastedData)) return;

                        // Fill inputs with pasted data
                        for (let i = 0; i < Math.min(pastedData.length, pinInputs.length); i++) {
                            pinInputs[i].value = pastedData[i];
                            pinInputs[i].classList.add('filled');
                        }

                        // Focus appropriate input
                        const nextEmptyIndex = Math.min(pastedData.length, pinInputs.length);
                        if (nextEmptyIndex < pinInputs.length) {
                            pinInputs[nextEmptyIndex].focus();
                        } else {
                            pinInputs[pinInputs.length - 1].focus();
                        }

                        updatePinValue();
                        validatePin();
                    });

                    // Visual feedback
                    input.addEventListener('focus', function() {
                        this.style.borderColor = 'var(--blue-600)';
                        this.style.backgroundColor = 'var(--white)';
                        this.classList.add('filled');
                    });

                    input.addEventListener('blur', function() {
                        if (this.value === '') {
                            this.style.borderColor = 'var(--border-color)';
                            this.style.backgroundColor = 'var(--primary-lighter)';
                            this.classList.remove('filled');
                        }
                    });
                });
            }

            // Update hidden PIN value
            function updatePinValue() {
                let pinValue = '';
                pinInputs.forEach(input => {
                    pinValue += input.value;
                    if (input.value) {
                        input.classList.add('filled');
                    } else {
                        input.classList.remove('filled');
                    }
                });
                hiddenPinInput.value = pinValue;
            }

            // Clear PIN
            clearPinBtn.addEventListener('click', function() {
                pinInputs.forEach(input => {
                    input.value = '';
                    input.classList.remove('filled');
                    input.style.borderColor = '';
                    input.style.backgroundColor = '';
                });
                hiddenPinInput.value = '';
                pinInputs[0].focus();
                pinError.textContent = '';
            });

            // Validate PIN
            function validatePin() {
                const pin = hiddenPinInput.value;

                if (pin.length === 0) {
                    pinError.textContent = '';
                    return false;
                }

                if (pin.length < 4) {
                    pinError.textContent = 'PIN harus 4 digit angka';
                    pinError.className = 'auth-error';
                    return false;
                }

                if (!/^\d{4}$/.test(pin)) {
                    pinError.textContent = 'PIN hanya boleh berisi angka';
                    pinError.className = 'auth-error';
                    return false;
                }

                pinError.textContent = '✓ PIN valid';
                pinError.className = 'auth-success';
                return true;
            }

            // Validate fullname
            function validateFullname() {
                const fullname = fullnameInput.value.trim();

                if (fullname.length === 0) {
                    fullnameError.textContent = 'Nama lengkap harus diisi';
                    fullnameError.className = 'auth-error';
                    return false;
                }

                if (fullname.length < 3) {
                    fullnameError.textContent = 'Nama lengkap minimal 3 karakter';
                    fullnameError.className = 'auth-error';
                    return false;
                }

                fullnameError.textContent = '✓ Nama lengkap valid';
                fullnameError.className = 'auth-success';
                return true;
            }

            // Input validation events
            fullnameInput.addEventListener('input', validateFullname);
            fullnameInput.addEventListener('blur', validateFullname);

            // Form submission
            loginForm.addEventListener('submit', function(e) {
                const isFullnameValid = validateFullname();
                const isPinValid = validatePin();

                if (!isFullnameValid || !isPinValid) {
                    e.preventDefault();

                    if (!isFullnameValid) {
                        fullnameInput.classList.add('shake');
                        setTimeout(() => fullnameInput.classList.remove('shake'), 500);
                        fullnameInput.focus();
                    } else if (!isPinValid) {
                        pinInputs.forEach(input => input.classList.add('shake'));
                        setTimeout(() => pinInputs.forEach(input => input.classList.remove('shake')), 500);
                        pinInputs[0].focus();
                    }
                } else {
                    // Disable button and show loading
                    loginBtn.disabled = true;
                    loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
                }
            });

            // Initialize PIN inputs
            setupPinInputs();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-besti\resources\views/auth/login.blade.php ENDPATH**/ ?>