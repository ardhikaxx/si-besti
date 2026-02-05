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

                <!-- Form Login -->
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

                    <!-- Remember Me & Lupa Password -->
                    <div class="d-flex justify-content-end align-items-center mb-4">
                        <a href="javascript:void(0);" id="forgotPasswordLink" class="auth-link"
                            style="color: #0856C8; text-decoration: none;">
                            <i class="fas fa-key me-1"></i> Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn mb-3" id="adminLoginBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk sebagai Admin</span>
                    </button>

                    <!-- Back to User Login -->
                    <div class="text-center mt-3">
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

    <!-- Modal Lupa Password -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header"
                    style="
                    background: linear-gradient(135deg, #0856C8 0%, #0645A0 100%);
                    border-top-left-radius: 16px;
                    border-top-right-radius: 16px;
                    padding: 1.5rem 2rem;
                    border: none;
                ">
                    <h5 class="modal-title text-white" id="forgotPasswordModalLabel">
                        <i class="fas fa-key me-2"></i>Reset Password Anda
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="forgot-icon mb-3">
                            <i class="fas fa-lock"></i>
                        </div>
                        <p class="mb-0" style="color: #5A5C69;">
                            Masukkan email admin Anda. Sistem akan memverifikasi apakah email terdaftar.
                        </p>
                    </div>

                    <form id="forgotPasswordForm">
                        @csrf
                        <div class="auth-form-group">
                            <label for="forgotEmail" class="auth-label">
                                <i class="fas fa-envelope"></i> Email Administrator
                            </label>
                            <div class="auth-input-group">
                                <input type="email" class="auth-input" id="forgotEmail" name="email"
                                    placeholder="admin@domain.com" required>
                                <div class="input-icon-right">
                                    <i class="fas fa-at" style="color: #0856C8;"></i>
                                </div>
                            </div>
                            <span id="forgotEmailError" class="auth-error"></span>
                        </div>

                        <!-- Loading State -->
                        <div id="forgotLoading" class="text-center" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 mb-0" style="color: #0856C8;">Memverifikasi email...</p>
                        </div>

                        <!-- Success Message -->
                        <div id="forgotSuccess" class="alert alert-success mt-3" style="display: none;">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="successMessage"></span>
                        </div>

                        <!-- Error Message -->
                        <div id="forgotError" class="alert alert-danger mt-3" style="display: none;">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <span id="errorMessage"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #E3E6F0; padding: 1rem 2rem;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="button" id="submitForgotPassword" class="btn btn-primary">
                        <i class="fas fa-check me-1"></i> Verifikasi Email
                    </button>
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

        /* Forgot Password Modal Styles */
        .forgot-icon {
            background: linear-gradient(135deg, rgba(8, 86, 200, 0.1) 0%, rgba(8, 86, 200, 0.2) 100%);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .forgot-icon i {
            font-size: 1.5rem;
            color: #0856C8;
        }

        .modal-content {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-footer .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .modal-footer .btn-primary {
            background: linear-gradient(135deg, #0856C8, #0645A0);
            border: none;
        }

        .modal-footer .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(8, 86, 200, 0.3);
        }

        .modal-footer .btn-outline-secondary {
            border: 2px solid #E3E6F0;
            color: #5A5C69;
        }

        .modal-footer .btn-outline-secondary:hover {
            background-color: #F8F9FC;
        }

        /* Form Check Custom */
        .form-check-input:checked {
            background-color: #0856C8;
            border-color: #0856C8;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(8, 86, 200, 0.25);
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

        /* Loading Spinner */
        .spinner-border {
            width: 2rem;
            height: 2rem;
            border-width: 0.2em;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
            document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
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
            const forgotPasswordLink = document.getElementById('forgotPasswordLink');
            const forgotPasswordModal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
            const submitForgotBtn = document.getElementById('submitForgotPassword');
            const forgotEmailInput = document.getElementById('forgotEmail');
            const forgotLoading = document.getElementById('forgotLoading');
            const forgotSuccess = document.getElementById('forgotSuccess');
            const forgotError = document.getElementById('forgotError');
            const forgotEmailError = document.getElementById('forgotEmailError');

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

            // Forgot Password Link Click
            if (forgotPasswordLink) {
                forgotPasswordLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Reset modal state
                    resetForgotModal();
                    forgotPasswordModal.show();
                    // Auto-focus on email input in modal
                    setTimeout(() => {
                        if (forgotEmailInput) {
                            forgotEmailInput.focus();
                            // Pre-fill with login email if available
                            if (emailInput.value) {
                                forgotEmailInput.value = emailInput.value;
                            }
                        }
                    }, 500);
                });
            }

            // Reset Forgot Modal Function
            function resetForgotModal() {
                if (forgotEmailInput) forgotEmailInput.value = '';
                forgotEmailError.textContent = '';
                forgotEmailInput.classList.remove('is-invalid');
                forgotLoading.style.display = 'none';
                forgotSuccess.style.display = 'none';
                forgotError.style.display = 'none';
                submitForgotBtn.disabled = false;
                submitForgotBtn.innerHTML = '<i class="fas fa-check me-1"></i> Verifikasi Email';
            }

            // Submit Forgot Password dengan async/await
            if (submitForgotBtn) {
                submitForgotBtn.addEventListener('click', async function() {
                    const email = forgotEmailInput.value.trim();

                    console.log('=== START FORGOT PASSWORD PROCESS ===');
                    console.log('Email input:', email);

                    // Reset previous errors
                    forgotEmailError.textContent = '';
                    forgotEmailInput.classList.remove('is-invalid');
                    forgotError.style.display = 'none';
                    forgotSuccess.style.display = 'none';

                    // Basic validation
                    if (!email) {
                        forgotEmailError.textContent = 'Email harus diisi';
                        forgotEmailInput.classList.add('is-invalid');
                        forgotEmailInput.focus();
                        return;
                    }

                    // Email format validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        forgotEmailError.textContent = 'Format email tidak valid';
                        forgotEmailInput.classList.add('is-invalid');
                        forgotEmailInput.focus();
                        return;
                    }

                    // Show loading state
                    submitForgotBtn.disabled = true;
                    submitForgotBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin me-1"></i> Memverifikasi...';
                    forgotLoading.style.display = 'block';

                    try {
                        console.log('Sending request to:', '{{ route('admin.forgot.password') }}');

                        // Prepare form data
                        const formData = new FormData();
                        formData.append('email', email);
                        formData.append('_token', '{{ csrf_token() }}');

                        console.log('Form data prepared');

                        // Send AJAX request
                        const response = await fetch('{{ route('admin.forgot.password') }}', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        console.log('Response received:', response.status, response.statusText);

                        // Parse JSON response
                        const data = await response.json();
                        console.log('Response data:', data);

                        // Hide loading
                        forgotLoading.style.display = 'none';

                        if (data.success) {
                            console.log('Success! Redirecting to:', data.redirect_url);

                            // Langsung redirect tanpa delay
                            if (data.redirect_url) {
                                console.log('Redirecting now...');
                                window.location.href = data.redirect_url;
                            }
                        } else {
                            console.log('Error response:', data);

                            // Reset button state
                            submitForgotBtn.disabled = false;
                            submitForgotBtn.innerHTML =
                                '<i class="fas fa-check me-1"></i> Verifikasi Email';

                            // Show error message
                            if (data.errors && data.errors.email) {
                                forgotEmailError.textContent = data.errors.email[0];
                                forgotEmailInput.classList.add('is-invalid');
                                forgotEmailInput.focus();

                                // Show SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Email Tidak Ditemukan',
                                    text: data.errors.email[0],
                                    confirmButtonColor: '#0856C8'
                                });
                            } else {
                                const errorMessageEl = document.getElementById('errorMessage');
                                if (errorMessageEl) {
                                    errorMessageEl.textContent = data.message ||
                                        'Terjadi kesalahan. Silakan coba lagi.';
                                    forgotError.style.display = 'block';
                                }

                                // Show SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Verifikasi Gagal',
                                    text: data.message ||
                                        'Terjadi kesalahan. Silakan coba lagi.',
                                    confirmButtonColor: '#0856C8'
                                });
                            }
                        }
                    } catch (error) {
                        console.error('=== FETCH ERROR ===');
                        console.error('Error details:', error);

                        forgotLoading.style.display = 'none';
                        submitForgotBtn.disabled = false;
                        submitForgotBtn.innerHTML =
                        '<i class="fas fa-check me-1"></i> Verifikasi Email';

                        const errorMessageEl = document.getElementById('errorMessage');
                        if (errorMessageEl) {
                            errorMessageEl.textContent =
                                'Terjadi kesalahan jaringan. Silakan coba lagi.';
                            forgotError.style.display = 'block';
                        }

                        // Show SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Koneksi Gagal',
                            text: 'Terjadi kesalahan jaringan. Silakan coba lagi. Error: ' +
                                error.message,
                            confirmButtonColor: '#0856C8'
                        });
                    }

                    console.log('=== END FORGOT PASSWORD PROCESS ===');
                });
            }

            // Clear error when typing in forgot email
            if (forgotEmailInput) {
                forgotEmailInput.addEventListener('input', function() {
                    forgotEmailError.textContent = '';
                    forgotEmailInput.classList.remove('is-invalid');
                    forgotError.style.display = 'none';
                    forgotSuccess.style.display = 'none';
                });
            }

            // Reset modal when closed
            document.getElementById('forgotPasswordModal').addEventListener('hidden.bs.modal', function() {
                resetForgotModal();
            });

            // Press Enter in forgot email input to submit
            if (forgotEmailInput) {
                forgotEmailInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        submitForgotBtn.click();
                    }
                });
            }
        });
    </script>
@endsection
