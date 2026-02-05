@extends('layouts.auth')

@section('title', 'Reset Password Admin - SI Besti')

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-body">
                <!-- Logo -->
                <div class="auth-logo">
                    <i class="fas fa-key"></i>
                </div>

                <!-- Header -->
                <div class="auth-header">
                    <h1 class="auth-title">Reset Password Admin</h1>
                    <p class="auth-subtitle">Buat password baru untuk akun admin Anda</p>
                </div>

                <!-- Form Reset Password -->
                <form id="resetPasswordForm" method="POST" action="{{ route('admin.reset.password') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4"
                            style="
                            background: linear-gradient(135deg, rgba(231, 74, 59, 0.1) 0%, rgba(231, 74, 59, 0.05) 100%);
                            border: 1px solid #E74A3B;
                            border-radius: 12px;
                            padding: 1rem;
                            color: #E74A3B;
                            font-weight: 500;
                        ">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger mb-4"
                            style="
                            background: linear-gradient(135deg, rgba(231, 74, 59, 0.1) 0%, rgba(231, 74, 59, 0.05) 100%);
                            border: 1px solid #E74A3B;
                            border-radius: 12px;
                            padding: 1rem;
                            color: #E74A3B;
                            font-weight: 500;
                        ">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success mb-4"
                            style="
                            background: linear-gradient(135deg, rgba(28, 200, 138, 0.1) 0%, rgba(28, 200, 138, 0.05) 100%);
                            border: 1px solid #1CC88A;
                            border-radius: 12px;
                            padding: 1rem;
                            color: #17A673;
                            font-weight: 500;
                        ">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <!-- Email Info -->
                    <div class="alert alert-info mb-4"
                        style="
                        background: linear-gradient(135deg, rgba(8, 86, 200, 0.1) 0%, rgba(8, 86, 200, 0.05) 100%);
                        border: 1px solid #0856C8;
                        border-radius: 12px;
                        padding: 1rem;
                        color: #0856C8;
                    ">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda sedang mereset password untuk email: <strong>{{ $email }}</strong>
                    </div>

                    <!-- New Password -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-label">
                            <i class="fas fa-lock"></i> Password Baru
                        </label>
                        <div class="auth-input-group">
                            <input type="password" class="auth-input @error('password') is-invalid @enderror" id="password"
                                name="password" placeholder="Masukkan password baru" required minlength="8">
                            <div class="input-icon-right password-toggle" id="passwordToggle">
                                <i class="fas fa-eye" style="color: #0856C8; cursor: pointer;"></i>
                            </div>
                        </div>
                        @error('password')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                        <span id="passwordError" class="auth-error"></span>
                        <small class="text-muted">Password minimal 8 karakter</small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="auth-form-group">
                        <label for="password_confirmation" class="auth-label">
                            <i class="fas fa-lock"></i> Konfirmasi Password Baru
                        </label>
                        <div class="auth-input-group">
                            <input type="password" class="auth-input @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation"
                                placeholder="Konfirmasi password baru" required>
                            <div class="input-icon-right password-toggle" id="confirmPasswordToggle">
                                <i class="fas fa-eye" style="color: #0856C8; cursor: pointer;"></i>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                        <span id="passwordConfirmationError" class="auth-error"></span>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="password-strength mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Kekuatan Password:</small>
                            <small id="passwordStrengthText">Lemah</small>
                        </div>
                        <div class="progress" style="height: 8px; border-radius: 4px;">
                            <div id="passwordStrengthBar" class="progress-bar" role="progressbar"
                                style="width: 0%; border-radius: 4px;" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Gunakan kombinasi huruf besar, kecil, angka, dan simbol
                        </small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn mb-3" id="resetPasswordBtn">
                        <i class="fas fa-save"></i>
                        <span>Reset Password</span>
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center mt-3">
                        <p class="mb-0" style="color: #5A5C69;">
                            <a href="{{ route('admin.login') }}" class="auth-link">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login Admin
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Security Notice -->
                <div class="security-notice mt-4 p-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shield-alt me-3"></i>
                        <div>
                            <p class="mb-0">
                                <strong>Keamanan Password:</strong> Pastikan password baru Anda kuat dan tidak mudah
                                ditebak.
                                Simpan password dengan aman dan jangan bagikan kepada siapapun.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="auth-footer">
                    <p>&copy; {{ date('Y') }} SI Besti - Sistem Administrator</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --blue-800: #1260D2;
            --blue-900: #0856C8;
            --blue-950: #0645A0;
            --success: #1CC88A;
            --danger: #E74A3B;
            --warning: #F6C23E;
        }

        /* RESET PASSWORD SPECIFIC STYLES */
        .auth-logo {
            background: linear-gradient(135deg, var(--blue-800) 0%, var(--blue-950) 100%);
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(8, 86, 200, 0.3);
        }

        .auth-logo i {
            font-size: 2rem;
            color: white;
        }

        .auth-title {
            background: linear-gradient(135deg, var(--blue-800) 0%, var(--blue-950) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: #5A5C69;
            margin-bottom: 2rem;
        }

        .input-icon-right {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .password-toggle {
            pointer-events: auto;
            cursor: pointer;
        }

        .input-icon-right i {
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .auth-input {
            padding-right: 3rem !important;
            border: 2px solid #E3E6F0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
        }

        .auth-input:focus {
            border-color: var(--blue-900);
            box-shadow: 0 0 0 4px rgba(8, 86, 200, 0.1);
        }

        .auth-btn {
            background: linear-gradient(135deg, var(--blue-900), var(--blue-800));
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            width: 100%;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.3);
        }

        .auth-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .security-notice {
            background: linear-gradient(135deg, rgba(8, 86, 200, 0.05) 0%, rgba(8, 86, 200, 0.1) 100%);
            border-radius: 12px;
            border-left: 4px solid var(--blue-900);
        }

        .security-notice i {
            color: var(--blue-900);
            font-size: 1.2rem;
        }

        .security-notice p {
            color: var(--blue-900);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .auth-error {
            color: var(--danger);
            font-size: 0.875rem;
            display: block;
            margin-top: 0.25rem;
        }

        .auth-success {
            color: var(--success);
            font-size: 0.875rem;
            display: block;
            margin-top: 0.25rem;
        }

        /* Password Strength Indicator */
        .password-strength .progress-bar {
            transition: all 0.3s ease;
        }

        .password-strength .progress-bar.weak {
            background-color: var(--danger);
            width: 25%;
        }

        .password-strength .progress-bar.medium {
            background-color: var(--warning);
            width: 50%;
        }

        .password-strength .progress-bar.strong {
            background-color: var(--success);
            width: 75%;
        }

        .password-strength .progress-bar.very-strong {
            background-color: var(--success);
            width: 100%;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.3s ease-in-out;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle SweetAlert notifications from session
            @if (session('swal'))
                Swal.fire({
                    icon: '{{ session('swal.icon') }}',
                    title: '{{ session('swal.title') }}',
                    text: '{{ session('swal.text') }}',
                    timer: 3000,
                    showConfirmButton: true,
                    confirmButtonColor: '#0856C8'
                });
            @endif

            // Auto close Bootstrap alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            const resetPasswordForm = document.getElementById('resetPasswordForm');
            const resetPasswordBtn = document.getElementById('resetPasswordBtn');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const passwordToggle = document.getElementById('passwordToggle');
            const confirmPasswordToggle = document.getElementById('confirmPasswordToggle');
            const passwordStrengthBar = document.getElementById('passwordStrengthBar');
            const passwordStrengthText = document.getElementById('passwordStrengthText');

            // Password visibility toggle
            if (passwordToggle) {
                passwordToggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }

            if (confirmPasswordToggle) {
                confirmPasswordToggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (passwordConfirmInput.type === 'password') {
                        passwordConfirmInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordConfirmInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;

                // Length check
                if (password.length >= 8) strength += 25;
                if (password.length >= 12) strength += 15;

                // Character variety checks
                if (/[a-z]/.test(password)) strength += 15;
                if (/[A-Z]/.test(password)) strength += 15;
                if (/[0-9]/.test(password)) strength += 15;
                if (/[^A-Za-z0-9]/.test(password)) strength += 15;

                // Determine strength level
                let strengthLevel = 'weak';
                let strengthClass = 'weak';

                if (strength >= 60) {
                    strengthLevel = 'medium';
                    strengthClass = 'medium';
                }
                if (strength >= 80) {
                    strengthLevel = 'strong';
                    strengthClass = 'strong';
                }
                if (strength >= 95) {
                    strengthLevel = 'sangat kuat';
                    strengthClass = 'very-strong';
                }

                // Update UI
                passwordStrengthBar.style.width = strength + '%';
                passwordStrengthBar.className = 'progress-bar ' + strengthClass;
                passwordStrengthText.textContent = strengthLevel.charAt(0).toUpperCase() + strengthLevel.slice(1);
            }

            // Listen to password input changes
            passwordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
                validatePassword();
            });

            // Password confirmation validation
            passwordConfirmInput.addEventListener('input', validatePasswordConfirmation);

            // Form validation
            function validatePassword() {
                const password = passwordInput.value;
                const passwordError = document.getElementById('passwordError');

                if (password.length < 8) {
                    passwordError.textContent = 'Password minimal 8 karakter';
                    passwordInput.classList.add('is-invalid');
                    return false;
                } else {
                    passwordError.textContent = '';
                    passwordInput.classList.remove('is-invalid');
                    return true;
                }
            }

            function validatePasswordConfirmation() {
                const password = passwordInput.value;
                const confirmPassword = passwordConfirmInput.value;
                const passwordConfirmationError = document.getElementById('passwordConfirmationError');

                if (password !== confirmPassword && confirmPassword !== '') {
                    passwordConfirmationError.textContent = 'Konfirmasi password tidak sesuai';
                    passwordConfirmInput.classList.add('is-invalid');
                    return false;
                } else {
                    passwordConfirmationError.textContent = '';
                    passwordConfirmInput.classList.remove('is-invalid');
                    return true;
                }
            }

            // Form submission
            resetPasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form
                const isPasswordValid = validatePassword();
                const isPasswordConfirmationValid = validatePasswordConfirmation();

                if (!isPasswordValid || !isPasswordConfirmationValid) {
                    // Show SweetAlert error
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Harap periksa kembali form reset password Anda.',
                        confirmButtonColor: '#0856C8'
                    });
                    return;
                }

                // Check if passwords match
                if (passwordInput.value !== passwordConfirmInput.value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Cocok',
                        text: 'Password dan konfirmasi password harus sama.',
                        confirmButtonColor: '#0856C8'
                    });
                    return;
                }

                // Show loading
                resetPasswordBtn.disabled = true;
                resetPasswordBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i><span>Mereset Password...</span>';

                // Submit form
                this.submit();
            });

            // Auto-focus on password input
            if (passwordInput) {
                passwordInput.focus();
            }
        });
    </script>
@endsection
