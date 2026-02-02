@extends('layouts.auth')

@section('title', 'Login Admin - SI Besti')

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-body">
                <!-- Logo -->
                <div class="auth-logo">
                    <i class="fas fa-user-shield"></i>
                </div>

                <!-- Header -->
                <div class="auth-header">
                    <h1 class="auth-title">Akses Administrator</h1>
                    <p class="auth-subtitle">Masuk ke sistem sebagai administrator</p>
                </div>

                <!-- Form -->
                <form id="adminLoginForm" method="POST" action="{{ route('admin.login.post') }}">
                    @csrf

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

                    <!-- Email -->
                    <div class="auth-form-group">
                        <label for="email" class="auth-label">
                            <i class="fas fa-envelope"></i> Email Administrator
                        </label>
                        <div class="auth-input-group">
                            <input type="email" class="auth-input @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="admin@domain.com" required autofocus
                                value="{{ old('email') }}">
                            <div class="input-icon-right">
                                <i class="fas fa-at" style="color: #0856C8;"></i>
                            </div>
                        </div>
                        @error('email')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                        <span id="emailError" class="auth-error"></span>
                    </div>

                    <!-- Password -->
                    <div class="auth-form-group">
                        <label for="password" class="auth-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div class="auth-input-group">
                            <input type="password" class="auth-input @error('password') is-invalid @enderror" id="password"
                                name="password" placeholder="Masukkan password Anda" required>
                            <div class="input-icon-right password-toggle" id="passwordToggle">
                                <i class="fas fa-eye" style="color: #0856C8; cursor: pointer;"></i>
                            </div>
                        </div>
                        @error('password')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                        <span id="passwordError" class="auth-error"></span>
                    </div>

                    <!-- Remember Me -->
                    <div class="auth-form-group mb-3">
                        <label class="auth-checkbox">
                            <input type="checkbox" name="remember" id="remember" value="1"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="auth-checkbox-label">
                                Ingat saya pada perangkat ini
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn mb-4" id="adminLoginBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk sebagai Admin</span>
                    </button>

                    <!-- Back to User Login -->
                    <div class="text-center mt-4">
                        <p class="mb-0" style="color: #5A5C69;">
                            <a href="{{ route('login') }}" class="auth-link">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login Pengguna
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
                                <strong>Keamanan Administrator:</strong> Pastikan Anda keluar dari sistem setelah selesai
                                menggunakan akun admin.
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
        }

        /* ADMIN LOGIN SPECIFIC STYLES */
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

            // Login form validation with SweetAlert
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!email || !password) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Form Tidak Lengkap',
                        text: 'Harap isi email dan password terlebih dahulu.',
                        confirmButtonColor: '#0856C8'
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const adminLoginForm = document.getElementById('adminLoginForm');
            const adminLoginBtn = document.getElementById('adminLoginBtn');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');

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

            // Form submission
            adminLoginForm.addEventListener('submit', function(e) {
                // Disable button to prevent double submission
                adminLoginBtn.disabled = true;
                adminLoginBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i><span>Memverifikasi Akses...</span>';
            });

            // Auto-focus on email input
            if (emailInput) {
                emailInput.focus();
            }
        });
    </script>
@endsection
