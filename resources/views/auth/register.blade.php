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

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="mb-1"><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <!-- Form -->
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="auth-form-group">
                        <label for="fullname" class="auth-label">
                            <i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <div class="auth-input-group">
                            <input type="text" class="auth-input @error('fullname') is-invalid @enderror" id="fullname"
                                name="fullname" placeholder="Masukkan nama lengkap Anda" required autofocus
                                value="{{ old('fullname') }}">
                        </div>
                        <span id="fullnameError" class="auth-error"></span>
                        @error('fullname')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="auth-form-group">
                        <label for="phone" class="auth-label">
                            <i class="fas fa-phone"></i> Nomor Telepon <span class="text-danger">*</span>
                        </label>
                        <div class="auth-input-group">
                            <input type="text" class="auth-input @error('phone') is-invalid @enderror" id="phone"
                                name="phone" placeholder="Contoh: 081234567890" required value="{{ old('phone') }}">
                        </div>
                        <span id="phoneError" class="auth-error"></span>
                        @error('phone')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Umur -->
                    <div class="auth-form-group">
                        <label for="umur" class="auth-label">
                            <i class="fas fa-calendar-alt"></i> Umur <span class="text-danger">*</span>
                        </label>
                        <div class="auth-input-group">
                            <input type="number" class="auth-input @error('umur') is-invalid @enderror" id="umur"
                                name="umur" placeholder="Masukkan umur Anda" required min="15" max="50"
                                value="{{ old('umur') }}">
                        </div>
                        <span id="umurError" class="auth-error"></span>
                        @error('umur')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="auth-form-group">
                        <label class="auth-label">
                            <i class="fas fa-venus-mars"></i> Jenis Kelamin <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-4">
                            <label class="auth-radio">
                                <input type="radio" name="jenis_kelamin" value="L"
                                    {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                                <span class="auth-radio-label">
                                    <i class="fas fa-male"></i> Laki-laki
                                </span>
                            </label>
                            <label class="auth-radio">
                                <input type="radio" name="jenis_kelamin" value="P"
                                    {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required>
                                <span class="auth-radio-label">
                                    <i class="fas fa-female"></i> Perempuan
                                </span>
                            </label>
                        </div>
                        <span id="jenisKelaminError" class="auth-error"></span>
                        @error('jenis_kelamin')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="auth-form-group">
                        <label for="alamat" class="auth-label">
                            <i class="fas fa-home"></i> Alamat <span class="text-danger">*</span>
                        </label>
                        <div class="auth-input-group">
                            <textarea class="auth-input @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                        </div>
                        <span id="alamatError" class="auth-error"></span>
                        @error('alamat')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Usia Kehamilan -->
                    <div class="auth-form-group">
                        <label for="usia_kehamilan" class="auth-label">
                            <i class="fas fa-baby"></i> Usia Kehamilan (minggu)
                        </label>
                        <div class="auth-input-group">
                            <input type="number" class="auth-input @error('usia_kehamilan') is-invalid @enderror"
                                id="usia_kehamilan" name="usia_kehamilan"
                                placeholder="Masukkan usia kehamilan dalam minggu" min="1" max="42"
                                value="{{ old('usia_kehamilan') }}">
                        </div>
                        <span id="usiaKehamilanError" class="auth-error"></span>
                        @error('usia_kehamilan')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Hamil Anak Ke -->
                    <div class="auth-form-group">
                        <label for="hamil_anak_ke" class="auth-label">
                            <i class="fas fa-baby-carriage"></i> Hamil Anak Ke
                        </label>
                        <div class="auth-input-group">
                            <input type="number" class="auth-input @error('hamil_anak_ke') is-invalid @enderror"
                                id="hamil_anak_ke" name="hamil_anak_ke" placeholder="Masukkan kehamilan ke berapa"
                                min="1" value="{{ old('hamil_anak_ke') }}">
                        </div>
                        <span id="hamilAnakKeError" class="auth-error"></span>
                        @error('hamil_anak_ke')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Jumlah Anak -->
                    <div class="auth-form-group">
                        <label for="jumlah_anak" class="auth-label">
                            <i class="fas fa-child"></i> Jumlah Anak
                        </label>
                        <div class="auth-input-group">
                            <input type="number" class="auth-input @error('jumlah_anak') is-invalid @enderror"
                                id="jumlah_anak" name="jumlah_anak" placeholder="Masukkan jumlah anak" min="0"
                                value="{{ old('jumlah_anak', 0) }}">
                        </div>
                        <span id="jumlahAnakError" class="auth-error"></span>
                        @error('jumlah_anak')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- PIN -->
                    <div class="auth-form-group">
                        <label class="auth-label">
                            <i class="fas fa-key"></i> Buat PIN (4 digit) <span class="text-danger">*</span>
                        </label>

                        <div class="pin-container">
                            <input type="text" class="pin-input register-pin @error('pin') is-invalid @enderror"
                                maxlength="1" data-index="1" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input register-pin @error('pin') is-invalid @enderror"
                                maxlength="1" data-index="2" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input register-pin @error('pin') is-invalid @enderror"
                                maxlength="1" data-index="3" autocomplete="off" inputmode="numeric">
                            <input type="text" class="pin-input register-pin @error('pin') is-invalid @enderror"
                                maxlength="1" data-index="4" autocomplete="off" inputmode="numeric">
                        </div>

                        <input type="hidden" id="pin" name="pin" value="{{ old('pin') }}">
                        <span id="pinError" class="auth-error"></span>
                        @error('pin')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i> Masukkan 4 digit PIN
                            </small>
                            <button type="button" id="clearPinBtn" class="btn btn-link text-decoration-none p-0"
                                style="color: var(--blue-700); font-weight: 500;">
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
                            <input type="text"
                                class="pin-input confirm-pin @error('confirm_pin') is-invalid @enderror" maxlength="1"
                                data-index="1" autocomplete="off" inputmode="numeric">
                            <input type="text"
                                class="pin-input confirm-pin @error('confirm_pin') is-invalid @enderror" maxlength="1"
                                data-index="2" autocomplete="off" inputmode="numeric">
                            <input type="text"
                                class="pin-input confirm-pin @error('confirm_pin') is-invalid @enderror" maxlength="1"
                                data-index="3" autocomplete="off" inputmode="numeric">
                            <input type="text"
                                class="pin-input confirm-pin @error('confirm_pin') is-invalid @enderror" maxlength="1"
                                data-index="4" autocomplete="off" inputmode="numeric">
                        </div>

                        <input type="hidden" id="confirmPin" name="confirm_pin" value="{{ old('confirm_pin') }}">
                        <span id="confirmPinError" class="auth-error"></span>
                        @error('confirm_pin')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i> Ulangi PIN yang sama
                            </small>
                            <button type="button" id="clearConfirmPinBtn" class="btn btn-link text-decoration-none p-0"
                                style="color: var(--blue-700); font-weight: 500;">
                                <i class="fas fa-backspace me-1"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="auth-form-group">
                        <label class="auth-checkbox">
                            <input type="checkbox" id="terms" name="terms" required
                                {{ old('terms') ? 'checked' : '' }}>
                            <span class="auth-checkbox-label">
                                Saya menyetujui
                                <a href="#" class="auth-link">Syarat & Ketentuan</a>
                                dan
                                <a href="#" class="auth-link">Kebijakan Privasi</a>
                            </span>
                        </label>
                        <span id="termsError" class="auth-error"></span>
                        @error('terms')
                            <span class="auth-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn mt-2" id="registerBtn"
                        style="
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
        /* Add radio button styles */
        .auth-radio {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            border: 2px solid var(--border-color);
            transition: var(--transition);
            background: var(--white);
        }

        .auth-radio:hover {
            border-color: var(--blue-600);
            background: var(--blue-100);
        }

        .auth-radio input[type="radio"] {
            margin: 0;
            width: 1.2rem;
            height: 1.2rem;
        }

        .auth-radio-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .auth-radio input[type="radio"]:checked+.auth-radio-label {
            color: var(--blue-700);
        }

        .auth-radio input[type="radio"]:checked~.auth-radio-label i {
            color: var(--blue-700);
        }

        textarea.auth-input {
            resize: vertical;
            min-height: 100px;
        }

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

        .register-pin.is-invalid,
        .confirm-pin.is-invalid {
            border-color: var(--danger);
            background-color: rgba(231, 74, 59, 0.15);
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
            box-shadow: 0 10px 25px rgba(38, 116, 230, 0.35) !important;
        }

        @media (max-width: 576px) {

            .register-pin,
            .confirm-pin {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .auth-radio {
                padding: 0.5rem;
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
            const umurInput = document.getElementById('umur');
            const alamatInput = document.getElementById('alamat');
            const usiaKehamilanInput = document.getElementById('usia_kehamilan');
            const hamilAnakKeInput = document.getElementById('hamil_anak_ke');
            const jumlahAnakInput = document.getElementById('jumlah_anak');
            const termsCheckbox = document.getElementById('terms');
            const registerForm = document.getElementById('registerForm');
            const registerBtn = document.getElementById('registerBtn');

            // Error elements
            const fullnameError = document.getElementById('fullnameError');
            const phoneError = document.getElementById('phoneError');
            const umurError = document.getElementById('umurError');
            const alamatError = document.getElementById('alamatError');
            const pinError = document.getElementById('pinError');
            const confirmPinError = document.getElementById('confirmPinError');

            // Pre-fill old values
            const oldPin = hiddenPinInput.value;
            if (oldPin && oldPin.length === 4) {
                for (let i = 0; i < 4; i++) {
                    registerPinInputs[i].value = oldPin[i];
                    registerPinInputs[i].classList.add('filled');
                }
            }

            const oldConfirmPin = hiddenConfirmPinInput.value;
            if (oldConfirmPin && oldConfirmPin.length === 4) {
                for (let i = 0; i < 4; i++) {
                    confirmPinInputs[i].value = oldConfirmPin[i];
                    confirmPinInputs[i].classList.add('filled');
                }
            }

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

                pinError.textContent = '✓ PIN valid';
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

            // Form validation functions
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

                fullnameError.textContent = '✓ Nama lengkap valid';
                fullnameError.className = 'auth-success';
                return true;
            }

            function validatePhone() {
                let phone = phoneInput.value.trim();

                // Remove non-numeric characters
                const numericPhone = phone.replace(/\D/g, '');

                if (phone.length === 0) {
                    phoneError.textContent = 'Nomor telepon harus diisi';
                    phoneError.className = 'auth-error';
                    return false;
                }

                // Check if starts with 08
                if (!numericPhone.startsWith('08')) {
                    phoneError.textContent = 'Nomor telepon harus diawali dengan 08';
                    phoneError.className = 'auth-error';
                    return false;
                }

                // Check length (10-13 digits after removing non-numeric)
                if (numericPhone.length < 10 || numericPhone.length > 13) {
                    phoneError.textContent = 'Nomor telepon harus 10-13 digit';
                    phoneError.className = 'auth-error';
                    return false;
                }

                // Format phone number for display
                if (numericPhone !== phone) {
                    phoneInput.value = numericPhone;
                }

                phoneError.textContent = '✓ Nomor telepon valid';
                phoneError.className = 'auth-success';
                return true;
            }

            function validateUmur() {
                const umur = parseInt(umurInput.value);

                if (!umur || isNaN(umur)) {
                    umurError.textContent = 'Umur harus diisi';
                    umurError.className = 'auth-error';
                    return false;
                }

                if (umur < 15 || umur > 50) {
                    umurError.textContent = 'Umur harus antara 15-50 tahun';
                    umurError.className = 'auth-error';
                    return false;
                }

                umurError.textContent = '✓ Umur valid';
                umurError.className = 'auth-success';
                return true;
            }

            function validateAlamat() {
                const alamat = alamatInput.value.trim();

                if (alamat.length === 0) {
                    alamatError.textContent = 'Alamat harus diisi';
                    alamatError.className = 'auth-error';
                    return false;
                }

                if (alamat.length < 10) {
                    alamatError.textContent = 'Alamat minimal 10 karakter';
                    alamatError.className = 'auth-error';
                    return false;
                }

                alamatError.textContent = '✓ Alamat valid';
                alamatError.className = 'auth-success';
                return true;
            }

            // Initialize PIN inputs
            setupPinInputs(registerPinInputs, hiddenPinInput, false);
            setupPinInputs(confirmPinInputs, hiddenConfirmPinInput, true);

            // Add event listeners for validation
            fullnameInput.addEventListener('input', validateFullname);
            phoneInput.addEventListener('input', validatePhone);
            umurInput.addEventListener('input', validateUmur);
            alamatInput.addEventListener('input', validateAlamat);
            termsCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('termsError').textContent = '';
                }
            });

            // Form submission
            registerForm.addEventListener('submit', function(e) {
                const isFullnameValid = validateFullname();
                const isPhoneValid = validatePhone();
                const isUmurValid = validateUmur();
                const isAlamatValid = validateAlamat();
                const isPinValid = validatePin();
                const isConfirmPinValid = validateConfirmPin();
                const isTermsChecked = termsCheckbox.checked;

                if (!isTermsChecked) {
                    document.getElementById('termsError').textContent =
                        'Anda harus menyetujui syarat dan ketentuan';
                    document.getElementById('termsError').className = 'auth-error';
                } else {
                    document.getElementById('termsError').textContent = '';
                }

                if (isFullnameValid && isPhoneValid && isUmurValid && isAlamatValid &&
                    isPinValid && isConfirmPinValid && isTermsChecked) {
                    // All valid, disable button and show loading
                    registerBtn.disabled = true;
                    registerBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
                } else {
                    e.preventDefault();
                    // Scroll to first error
                    if (!isFullnameValid) {
                        fullnameInput.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        fullnameInput.focus();
                    } else if (!isPhoneValid) {
                        phoneInput.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        phoneInput.focus();
                    } else if (!isUmurValid) {
                        umurInput.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        umurInput.focus();
                    } else if (!isAlamatValid) {
                        alamatInput.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        alamatInput.focus();
                    } else if (!isPinValid) {
                        registerPinInputs[0].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        registerPinInputs[0].focus();
                    } else if (!isConfirmPinValid) {
                        confirmPinInputs[0].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        confirmPinInputs[0].focus();
                    } else if (!isTermsChecked) {
                        termsCheckbox.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            });
        });
    </script>
@endsection
