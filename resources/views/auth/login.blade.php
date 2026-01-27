@extends('layouts.auth')

@section('title', 'Login - SI Besti')

@section('content')
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
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Error Messages -->
                    @if($errors->has('login_error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first('login_error') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <!-- Nama Lengkap -->
                    <div class="auth-form-group">
                        <label for="fullname" class="auth-label">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </label>
                        <div class="auth-input-group">
                            <input type="text" class="auth-input @error('fullname') is-invalid @enderror" 
                                   id="fullname" name="fullname"
                                   placeholder="Masukkan nama lengkap Anda" 
                                   required autofocus
                                   value="{{ old('fullname') }}">
                        </div>
                        @error('fullname')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                        <span id="fullnameError" class="auth-error"></span>
                    </div>

                    <!-- PIN -->
                    <div class="auth-form-group">
                        <label class="auth-label">
                            <i class="fas fa-key"></i> PIN (4 digit)
                        </label>

                        <div class="pin-container">
                            <input type="text" class="pin-input login-pin @error('pin') is-invalid @enderror" 
                                   maxlength="1" data-index="1" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input login-pin @error('pin') is-invalid @enderror" 
                                   maxlength="1" data-index="2" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input login-pin @error('pin') is-invalid @enderror" 
                                   maxlength="1" data-index="3" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input login-pin @error('pin') is-invalid @enderror" 
                                   maxlength="1" data-index="4" autocomplete="off" inputmode="numeric">
                        </div>

                        <input type="hidden" id="pin" name="pin" value="{{ old('pin') }}">
                        @error('pin')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
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
                            <a href="{{ route('register') }}" class="auth-link">
                                <i class="fas fa-user-plus me-1"></i> Daftar di sini
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Footer -->
                <div class="auth-footer">
                    <p>&copy; {{ date('Y') }} SI Besti. Hak cipta dilindungi.</p>
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
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        .auth-btn:hover {
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.35) !important;
        }

        @media (max-width: 576px) {
            .login-pin {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
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
@endsection