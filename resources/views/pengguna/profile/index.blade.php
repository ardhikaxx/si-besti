@extends('layouts.app')
@section('title', 'Profile - SI Besti')
@section('content')
    <div class="profile-container py-3" style="margin-bottom: 20px;">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg welcome-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column align-items-start">
                                <h3 class="fw-bold mb-2 welcome-text">
                                    <i class="fas fa-user-circle me-2"></i>Profil Saya
                                </h3>
                                <p class="mb-0 date-text">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Kelola informasi profil Anda
                                </p>
                            </div>
                            <div class="text-end">
                                <div class="avatar-circle profile-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg form-card">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form id="profileForm" method="POST" action="{{ route('pengguna.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Left Column -->
                                <div class="col-lg-6">
                                    <!-- Nama Lengkap -->
                                    <div class="form-group">
                                        <label for="nama_lengkap" class="form-label">
                                            <i class="fas fa-user me-2"></i>Nama Lengkap
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" id="nama_lengkap"
                                                name="nama_lengkap"
                                                value="{{ old('nama_lengkap', $pengguna->nama_lengkap) }}"
                                                placeholder="Masukkan nama lengkap">
                                        </div>
                                        <div class="form-text text-muted small mt-1">
                                            Nama lengkap Anda akan ditampilkan di aplikasi
                                        </div>
                                        <div class="invalid-feedback" id="nama_lengkap_error"></div>
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div class="form-group">
                                        <label for="nomor_telepon" class="form-label">
                                            <i class="fas fa-phone me-2"></i>Nomor Telepon
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-phone text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" id="nomor_telepon"
                                                name="nomor_telepon"
                                                value="{{ old('nomor_telepon', $pengguna->nomor_telepon) }}"
                                                placeholder="Masukkan nomor telepon">
                                        </div>
                                        <div class="form-text text-muted small mt-1">
                                            Digunakan untuk login dan verifikasi
                                        </div>
                                        <div class="invalid-feedback" id="nomor_telepon_error"></div>
                                    </div>

                                    <!-- Umur -->
                                    <div class="form-group">
                                        <label for="umur" class="form-label">
                                            <i class="fas fa-birthday-cake me-2"></i>Umur
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-birthday-cake text-primary"></i>
                                            </span>
                                            <input type="number" class="form-control form-control-lg" id="umur"
                                                name="umur" value="{{ old('umur', $pengguna->umur) }}"
                                                placeholder="Masukkan umur" min="1" max="120">
                                            <span class="input-group-text bg-light border-start-0">tahun</span>
                                        </div>
                                        <div class="invalid-feedback" id="umur_error"></div>
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin
                                        </label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check gender-option">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="jenis_kelamin_L" value="L"
                                                    {{ old('jenis_kelamin', $pengguna->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jenis_kelamin_L">
                                                    <div class="gender-card">
                                                        <i class="fas fa-mars fa-2x mb-2"></i>
                                                        <span>Laki-laki</span>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="form-check gender-option">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="jenis_kelamin_P" value="P"
                                                    {{ old('jenis_kelamin', $pengguna->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jenis_kelamin_P">
                                                    <div class="gender-card">
                                                        <i class="fas fa-venus fa-2x mb-2"></i>
                                                        <span>Perempuan</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" id="jenis_kelamin_error"></div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-lg-6">
                                    <!-- Alamat -->
                                    <div class="form-group">
                                        <label for="alamat" class="form-label">
                                            <i class="fas fa-home me-2"></i>Alamat
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 align-items-start pt-3">
                                                <i class="fas fa-home text-primary"></i>
                                            </span>
                                            <textarea class="form-control form-control-lg" id="alamat" name="alamat" rows="3"
                                                placeholder="Masukkan alamat lengkap">{{ old('alamat', $pengguna->alamat) }}</textarea>
                                        </div>
                                        <div class="invalid-feedback" id="alamat_error"></div>
                                    </div>

                                    <!-- PIN Baru -->
                                    <div class="form-group">
                                        <label for="pin" class="form-label">
                                            <i class="fas fa-lock me-2"></i>PIN Baru (Opsional)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-key text-primary"></i>
                                            </span>
                                            <input type="password" class="form-control form-control-lg" id="pin"
                                                name="pin" placeholder="Masukkan PIN baru (6 digit)" maxlength="6">
                                            <button class="btn btn-outline-secondary toggle-pin" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text text-muted small mt-1">
                                            Kosongkan jika tidak ingin mengubah PIN
                                        </div>
                                        <div class="invalid-feedback" id="pin_error"></div>
                                    </div>

                                    <!-- Konfirmasi PIN -->
                                    <div class="form-group">
                                        <label for="confirm_pin" class="form-label">
                                            <i class="fas fa-lock me-2"></i>Konfirmasi PIN Baru
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-key text-primary"></i>
                                            </span>
                                            <input type="password" class="form-control form-control-lg" id="confirm_pin"
                                                name="confirm_pin" placeholder="Konfirmasi PIN baru" maxlength="6">
                                            <button class="btn btn-outline-secondary toggle-pin" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback" id="confirm_pin_error"></div>
                                    </div>

                                    <!-- Informasi Tambahan untuk Perempuan -->
                                    <div id="additionalInfo"
                                        style="{{ $pengguna->jenis_kelamin == 'P' ? '' : 'display: none;' }}">
                                        <!-- Usia Kehamilan -->
                                        <div class="form-group">
                                            <label for="usia_kehamilan" class="form-label">
                                                <i class="fas fa-baby me-2"></i>Usia Kehamilan (Minggu)
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-baby text-primary"></i>
                                                </span>
                                                <input type="number" class="form-control form-control-lg"
                                                    id="usia_kehamilan" name="usia_kehamilan"
                                                    value="{{ old('usia_kehamilan', $pengguna->usia_kehamilan) }}"
                                                    placeholder="Masukkan usia kehamilan" min="1" max="45">
                                                <span class="input-group-text bg-light border-start-0">minggu</span>
                                            </div>
                                            <div class="invalid-feedback" id="usia_kehamilan_error"></div>
                                        </div>

                                        <!-- Hamil Anak Ke -->
                                        <div class="form-group">
                                            <label for="hamil_anak_ke" class="form-label">
                                                <i class="fas fa-baby-carriage me-2"></i>Hamil Anak Ke
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-baby-carriage text-primary"></i>
                                                </span>
                                                <input type="number" class="form-control form-control-lg"
                                                    id="hamil_anak_ke" name="hamil_anak_ke"
                                                    value="{{ old('hamil_anak_ke', $pengguna->hamil_anak_ke) }}"
                                                    placeholder="Masukkan hamil anak ke" min="1">
                                            </div>
                                            <div class="invalid-feedback" id="hamil_anak_ke_error"></div>
                                        </div>

                                        <!-- Jumlah Anak -->
                                        <div class="form-group">
                                            <label for="jumlah_anak" class="form-label">
                                                <i class="fas fa-children me-2"></i>Jumlah Anak
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-children text-primary"></i>
                                                </span>
                                                <input type="number" class="form-control form-control-lg"
                                                    id="jumlah_anak" name="jumlah_anak"
                                                    value="{{ old('jumlah_anak', $pengguna->jumlah_anak) }}"
                                                    placeholder="Masukkan jumlah anak" min="0">
                                            </div>
                                            <div class="invalid-feedback" id="jumlah_anak_error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-center gap-3">
                                        <button type="button" class="btn btn-secondary btn-lg px-5" id="cancelBtn">
                                            <i class="fas fa-times me-2"></i>Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-lg px-5" id="saveBtn">
                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --blue-100: #E8F0FE;
            --blue-200: #C6DAFC;
            --blue-300: #A3C4FA;
            --blue-400: #7FACE8;
            --blue-500: #5C95E6;
            --blue-600: #3A7DE4;
            --blue-700: #2674E6;
            --blue-800: #1260D2;
            --blue-900: #0856C8;
            --blue-950: #0645A0;
            --primary: var(--blue-900);
            --gradient-primary: linear-gradient(135deg, #0856C8 0%, #2674E6 100%);
            --gradient-light: linear-gradient(135deg, #E8F0FE 0%, #C6DAFC 100%);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e8f0fe 100%);
        }

        /* Welcome Card */
        .welcome-card {
            background: var(--gradient-primary);
            border-radius: 20px !important;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-text {
            color: #ffffff;
            font-size: 1.75rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .date-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
        }

        .profile-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        /* Form Card */
        .form-card {
            border-radius: 20px !important;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .form-card:hover {
            box-shadow: 0 15px 35px rgba(8, 86, 200, 0.15) !important;
        }

        .card-header-custom {
            background: var(--gradient-primary);
            color: #ffffff;
            padding: 1.25rem 1.5rem;
            border-radius: 20px 20px 0 0 !important;
            font-weight: 600;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--blue-900);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 8px;
            width: 20px;
        }

        .form-control-lg {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 2px solid #E3E6F0;
            transition: all 0.3s ease;
        }

        .form-control-lg:focus {
            border-color: var(--blue-600);
            box-shadow: 0 0 0 0.25rem rgba(8, 86, 200, 0.15);
        }

        .input-group-text {
            background: var(--gradient-light);
            border: 2px solid #E3E6F0;
            border-right: none;
            padding: 0.75rem 1rem;
        }

        .input-group .form-control-lg {
            border-left: none;
        }

        .input-group .form-control-lg:focus {
            border-left: none;
        }

        /* Gender Options */
        .gender-option {
            flex: 1;
        }

        .gender-option .form-check-input {
            display: none;
        }

        .gender-option .form-check-input:checked+.form-check-label .gender-card {
            background: var(--gradient-primary);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(8, 86, 200, 0.2);
        }

        .gender-card {
            background: #f8fafc;
            border: 2px solid #E3E6F0;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .gender-card:hover {
            background: var(--blue-100);
            border-color: var(--blue-300);
        }

        .gender-card i {
            margin-bottom: 0.5rem;
        }

        /* Buttons */
        .btn-lg {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(8, 86, 200, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-3px);
        }

        /* Toggle Password Button */
        .toggle-pin {
            border: 2px solid #E3E6F0;
            border-left: none;
            padding: 0.75rem 1rem;
        }

        .toggle-pin:hover {
            background: var(--blue-100);
            border-color: var(--blue-300);
        }

        /* Invalid Feedback */
        .invalid-feedback {
            display: none;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-control.is-invalid,
        .was-validated .form-control:invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus,
        .was-validated .form-control:invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-text {
                font-size: 1.4rem;
            }

            .profile-avatar {
                width: 60px;
                height: 60px;
                font-size: 1.4rem;
            }

            .gender-card {
                padding: 1rem;
                height: 100px;
            }

            .btn-lg {
                padding: 0.625rem 1.5rem;
            }

            .card-header-custom h5 {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .welcome-card::before {
                width: 250px;
                height: 250px;
            }

            .form-control-lg {
                font-size: 0.875rem;
            }

            .gender-card {
                padding: 0.75rem;
                height: 90px;
            }

            .gender-card i {
                font-size: 1.5rem;
            }

            .d-flex.gap-3 {
                gap: 1rem !important;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Loading State */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin: -10px 0 0 -10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileForm = document.getElementById('profileForm');
            const cancelBtn = document.getElementById('cancelBtn');
            const saveBtn = document.getElementById('saveBtn');
            const pinInput = document.getElementById('pin');
            const confirmPinInput = document.getElementById('confirm_pin');
            const togglePinButtons = document.querySelectorAll('.toggle-pin');
            const additionalInfo = document.getElementById('additionalInfo');
            const jenisKelaminInputs = document.querySelectorAll('input[name="jenis_kelamin"]');

            // Toggle visibility of additional info based on gender
            jenisKelaminInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === 'P') {
                        additionalInfo.style.display = 'block';
                    } else {
                        additionalInfo.style.display = 'none';
                        // Clear female-specific fields
                        document.getElementById('usia_kehamilan').value = '';
                        document.getElementById('hamil_anak_ke').value = '';
                        document.getElementById('jumlah_anak').value = '';
                    }
                });
            });

            // Toggle PIN visibility
            togglePinButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Cancel button handler
            cancelBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Batalkan perubahan?',
                    text: "Perubahan yang belum disimpan akan hilang.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, batalkan',
                    cancelButtonText: 'Tidak, tetap edit'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            });

            // Form submission handler
            profileForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Clear previous error messages
                clearErrors();

                // Show loading state
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                saveBtn.disabled = true;
                cancelBtn.disabled = true;

                try {
                    const response = await fetch(this.action, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(Object.fromEntries(new FormData(this)))
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Show success message
                        await Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#0856C8',
                            confirmButtonText: 'OK'
                        });

                        // Update form fields with new data
                        if (data.data) {
                            document.getElementById('nama_lengkap').value = data.data.nama_lengkap;
                            document.getElementById('nomor_telepon').value = data.data.nomor_telepon;
                            document.getElementById('umur').value = data.data.umur;
                            document.getElementById('alamat').value = data.data.alamat;

                            // Clear PIN fields
                            document.getElementById('pin').value = '';
                            document.getElementById('confirm_pin').value = '';

                            // Update welcome message in dashboard
                            const welcomeElements = document.querySelectorAll('.welcome-text');
                            welcomeElements.forEach(el => {
                                if (el.textContent.includes('Hi,')) {
                                    el.textContent = `Hi, ${data.data.nama_lengkap}!`;
                                }
                            });
                        }
                    } else {
                        // Show validation errors
                        if (data.errors) {
                            displayErrors(data.errors);
                            Swal.fire({
                                title: 'Validasi Gagal',
                                text: 'Terdapat kesalahan dalam pengisian form',
                                icon: 'error',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat menyimpan data',
                                icon: 'error',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } finally {
                    // Reset button state
                    saveBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';
                    saveBtn.disabled = false;
                    cancelBtn.disabled = false;
                }
            });

            // Function to display validation errors
            function displayErrors(errors) {
                for (const field in errors) {
                    const input = document.getElementById(field);
                    const errorDiv = document.getElementById(field + '_error');

                    if (input) {
                        input.classList.add('is-invalid');
                    }

                    if (errorDiv) {
                        errorDiv.textContent = errors[field][0];
                        errorDiv.style.display = 'block';
                    }
                }
            }

            // Function to clear all error messages
            function clearErrors() {
                // Remove invalid class from all inputs
                document.querySelectorAll('.form-control.is-invalid').forEach(input => {
                    input.classList.remove('is-invalid');
                });

                // Hide all error messages
                document.querySelectorAll('.invalid-feedback').forEach(errorDiv => {
                    errorDiv.style.display = 'none';
                });
            }

            // Real-time validation for PIN fields
            confirmPinInput.addEventListener('input', function() {
                const pin = pinInput.value;
                const confirmPin = this.value;

                if (pin && confirmPin && pin !== confirmPin) {
                    this.classList.add('is-invalid');
                    document.getElementById('confirm_pin_error').textContent = 'PIN tidak cocok';
                    document.getElementById('confirm_pin_error').style.display = 'block';
                } else {
                    this.classList.remove('is-invalid');
                    document.getElementById('confirm_pin_error').style.display = 'none';
                }
            });

            // Optional: Add character counter for textarea
            const alamatTextarea = document.getElementById('alamat');
            if (alamatTextarea) {
                const charCounter = document.createElement('div');
                charCounter.className = 'form-text text-end text-muted small mt-1';
                charCounter.id = 'alamat_counter';
                alamatTextarea.parentNode.appendChild(charCounter);

                function updateCounter() {
                    const count = alamatTextarea.value.length;
                    charCounter.textContent = `${count} karakter`;
                }

                alamatTextarea.addEventListener('input', updateCounter);
                updateCounter();
            }
        });
    </script>
@endpush
