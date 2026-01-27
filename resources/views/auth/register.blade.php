@extends('layouts.auth')

@section('title', 'Daftar - SI Besti')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-card-body">
            <!-- Logo -->
            <div class="auth-logo">
                <i class="fas fa-user-plus"></i>
            </div>
            
            <!-- Header -->
            <div class="auth-header">
                <h1 class="auth-title">Buat Akun Baru</h1>
                <p class="auth-subtitle">Daftarkan diri Anda untuk mengakses sistem</p>
            </div>
            
            <!-- Form -->
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Nama Lengkap -->
                <div class="auth-form-group">
                    <label for="fullname" class="auth-label">
                        <i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <div class="auth-input-group">
                        <input 
                            type="text" 
                            class="auth-input" 
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
                        <i class="fas fa-phone"></i> Nomor Telepon <span class="text-danger">*</span>
                    </label>
                    <div class="auth-input-group">
                        <input 
                            type="tel" 
                            class="auth-input" 
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
                    <label class="auth-label">
                        <i class="fas fa-key"></i> Buat PIN (4 digit) <span class="text-danger">*</span>
                    </label>
                    
                    <div class="pin-container">
                        <input type="text" class="pin-input register-pin" maxlength="1" data-index="1" autocomplete="off" inputmode="numeric">
                        <input type="text" class="pin-input register-pin" maxlength="1" data-index="2" autocomplete="off" inputmode="numeric">
                        <input type="text" class="pin-input register-pin" maxlength="1" data-index="3" autocomplete="off" inputmode="numeric">
                        <input type="text" class="pin-input register-pin" maxlength="1" data-index="4" autocomplete="off" inputmode="numeric">
                    </div>
                    
                    <input type="hidden" id="pin" name="pin" value="">
                    <span id="pinError" class="auth-error"></span>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i> Masukkan 4 digit PIN
                        </small>
                        <button type="button" id="clearPinBtn" class="btn btn-link text-decoration-none p-0" style="color: var(--blue-700); font-weight: 500;">
                            <i class="fas fa-backspace me-1"></i> Hapus PIN
                        </button>
                    </div>
                </div>
                
                <!-- Konfirmasi PIN -->
                <div class="auth-form-group">
                    <label class="auth-label">
                        <i class="fas fa-key"></i> Konfirmasi PIN <span class="text-danger">*</span>
                    </label>
                    
                    <div class="pin-container">
                        <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="1" autocomplete="off" inputmode="numeric">
                        <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="2" autocomplete="off" inputmode="numeric">
                        <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="3" autocomplete="off" inputmode="numeric">
                        <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="4" autocomplete="off" inputmode="numeric">
                    </div>
                    
                    <input type="hidden" id="confirmPin" name="confirm_pin" value="">
                    <span id="confirmPinError" class="auth-error"></span>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i> Ulangi PIN yang sama
                        </small>
                        <button type="button" id="clearConfirmPinBtn" class="btn btn-link text-decoration-none p-0" style="color: var(--blue-700); font-weight: 500;">
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
                <button type="submit" class="auth-btn mt-2" style="
                    background: var(--gradient-light);
                    color: var(--white);
                    box-shadow: 0 6px 20px rgba(38, 116, 230, 0.25);
                ">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Sekarang</span>
                </button>
                
                <!-- Login Link -->
                <div class="text-center mt-4">
                    <p class="mb-0" style="color: var(--secondary);">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="auth-link">
                            <i class="fas fa-sign-in-alt me-1"></i> Masuk di sini
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
    /* REGISTER-SPECIFIC STYLES */
    .register-pin,
    .confirm-pin {
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
    
    .register-pin:focus,
    .confirm-pin:focus {
        border-color: var(--blue-600);
        box-shadow: 0 0 0 4px rgba(38, 116, 230, 0.2);
        background-color: var(--white);
        transform: translateY(-2px);
    }
    
    .register-pin.filled {
        border-color: var(--blue-700);
        background-color: var(--white);
        box-shadow: 0 4px 15px rgba(8, 86, 200, 0.15);
    }
    
    .confirm-pin.filled {
        background-color: var(--white);
    }
    
    .confirm-pin.matched {
        border-color: var(--success);
        background-color: rgba(28, 200, 138, 0.15);
        color: var(--success);
        box-shadow: 0 4px 15px rgba(28, 200, 138, 0.15);
    }
    
    .confirm-pin.not-matched {
        border-color: var(--danger);
        background-color: rgba(231, 74, 59, 0.15);
        color: var(--danger);
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-8px); }
        75% { transform: translateX(8px); }
    }
    
    .auth-btn:hover {
        box-shadow: 0 10px 25px rgba(38, 116, 230, 0.35) !important;
    }
    
    @media (max-width: 576px) {
        .register-pin,
        .confirm-pin {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
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
        
        // Initialize - focus on fullname input
        fullnameInput.focus();
        
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
                        inputs[index - 1].value = '';
                        updatePinValue(inputs, hiddenInput);
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
                    this.style.borderColor = 'var(--blue-600)';
                    this.style.backgroundColor = 'var(--white)';
                    this.classList.add('filled');
                });
                
                input.addEventListener('blur', function() {
                    if (this.value === '') {
                        this.style.borderColor = 'var(--border-color)';
                        this.style.backgroundColor = 'var(--primary-lighter)';
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
            
            // Check for simple PIN patterns
            const simplePatterns = ['0000', '1111', '1234', '4321', '9999'];
            if (simplePatterns.includes(pin)) {
                pinError.textContent = 'PIN terlalu mudah, gunakan kombinasi lain';
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
            let phone = phoneInput.value.trim().replace(/\D/g, '');
            
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
                    // Success message with SweetAlert2
                    Swal.fire({
                        title: 'Pendaftaran Berhasil!',
                        html: `
                            <div class="text-start">
                                <p><strong>Nama:</strong> ${fullnameInput.value}</p>
                                <p><strong>Telepon:</strong> ${phoneInput.value}</p>
                                <p><strong>PIN:</strong> ****</p>
                            </div>
                            <p class="mt-3">Silakan login dengan akun yang telah dibuat.</p>
                        `,
                        icon: 'success',
                        confirmButtonColor: 'var(--blue-700)',
                        confirmButtonText: 'Login Sekarang',
                        showCancelButton: true,
                        cancelButtonText: 'Tutup'
                    }).then((result) => {
                        // Reset button
                        submitBtn.innerHTML = originalHTML;
                        submitBtn.disabled = false;
                        
                        if (result.isConfirmed) {
                            // Redirect to login
                            window.location.href = "{{ route('login') }}";
                        } else {
                            // Reset form
                            registerForm.reset();
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
                            fullnameInput.focus();
                        }
                    });
                }, 1500);
            } else {
                // Focus on first invalid field
                if (!isFullnameValid) {
                    fullnameInput.focus();
                    fullnameInput.classList.add('shake');
                    setTimeout(() => fullnameInput.classList.remove('shake'), 500);
                } else if (!isPhoneValid) {
                    phoneInput.focus();
                    phoneInput.classList.add('shake');
                    setTimeout(() => phoneInput.classList.remove('shake'), 500);
                } else if (!isPinValid) {
                    registerPinInputs[0].focus();
                    registerPinInputs.forEach(input => input.classList.add('shake'));
                    setTimeout(() => registerPinInputs.forEach(input => input.classList.remove('shake')), 500);
                } else if (!isConfirmPinValid) {
                    confirmPinInputs[0].focus();
                    confirmPinInputs.forEach(input => input.classList.add('shake'));
                    setTimeout(() => confirmPinInputs.forEach(input => input.classList.remove('shake')), 500);
                } else if (!isTermsValid) {
                    termsCheckbox.focus();
                }
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
                
                // Show demo notification
                Swal.fire({
                    title: 'Demo Data',
                    text: 'Data demo telah dimasukkan',
                    icon: 'info',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });
</script>

<!-- SweetAlert2 for better notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection