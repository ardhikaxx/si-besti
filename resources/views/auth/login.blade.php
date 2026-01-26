@extends('layouts.auth')

@section('title', 'Login - SI Besti')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-card-body">
            <!-- Logo -->
            <div class="auth-logo" style="background: var(--blue-gradient);">
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
                
                <!-- Nama Lengkap -->
                <div class="auth-form-group">
                    <label for="fullname" class="auth-label">
                        <i class="fas fa-user me-1"></i> Nama Lengkap
                    </label>
                    <div class="auth-input-group">
                        <div class="auth-input-icon">
                            <i class="fas fa-user" style="color: var(--primary-blue);"></i>
                        </div>
                        <input 
                            type="text" 
                            class="auth-input with-icon" 
                            id="fullname" 
                            name="fullname" 
                            placeholder="Masukkan nama lengkap Anda"
                            required
                            autofocus
                        >
                    </div>
                    <span id="fullnameError" class="auth-error"></span>
                </div>
                
                <!-- PIN -->
                <div class="auth-form-group">
                    <label for="pin" class="auth-label">
                        <i class="fas fa-key me-1" style="color: var(--primary-blue);"></i> PIN (4 digit)
                    </label>
                    
                    <div class="pin-container">
                        <input type="text" class="pin-input login-pin" maxlength="1" data-index="1" autocomplete="off">
                        <input type="text" class="pin-input login-pin" maxlength="1" data-index="2" autocomplete="off">
                        <input type="text" class="pin-input login-pin" maxlength="1" data-index="3" autocomplete="off">
                        <input type="text" class="pin-input login-pin" maxlength="1" data-index="4" autocomplete="off">
                    </div>
                    
                    <input type="hidden" id="pin" name="pin" value="">
                    <span id="pinError" class="auth-error"></span>
                    
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i> Masukkan 4 digit PIN
                        </small>
                        <button type="button" id="clearPinBtn" class="btn btn-link text-decoration-none p-0" style="color: var(--primary-blue);">
                            <i class="fas fa-backspace me-1"></i> Hapus PIN
                        </button>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="auth-btn" style="
                    background: var(--blue-gradient);
                    color: var(--white);
                    box-shadow: 0 4px 15px rgba(8, 86, 200, 0.3);
                ">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk ke Sistem</span>
                </button>
                
                <!-- Register Link -->
                <div class="text-center mt-4">
                    <p class="mb-0">
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
        width: 60px;
        height: 60px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 600;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        background-color: var(--primary-blue-lighter);
        transition: var(--transition);
        color: var(--primary-blue);
    }
    
    .login-pin:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(8, 86, 200, 0.25);
        background-color: var(--white);
        transform: translateY(-2px);
    }
    
    .login-pin.filled {
        border-color: var(--primary-blue);
        background-color: var(--white);
        box-shadow: 0 2px 8px rgba(8, 86, 200, 0.2);
    }
    
    .login-pin.shake {
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .auth-btn:hover {
        box-shadow: 0 6px 20px rgba(8, 86, 200, 0.4);
    }
    
    /* Card decoration */
    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--blue-gradient);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }
    
    @media (max-width: 576px) {
        .login-pin {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
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
        const pinError = document.getElementById('pinError');
        const fullnameError = document.getElementById('fullnameError');
        
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
                    this.style.borderColor = 'var(--primary-blue)';
                    this.style.backgroundColor = 'var(--white)';
                    this.classList.add('filled');
                });
                
                input.addEventListener('blur', function() {
                    if (this.value === '') {
                        this.style.borderColor = 'var(--border-color)';
                        this.style.backgroundColor = 'var(--primary-blue-lighter)';
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
            e.preventDefault();
            
            const isFullnameValid = validateFullname();
            const isPinValid = validatePin();
            
            if (isFullnameValid && isPinValid) {
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHTML = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
                submitBtn.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    // Reset button
                    submitBtn.innerHTML = originalHTML;
                    submitBtn.disabled = false;
                    
                    // Demo success
                    alert('Login berhasil! Selamat datang, ' + fullnameInput.value);
                    
                    // In real app: this.submit();
                }, 1000);
            } else {
                // Shake animation for invalid fields
                if (!isFullnameValid) {
                    fullnameInput.classList.add('shake');
                    setTimeout(() => fullnameInput.classList.remove('shake'), 500);
                    fullnameInput.focus();
                } else if (!isPinValid) {
                    pinInputs.forEach(input => input.classList.add('shake'));
                    setTimeout(() => pinInputs.forEach(input => input.classList.remove('shake')), 500);
                    pinInputs[0].focus();
                }
            }
        });
        
        // Initialize PIN inputs
        setupPinInputs();
        
        // Demo shortcut (Ctrl+D)
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'd') {
                e.preventDefault();
                fullnameInput.value = 'Administrator';
                validateFullname();
                
                ['1', '2', '3', '4'].forEach((value, index) => {
                    pinInputs[index].value = value;
                    pinInputs[index].classList.add('filled');
                    pinInputs[index].dispatchEvent(new Event('input'));
                });
                
                pinInputs[3].focus();
                console.log('Demo data: Nama: Administrator, PIN: 1234');
            }
        });
    });
</script>
@endsection