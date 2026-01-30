@extends('layouts.app')
@section('title', 'Profile - SI Besti')

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
            --gradient-primary: linear-gradient(135deg, #0856C8 0%, #2674E6 100%);
            --gradient-light: linear-gradient(135deg, #E8F0FE 0%, #C6DAFC 100%);
            --gradient-success: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e8f0fe 100%);
            font-family: 'Poppins', sans-serif;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            padding-bottom: 80px;
        }

        /* Welcome Card */
        .welcome-card {
            background: var(--gradient-primary);
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(8, 86, 200, 0.2);
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-card .card-body {
            position: relative;
            z-index: 1;
        }

        .welcome-text {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .date-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            backdrop-filter: blur(10px);
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        /* Form Card */
        .form-card {
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(8, 86, 200, 0.15);
            transition: all 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(8, 86, 200, 0.2);
        }

        .card-header-custom {
            background: var(--gradient-primary);
            color: #ffffff;
            padding: 25px 30px;
            border-radius: 25px 25px 0 0;
            font-weight: 700;
        }

        .card-header-custom h5 {
            margin: 0;
            font-size: 1.4rem;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-label {
            font-weight: 700;
            color: var(--blue-900);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
        }

        .form-label i {
            margin-right: 10px;
            width: 20px;
            color: var(--blue-600);
        }

        .form-control-lg {
            padding: 14px 18px;
            border-radius: 15px;
            border: 2px solid var(--blue-200);
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control-lg:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 4px rgba(58, 125, 228, 0.15);
            outline: none;
            background: var(--blue-100);
        }

        .input-group-text {
            background: var(--gradient-light);
            border: 2px solid var(--blue-200);
            border-right: none;
            padding: 14px 18px;
            border-radius: 15px 0 0 15px;
        }

        .input-group .form-control-lg {
            border-left: none;
            border-radius: 0 15px 15px 0;
        }

        .input-group .form-control-lg:focus {
            border-left: none;
        }

        .input-group-text i {
            color: var(--blue-700);
        }

        .form-text {
            color: var(--blue-600);
            font-size: 0.85rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .gender-option .form-check-input {
            display: none;
        }

        .gender-card {
            background: var(--gradient-light);
            border: 3px solid var(--blue-200);
            border-radius: 20px;
            padding: 25px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 140px;
            width: 140px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
/* 
        .gender-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        } */

        .gender-card:hover {
            transform: translateY(-5px);
            border-color: var(--blue-400);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.2);
        }

        .gender-option .form-check-input:checked+.form-check-label .gender-card {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--blue-700);
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(8, 86, 200, 0.3);
        }

        .gender-option .form-check-input:checked+.form-check-label .gender-card::before {
            transform: scaleX(1);
        }

        .gender-card i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .gender-card span {
            font-weight: 600;
            font-size: 1rem;
        }

        /* Buttons */
        .btn-lg {
            padding: 15px 40px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-lg::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-lg:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            color: #ffffff;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(8, 86, 200, 0.4);
            color: #ffffff;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border: none;
            color: #ffffff;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(108, 117, 125, 0.3);
            color: #ffffff;
        }

        /* Toggle PIN Button */
        .toggle-pin {
            border: 2px solid var(--blue-200);
            border-left: none;
            border-radius: 0 15px 15px 0;
            padding: 14px 18px;
            background: var(--blue-100);
            color: var(--blue-700);
            transition: all 0.3s ease;
        }

        .toggle-pin:hover {
            background: var(--blue-200);
            border-color: var(--blue-300);
        }

        /* Invalid Feedback */
        .invalid-feedback {
            display: none;
            font-size: 0.875rem;
            margin-top: 8px;
            color: #dc3545;
            font-weight: 600;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: none;
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.25);
        }

        /* Additional Info Section */
        #additionalInfo {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading State */
        .btn-loading {
            position: relative;
            color: transparent !important;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            top: 50%;
            left: 50%;
            margin: -12px 0 0 -12px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-text {
                font-size: 1.5rem;
            }

            .profile-avatar {
                width: 70px;
                height: 70px;
                font-size: 2rem;
            }

            .card-header-custom h5 {
                font-size: 1.2rem;
            }

            .gender-card {
                padding: 20px 15px;
                height: 120px;
            }

            .gender-card i {
                font-size: 2rem;
            }

            .btn-lg {
                padding: 12px 30px;
                font-size: 1rem;
            }

            .form-control-lg {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .profile-container {
                padding: 15px;
            }

            .welcome-card::before {
                width: 300px;
                height: 300px;
            }

            .welcome-card .card-body {
                padding: 20px !important;
            }

            .form-card .card-body {
                padding: 25px 20px !important;
            }

            .gender-card {
                padding: 15px 10px;
                height: 100px;
            }

            .gender-card i {
                font-size: 1.75rem;
                margin-bottom: 8px;
            }

            .gender-card span {
                font-size: 0.9rem;
            }

            .d-flex.gap-3 {
                gap: 1rem !important;
                flex-direction: column;
            }

            .btn-lg {
                width: 100%;
            }
        }

        /* Animations */
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

        .welcome-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .form-card {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Textarea Styling */
        textarea.form-control-lg {
            resize: vertical;
            min-height: 100px;
        }

        /* Character Counter */
        #alamat_counter {
            text-align: right;
            font-size: 0.8rem;
            color: var(--blue-600);
            margin-top: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="profile-container py-3">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 welcome-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column align-items-start">
                                <h3 class="welcome-text mb-2">
                                    <i class="fas fa-user-circle me-2"></i>Profil Saya
                                </h3>
                                <p class="mb-0 date-text">
                                    <i class="fas fa-edit me-2"></i>Kelola informasi profil Anda
                                </p>
                            </div>
                            <div class="text-end">
                                <div class="profile-avatar">
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
                <div class="card border-0 form-card">
                    <div class="card-header-custom">
                        <h5>
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form id="profileForm" method="POST" action="{{ route('pengguna.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <!-- Left Column -->
                                <div class="col-lg-6">
                                    <!-- Nama Lengkap -->
                                    <div class="form-group">
                                        <label for="nama_lengkap" class="form-label">
                                            <i class="fas fa-user"></i>Nama Lengkap
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" id="nama_lengkap"
                                                name="nama_lengkap"
                                                value="{{ old('nama_lengkap', $pengguna->nama_lengkap) }}"
                                                placeholder="Masukkan nama lengkap">
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>Nama lengkap Anda akan ditampilkan di aplikasi
                                        </div>
                                        <div class="invalid-feedback" id="nama_lengkap_error"></div>
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div class="form-group">
                                        <label for="nomor_telepon" class="form-label">
                                            <i class="fas fa-phone"></i>Nomor Telepon
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" id="nomor_telepon"
                                                name="nomor_telepon"
                                                value="{{ old('nomor_telepon', $pengguna->nomor_telepon) }}"
                                                placeholder="Masukkan nomor telepon">
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>Digunakan untuk login dan verifikasi
                                        </div>
                                        <div class="invalid-feedback" id="nomor_telepon_error"></div>
                                    </div>

                                    <!-- Umur -->
                                    <div class="form-group">
                                        <label for="umur" class="form-label">
                                            <i class="fas fa-birthday-cake"></i>Umur
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-birthday-cake"></i>
                                            </span>
                                            <input type="number" class="form-control form-control-lg" id="umur"
                                                name="umur" value="{{ old('umur', $pengguna->umur) }}"
                                                placeholder="Masukkan umur" min="1" max="120">
                                            <span class="input-group-text border-start-0"
                                                style="border-radius: 0 15px 15px 0;">tahun</span>
                                        </div>
                                        <div class="invalid-feedback" id="umur_error"></div>
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-venus-mars"></i>Jenis Kelamin
                                        </label>
                                        <div class="d-flex flex-row justify-content-center align-items-center gap-1 mt-3">
                                            <div class="form-check gender-option">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="jenis_kelamin_L" value="L"
                                                    {{ old('jenis_kelamin', $pengguna->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jenis_kelamin_L">
                                                    <div class="gender-card">
                                                        <i class="fas fa-mars"></i>
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
                                                        <i class="fas fa-venus"></i>
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
                                            <i class="fas fa-home"></i>Alamat
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text align-items-start pt-3">
                                                <i class="fas fa-home"></i>
                                            </span>
                                            <textarea class="form-control form-control-lg" id="alamat" name="alamat" rows="4"
                                                style="border-radius: 0 15px 15px 0 !important;"
                                                placeholder="Masukkan alamat lengkap">{{ old('alamat', $pengguna->alamat) }}</textarea>
                                        </div>
                                        <div class="invalid-feedback" id="alamat_error"></div>
                                    </div>

                                    <!-- PIN Baru -->
                                    <div class="form-group">
                                        <label for="pin" class="form-label">
                                            <i class="fas fa-lock"></i>PIN Baru (Opsional)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <input type="password" class="form-control form-control-lg" id="pin"
                                                name="pin" placeholder="Masukkan PIN baru (6 digit)" maxlength="6">
                                            <button class="btn toggle-pin" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>Kosongkan jika tidak ingin mengubah PIN
                                        </div>
                                        <div class="invalid-feedback" id="pin_error"></div>
                                    </div>

                                    <!-- Konfirmasi PIN -->
                                    <div class="form-group">
                                        <label for="confirm_pin" class="form-label">
                                            <i class="fas fa-lock"></i>Konfirmasi PIN Baru
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <input type="password" class="form-control form-control-lg" id="confirm_pin"
                                                name="confirm_pin" placeholder="Konfirmasi PIN baru" maxlength="6">
                                            <button class="btn toggle-pin" type="button">
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
                                                <i class="fas fa-baby"></i>Usia Kehamilan (Minggu)
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-baby"></i>
                                                </span>
                                                <input type="number" class="form-control form-control-lg"
                                                    id="usia_kehamilan" name="usia_kehamilan"
                                                    value="{{ old('usia_kehamilan', $pengguna->usia_kehamilan) }}"
                                                    placeholder="Masukkan usia kehamilan" min="1" max="45">
                                                <span class="input-group-text" style="border-radius: 0 15px 15px 0;">minggu</span>
                                            </div>
                                            <div class="invalid-feedback" id="usia_kehamilan_error"></div>
                                        </div>

                                        <!-- Hamil Anak Ke -->
                                        <div class="form-group">
                                            <label for="hamil_anak_ke" class="form-label">
                                                <i class="fas fa-baby-carriage"></i>Hamil Anak Ke
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-baby-carriage"></i>
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
                                                <i class="fas fa-children"></i>Jumlah Anak
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-children"></i>
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
                            <div class="row mt-2">
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
                    confirmButtonColor: '#0856C8',
                    cancelButtonColor: '#6c757d',
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
                saveBtn.classList.add('btn-loading');
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
                            confirmButtonText: 'OK',
                            timer: 2000,
                            timerProgressBar: true
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
                                    el.innerHTML =
                                        `<i class="fas fa-user-circle me-2"></i>Hi, ${data.data.nama_lengkap}!`;
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
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat menyimpan data',
                                icon: 'error',
                                confirmButtonColor: '#dc3545',
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
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'OK'
                    });
                } finally {
                    // Reset button state
                    saveBtn.classList.remove('btn-loading');
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
        });
    </script>
@endpush
