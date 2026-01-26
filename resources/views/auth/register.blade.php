@extends('layouts.auth')

@section('title', 'Daftar - SI Besti')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-card-body">
            <!-- Logo -->
            <div class="auth-logo" style="background: linear-gradient(135deg, var(--success-color), var(--success-dark));">
                <i class="fas fa-user-plus"></i>
            </div>
            
            <!-- Header -->
            <div class="auth-header">
                <h1 class="auth-title" style="color: var(--success-dark);">Buat Akun Baru</h1>
                <p class="auth-subtitle">Daftarkan diri Anda untuk mengakses sistem</p>
            </div>
            
            <!-- Form -->
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Nama Lengkap -->
                <div class="auth-form-group">
                    <label for="fullname" class="auth-label">
                        <i class="fas fa-user me-1"></i> Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <div class="auth-input-group">
                        <div class="auth-input-icon">
                            <i class="fas fa-user"></i>
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
                
                <!-- Nomor Telepon -->
                <div class="auth-form-group">
                    <label for="phone" class="auth-label">
                        <i class="fas fa-phone me-1"></i> Nomor Telepon <span class="text-danger">*</span>
                    </label>
                    <div class="auth-input-group">
                        <div class="auth-input-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <input 
                            type="tel" 
                            class="auth-input with-icon" 
                            id="phone" 
                            name="phone" 
                            placeholder="Contoh: 081234567890"
                            required
                        >
                    </div>
                    <span id="phoneError" class="auth-error"></span>
                </div>
                
                <!-- PIN -->
                <div class="auth-form-group">
                    <label for="pin" class="auth-label">
                        <i class="fas fa-key me-1"></i> Buat PIN (4 digit) <span class="text-danger">*</span>
                    </label>
                    
                    <div class="pin-container">
                        <input type="text" class="pin-input register-pin" maxlength="1" data-index="1" autocomplete="off">
                        <input type="text" class="pin-input register-pin" maxlength="1" data-index="2" autocomplete="off">
                        <input type="text" class="pin-input register-pin" maxlength="1" data-index="3" autocomplete="off">
                        <input type="text" class="pin-input register-pin" maxlength="1" data-index="4" autocomplete="off">
                    </div>
                    
                    <input type="hidden" id="pin" name="pin" value="">
                    <span id="pinError" class="auth-error"></span>
                    
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i> Masukkan 4 digit PIN
                        </small>
                        <button type="button" id="clearPinBtn" class="btn btn-link text-decoration-none p-0" style="color: var(--success-color);">
                            <i class="fas fa-backspace me-1"></i> Hapus PIN
                        </button>
                    </div>
                </div>
                
                <!-- Konfirmasi PIN -->
                <div class="auth-form-group">
                    <label for="confirmPin" class="auth-label">
                        <i class="fas fa-key me-1"></i> Konfirmasi PIN <span class="text-danger">*</span>
                    </label>
                    
                    <div class="pin-container">
                        <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="1" autocomplete="off">
                        <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="2" autocomplete="off">
                        <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="3" autocomplete="off">
                        <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="4" autocomplete="off">
                    </div>
                    
                    <input type="hidden" id="confirmPin" name="confirm_pin" value="">
                    <span id="confirmPinError" class="auth-error"></span>
                    
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i> Ulangi PIN yang sama
                        </small>
                        <button type="button" id="clearConfirmPinBtn" class="btn btn-link text-decoration-none p-0" style="color: var(--success-color);">
                            <i class="fas fa-backspace me-1"></i> Hapus
                        </button>
                    </div>
                </div>
                
                <!-- Terms & Conditions -->
                <div class="auth-form-group">
                    <label class="auth-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <span class="auth-checkbox-label">
                            Saya menyetujui 
                            <a href="#" class="auth-link">Syarat & Ketentuan</a> 
                            dan 
                            <a href="#" class="auth-link">Kebijakan Privasi</a>
                        </span>
                    </label>
                    <span id="termsError" class="auth-error"></span>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="auth-btn" style="
                    background: linear-gradient(135deg, var(--success-color), var(--success-dark));
                    color: var(--white);
                    box-shadow: 0 4px 15px rgba(28, 200, 138, 0.3);
                ">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Sekarang</span>
                </button>
                
                <!-- Login Link -->
                <div class="text-center mt-4">
                    <p class="mb-0">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="auth-link">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
            
            <!-- Footer -->
            <div class="auth-footer">
                <p>&copy; {{ date('Y') }} SI Besti. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* REGISTER-SPECIFIC STYLES */
    .register-pin,
    .confirm-pin {
        width: 60px;
        height: 60px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 600;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        background-color: var(--success-light);
        transition: var(--transition);
        color: var(--success-dark);
    }
    
    .register-pin:focus,
    .confirm-pin:focus {
        border-color: var(--success-color);
        box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.25);
        background-color: var(--white);
        transform: translateY(-2px);
    }
    
    .register-pin.filled {
        border-color: var(--success-color);
        background-color: var(--white);
        box-shadow: var(--shadow-sm);
    }
    
    .confirm-pin.filled {
        background-color: var(--white);
    }
    
    .confirm-pin.matched {
        border-color: var(--success-color);
        background-color: rgba(28, 200, 138, 0.1);
        color: var(--success-dark);
    }
    
    .confirm-pin.not-matched {
        border-color: var(--danger-color);
        background-color: rgba(231, 74, 59, 0.1);
        color: var(--danger-color);
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .auth-btn:hover {
        box-shadow: 0 6px 20px rgba(28, 200, 138, 0.4);
    }
    
    .password-strength {
        height: 4px;
        background-color: var(--border-color);
        border-radius: 2px;
        margin-top: 0.5rem;
        overflow: hidden;
    }
    
    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 2px;
    }
    
    .strength-weak { width: 33%; background-color: var(--danger-color); }
    .strength-medium { width: 66%; background-color: var(--warning-color); }
    .strength-strong { width: 100%; background-color: var(--success-color); }
    
    @media (max-width: 576px) {
        .register-pin,
        .confirm-pin {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const registerPinInputs = document.querySelectorAll('.register-pin');
        const confirmPinInputs = document.querySelectorAll('.confirm-pin');
        const hiddenPinInput = document.getElementById('pin');
        const hiddenConfirmPinInput = document.getElementById('confirmPin');
        const clearPinBtn = document.getElementById('clearPinBtn');
        const clearConfirmPinBtn = document.getElementById('clearConfirmPinBtn');
        const fullnameInput = document.getElementById('fullname');
        const phoneInput = document.getElementById('phone');
        const termsCheckbox = document.getElementById('terms');
        const registerForm = document.getElementById('registerForm');
        const fullnameError = document.getElementById('fullnameError');
        const phoneError = document.getElementById('phoneError');
        const pinError = document.getElementById('pinError');
        const confirmPinError = document.getElementById('confirmPinError');
        const termsError = document.getElementById('termsError');
        
        // Initialize - focus on first pin input
        registerPinInputs[0].focus();
        
        // PIN Input Handler
        function setupPinInputs(inputs, hiddenInput, isConfirm = false) {
            inputs.forEach((input, index) => {
                // Input event
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Move to next input if number entered
                    if (value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    
                    updatePinValue(inputs, hiddenInput);
                    
                    if (isConfirm) {
                        validateConfirmPin();
                    } else {
                        validatePin();
                        validateConfirmPin(); // Re-validate confirm pin
                    }
                });
                
                // Keydown events for navigation
                input.addEventListener('keydown', function(e) {
                    // Backspace
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                    
                    // Arrow keys
                    if (e.key === 'ArrowLeft' && index > 0) {
                        inputs[index - 1].focus();
                    }
                    
                    if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                
                // Visual feedback
                input.addEventListener('focus', function() {
                    this.style.borderColor = 'var(--success-color)';
                    this.style.backgroundColor = 'var(--white)';
                    this.classList.add('filled');
                });
                
                input.addEventListener('blur', function() {
                    if (this.value === '') {
                        this.style.borderColor = 'var(--border-color)';
                        this.style.backgroundColor = 'var(--success-light)';
                        this.classList.remove('filled', 'matched', 'not-matched');
                    }
                });
            });
        }
        
        // Update hidden PIN value
        function updatePinValue(inputs, hiddenInput) {
            let pinValue = '';
            inputs.forEach(input => {
                pinValue += input.value;
                
                if (input.value) {
                    input.classList.add('filled');
                    
                    // Update confirm pin styling
                    if (inputs[0].classList.contains('confirm-pin')) {
                        const originalPin = hiddenPinInput.value;
                        const confirmPin = getPinValue(confirmPinInputs);
                        
                        if (confirmPin.length === 4 && originalPin.length === 4) {
                            if (confirmPin === originalPin) {
                                input.classList.add('matched');
                                input.classList.remove('not-matched');
                            } else {
                                input.classList.add('not-matched');
                                input.classList.remove('matched');
                            }
                        }
                    }
                } else {
                    input.classList.remove('filled', 'matched', 'not-matched');
                }
            });
            hiddenInput.value = pinValue;
        }
        
        // Get PIN value from inputs
        function getPinValue(inputs) {
            let value = '';
            inputs.forEach(input => {
                value += input.value;
            });
            return value;
        }
        
        // Clear PIN buttons
        clearPinBtn.addEventListener('click', function() {
            registerPinInputs.forEach(input => {
                input.value = '';
                input.classList.remove('filled');
                input.style.borderColor = '';
                input.style.backgroundColor = '';
            });
            hiddenPinInput.value = '';
            registerPinInputs[0].focus();
            pinError.textContent = '';
            validateConfirmPin();
        });
        
        clearConfirmPinBtn.addEventListener('click', function() {
            confirmPinInputs.forEach(input => {
                input.value = '';
                input.classList.remove('filled', 'matched', 'not-matched');
                input.style.borderColor = '';
                input.style.backgroundColor = '';
            });
            hiddenConfirmPinInput.value = '';
            confirmPinInputs[0].focus();
            confirmPinError.textContent = '';
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
            
            pinError.textContent = '✓ PIN aman dan valid';
            pinError.className = 'auth-success';
            return true;
        }
        
        // Validate confirm PIN
        function validateConfirmPin() {
            const pin = hiddenPinInput.value;
            const confirmPin = hiddenConfirmPinInput.value;
            
            if (confirmPin.length === 0) {
                confirmPinError.textContent = '';
                return false;
            }
            
            if (confirmPin.length < 4) {
                confirmPinError.textContent = 'Konfirmasi PIN harus 4 digit';
                confirmPinError.className = 'auth-error';
                return false;
            }
            
            if (pin !== confirmPin) {
                confirmPinError.textContent = 'Konfirmasi PIN tidak cocok';
                confirmPinError.className = 'auth-error';
                return false;
            }
            
            confirmPinError.textContent = '✓ PIN cocok';
            confirmPinError.className = 'auth-success';
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
                fullnameError.textContent = 'Nama minimal 3 karakter';
                fullnameError.className = 'auth-error';
                return false;
            }
            
            if (fullname.length > 50) {
                fullnameError.textContent = 'Nama maksimal 50 karakter';
                fullnameError.className = 'auth-error';
                return false;
            }
            
            fullnameError.textContent = '✓ Nama lengkap valid';
            fullnameError.className = 'auth-success';
            return true;
        }
        
        // Validate phone
        function validatePhone() {
            const phone = phoneInput.value.trim().replace(/\D/g, '');
            
            if (phone.length === 0) {
                phoneError.textContent = 'Nomor telepon harus diisi';
                phoneError.className = 'auth-error';
                return false;
            }
            
            if (phone.length < 10 || phone.length > 13) {
                phoneError.textContent = 'Nomor telepon 10-13 digit';
                phoneError.className = 'auth-error';
                return false;
            }
            
            if (!/^08[1-9][0-9]{7,}$/.test(phone)) {
                phoneError.textContent = 'Format nomor tidak valid';
                phoneError.className = 'auth-error';
                return false;
            }
            
            // Format for display
            const formattedPhone = phone.replace(/(\d{4})(\d{4})(\d+)/, '$1-$2-$3');
            if (phoneInput.value !== formattedPhone) {
                phoneInput.value = formattedPhone;
            }
            
            phoneError.textContent = '✓ Nomor telepon valid';
            phoneError.className = 'auth-success';
            return true;
        }
        
        // Validate terms
        function validateTerms() {
            if (!termsCheckbox.checked) {
                termsError.textContent = 'Anda harus menyetujui Syarat & Ketentuan';
                return false;
            }
            
            termsError.textContent = '';
            return true;
        }
        
        // Input validation events
        fullnameInput.addEventListener('input', validateFullname);
        phoneInput.addEventListener('input', validatePhone);
        termsCheckbox.addEventListener('change', validateTerms);
        
        // Initialize PIN inputs
        setupPinInputs(registerPinInputs, hiddenPinInput, false);
        setupPinInputs(confirmPinInputs, hiddenConfirmPinInput, true);
        
        // Form submission
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const isFullnameValid = validateFullname();
            const isPhoneValid = validatePhone();
            const isPinValid = validatePin();
            const isConfirmPinValid = validateConfirmPin();
            const isTermsValid = validateTerms();
            
            if (isFullnameValid && isPhoneValid && isPinValid && isConfirmPinValid && isTermsValid) {
                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHTML = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Membuat akun...</span>';
                submitBtn.disabled = true;
                
                // Simulate registration
                setTimeout(() => {
                    // Reset button
                    submitBtn.innerHTML = originalHTML;
                    submitBtn.disabled = false;
                    
                    // Success message
                    alert('Pendaftaran berhasil!\n\nNama: ' + fullnameInput.value + 
                          '\nTelepon: ' + phoneInput.value + 
                          '\n\nSilakan login dengan PIN Anda.');
                    
                    // Reset form
                    this.reset();
                    registerPinInputs.forEach(input => {
                        input.value = '';
                        input.classList.remove('filled');
                    });
                    confirmPinInputs.forEach(input => {
                        input.value = '';
                        input.classList.remove('filled', 'matched', 'not-matched');
                    });
                    hiddenPinInput.value = '';
                    hiddenConfirmPinInput.value = '';
                    
                    // Redirect to login
                    window.location.href = "{{ route('login') }}";
                }, 1500);
            } else {
                // Focus on first invalid field
                if (!isFullnameValid) fullnameInput.focus();
                else if (!isPhoneValid) phoneInput.focus();
                else if (!isPinValid) registerPinInputs[0].focus();
                else if (!isConfirmPinValid) confirmPinInputs[0].focus();
                else if (!isTermsValid) termsCheckbox.focus();
            }
        });
        
        // Demo shortcut (Ctrl+D)
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'd') {
                e.preventDefault();
                fullnameInput.value = 'Budi Santoso';
                validateFullname();
                
                phoneInput.value = '0812-3456-7890';
                validatePhone();
                
                ['1', '3', '5', '7'].forEach((value, index) => {
                    registerPinInputs[index].value = value;
                    registerPinInputs[index].classList.add('filled');
                    registerPinInputs[index].dispatchEvent(new Event('input'));
                    
                    confirmPinInputs[index].value = value;
                    confirmPinInputs[index].classList.add('filled', 'matched');
                    confirmPinInputs[index].dispatchEvent(new Event('input'));
                });
                
                termsCheckbox.checked = true;
                validateTerms();
                
                confirmPinInputs[3].focus();
                console.log('Demo data: Nama: Budi Santoso, Telepon: 081234567890, PIN: 1357');
            }
        });
    });
</script>
@endsection