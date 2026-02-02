@extends('layouts.admin')
@section('title', 'Profil Admin')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div
            class="d-flex flex-column flex-lg-row justify-content-start justify-content-lg-between align-items-start align-items-lg-center mb-4 gap-2 gap-lg-0">
            <div>
                <h1 class="h3 mb-0 fw-bold" style="color: var(--primary);">Profil Admin</h1>
                <p class="text-muted mb-0">Kelola informasi profil Anda</p>
            </div>
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-pill">
                    <i class="fas fa-user-shield me-1"></i> Hak Akses: Administrator
                </span>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Left Column: Profile Card -->
            <div class="col-lg-4 mb-4">
                <!-- Main Profile Card -->
                <div class="card card-custom shadow-sm border-0 overflow-hidden h-auto">
                    <!-- Profile Header Background -->
                    <div class="profile-header-bg position-relative"
                        style="height: 120px; background: linear-gradient(135deg, #0856C8 0%, #0A47A3 100%);">
                        <div class="position-absolute w-100 h-100"
                            style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1440 320%22><path fill=%22%23ffffff%22 fill-opacity=%220.1%22 d=%22M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z%22></path></svg>') no-repeat center bottom; background-size: cover; opacity: 0.3;">
                        </div>
                    </div>

                    <div class="card-body text-center position-relative" style="margin-top: -50px;">
                        <!-- Profile Image -->
                        <div class="position-relative d-inline-block mb-3">
                            <div class="avatar-wrapper">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->nama_lengkap) }}&background=0856C8&color=fff&size=256&font-size=0.4&bold=true"
                                    alt="Admin Avatar" class="avatar-xl border-4 border-white shadow-lg"
                                    style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
                            </div>
                        </div>

                        <!-- Admin Info -->
                        <h4 class="fw-bold mb-1">{{ $admin->nama_lengkap }}</h4>
                        <p class="text-muted mb-3">
                            <i class="fas fa-user-tie me-1"></i> Administrator Sistem
                        </p>

                        <div class="d-flex justify-content-center gap-2 mb-4 flex-wrap">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i> Terverifikasi
                            </span>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Aktif
                            </span>
                        </div>

                        <!-- Quick Actions -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg shadow-sm" onclick="showEditForm()">
                                <i class="fas fa-edit me-2"></i> Edit Profil
                            </button>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                <i class="fas fa-key me-2"></i> Ubah Kata Sandi
                            </button>
                            <form id="profile-logout-form" action="{{ route('admin.logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                            <button type="button" class="btn btn-outline-danger w-100" onclick="logoutAdmin(event)">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="col-lg-8">
                <!-- Personal Information Card -->
                <div class="card card-custom shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                                <i class="fas fa-user-circle fs-5"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fw-bold">Informasi Pribadi</h5>
                                <small class="text-muted">Kelola data pribadi Anda</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div id="viewProfile">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-user text-primary me-1"></i> Nama Lengkap
                                    </label>
                                    <div class="form-control-modern bg-light">
                                        {{ $admin->nama_lengkap }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-envelope text-primary me-1"></i> Email
                                    </label>
                                    <div class="form-control-modern bg-light">
                                        {{ $admin->email }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-phone text-primary me-1"></i> Telepon
                                    </label>
                                    <div class="form-control-modern bg-light">
                                        {{ $admin->nomor_telepon }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar text-primary me-1"></i> Bergabung Sejak
                                    </label>
                                    <div class="form-control-modern bg-light">
                                        {{ $admin->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button onclick="showEditForm()" class="btn btn-primary px-4">
                                    <i class="fas fa-edit me-2"></i> Edit Profil
                                </button>
                            </div>
                        </div>

                        <form id="editProfileForm" method="POST" action="{{ route('admin.profile.update') }}"
                            class="d-none">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label fw-semibold">
                                        <i class="fas fa-user text-primary me-1"></i> Nama Lengkap
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-modern @error('nama_lengkap') is-invalid @enderror"
                                        id="nama_lengkap" name="nama_lengkap"
                                        value="{{ old('nama_lengkap', $admin->nama_lengkap) }}" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope text-primary me-1"></i> Email
                                    </label>
                                    <input type="email"
                                        class="form-control form-control-modern @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $admin->email) }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nomor_telepon" class="form-label fw-semibold">
                                        <i class="fas fa-phone text-primary me-1"></i> Telepon
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-modern @error('nomor_telepon') is-invalid @enderror"
                                        id="nomor_telepon" name="nomor_telepon"
                                        value="{{ old('nomor_telepon', $admin->nomor_telepon) }}" required>
                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" onclick="cancelEdit()" class="btn btn-secondary px-4">
                                    <i class="fas fa-times me-2"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary text-white border-0">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="fas fa-key me-2"></i> Ubah Kata Sandi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="changePasswordForm">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <div class="alert alert-info border-0 bg-info bg-opacity-10 d-flex align-items-center"
                                role="alert">
                                <i class="fas fa-info-circle fs-5 text-info me-3"></i>
                                <div class="text-info small">
                                    Pastikan password baru Anda kuat dengan kombinasi huruf, angka, dan karakter khusus.
                                </div>
                            </div>
                        </div>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">
                                <i class="fas fa-lock text-primary me-1"></i> Password Saat Ini
                            </label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control form-control-modern @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password"
                                    placeholder="Masukkan password saat ini" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-danger small mt-1" id="current_password_error"></div>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">
                                <i class="fas fa-key text-primary me-1"></i> Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control form-control-modern @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" placeholder="Minimal 8 karakter" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-danger small mt-1" id="new_password_error"></div>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" id="passwordStrengthBar" role="progressbar"
                                        style="width: 0%"></div>
                                </div>
                                <small class="text-muted d-block mt-1" id="passwordStrengthText">Kekuatan password</small>
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-key text-primary me-1"></i> Konfirmasi Password Baru
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-modern"
                                    id="new_password_confirmation" name="new_password_confirmation"
                                    placeholder="Ketik ulang password baru" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="text-danger small mt-1" id="new_password_confirmation_error"></div>
                            <div class="mt-2">
                                <small class="text-muted" id="passwordMatchText"></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light rounded-bottom-3">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary px-4" id="submitPasswordBtn">
                            <i class="fas fa-save me-2"></i> Simpan Password
                            <span class="spinner-border spinner-border-sm d-none" id="passwordSpinner"
                                role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary: #0856C8;
            --primary-dark: #0A47A3;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
        }

        /* Card Styling */
        .card-custom {
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-2px);
        }

        /* Avatar Styling */
        .avatar-xl {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        /* Icon Box */
        .icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
        }

        .icon-sm {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Form Modern */
        .form-control-modern {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-control-modern:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(8, 86, 200, 0.1);
            background-color: #fff;
        }

        .form-control-modern.bg-light {
            background-color: #f8f9fa;
            min-height: 48px;
            display: flex;
            align-items: center;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            border-color: var(--primary) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        /* Button Improvements */
        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(8, 86, 200, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
        }

        /* Badge Improvements */
        .badge {
            font-weight: 500;
            padding: 6px 12px;
        }

        /* Alert */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 16px;
            overflow: hidden;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        }

        /* Progress Bar */
        .progress {
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .timeline-item-modern {
                padding-left: 50px;
            }

            .timeline-marker-modern {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .timeline-item-modern:not(:last-child)::before {
                left: 16.5px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-custom {
            animation: fadeIn 0.5s ease;
        }
    </style>

    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Initialize password functionality
            initPasswordModal();
        });

        function showEditForm() {
            document.getElementById('viewProfile').classList.add('d-none');
            document.getElementById('editProfileForm').classList.remove('d-none');
        }

        function cancelEdit() {
            document.getElementById('viewProfile').classList.remove('d-none');
            document.getElementById('editProfileForm').classList.add('d-none');

            // Reset form values
            document.getElementById('editProfileForm').reset();
        }

        // Handle form submission with SweetAlert confirmation
        document.getElementById('editProfileForm')?.addEventListener('submit', function(e) {
            const form = this;
            const formData = new FormData(form);
            const changes = [];

            // Check for actual changes
            if (formData.get('nama_lengkap') !== '{{ $admin->nama_lengkap }}') {
                changes.push(`Nama: {{ $admin->nama_lengkap }} → ${formData.get('nama_lengkap')}`);
            }
            if (formData.get('email') !== '{{ $admin->email }}') {
                changes.push(`Email: {{ $admin->email }} → ${formData.get('email')}`);
            }
            if (formData.get('nomor_telepon') !== '{{ $admin->nomor_telepon }}') {
                changes.push(`Telepon: {{ $admin->nomor_telepon }} → ${formData.get('nomor_telepon')}`);
            }

            if (changes.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak Ada Perubahan',
                    text: 'Tidak ada perubahan data yang dilakukan.',
                    confirmButtonColor: '#0856C8'
                });
                e.preventDefault();
                cancelEdit();
                return;
            }

            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Update Profil',
                html: `<div class="text-start">
                        <p>Anda akan mengubah data profil dengan detail berikut:</p>
                        <ul class="mt-2 mb-3">${changes.map(change => `<li>${change}</li>`).join('')}</ul>
                        <p class="text-muted small">Pastikan data yang dimasukkan sudah benar.</p>
                       </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0856C8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Update Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Password Modal Functionality
        function initPasswordModal() {
            // Toggle password visibility
            const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
            const toggleNewPassword = document.getElementById('toggleNewPassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

            toggleCurrentPassword?.addEventListener('click', function() {
                togglePasswordVisibility('current_password', this);
            });

            toggleNewPassword?.addEventListener('click', function() {
                togglePasswordVisibility('new_password', this);
            });

            toggleConfirmPassword?.addEventListener('click', function() {
                togglePasswordVisibility('new_password_confirmation', this);
            });

            // Check password match
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');
            const passwordMatchText = document.getElementById('passwordMatchText');

            newPasswordInput?.addEventListener('input', function() {
                checkPasswordMatch();
                checkPasswordStrength(this.value);
            });

            confirmPasswordInput?.addEventListener('input', checkPasswordMatch);

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                const bar = document.getElementById('passwordStrengthBar');
                const text = document.getElementById('passwordStrengthText');

                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;

                let barColor = '#dc3545';
                let strengthText = 'Lemah';

                switch (strength) {
                    case 2:
                        barColor = '#ffc107';
                        strengthText = 'Cukup';
                        break;
                    case 3:
                        barColor = '#28a745';
                        strengthText = 'Baik';
                        break;
                    case 4:
                        barColor = '#20c997';
                        strengthText = 'Sangat Baik';
                        break;
                }

                bar.style.width = (strength * 25) + '%';
                bar.style.backgroundColor = barColor;
                text.textContent = `Kekuatan password: ${strengthText}`;
                text.className = 'd-block mt-1 ' +
                    (strength >= 3 ? 'text-success' : strength === 2 ? 'text-warning' : 'text-danger');
            }

            function checkPasswordMatch() {
                const password = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (confirmPassword === '') {
                    passwordMatchText.textContent = '';
                    passwordMatchText.className = 'text-muted';
                    return;
                }

                if (password === confirmPassword) {
                    passwordMatchText.textContent = '✓ Password cocok';
                    passwordMatchText.className = 'text-success fw-semibold';
                } else {
                    passwordMatchText.textContent = '✗ Password tidak cocok';
                    passwordMatchText.className = 'text-danger fw-semibold';
                }
            }

            function togglePasswordVisibility(inputId, button) {
                const input = document.getElementById(inputId);
                const icon = button.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }

            // Handle form submission
            const changePasswordForm = document.getElementById('changePasswordForm');
            const submitBtn = document.getElementById('submitPasswordBtn');
            const spinner = document.getElementById('passwordSpinner');

            changePasswordForm?.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                clearPasswordErrors();

                // Show loading
                submitBtn.disabled = true;
                spinner.classList.remove('d-none');

                // Collect form data
                const formData = new FormData(this);

                // AJAX request
                fetch('{{ route('admin.password.update.modal') }}', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Success - show SweetAlert and close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'changePasswordModal'));
                            modal.hide();

                            Swal.fire({
                                icon: data.swal.icon,
                                title: data.swal.title,
                                text: data.swal.text,
                                confirmButtonColor: '#0856C8',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Reset form
                                changePasswordForm.reset();
                                // Reset progress bar
                                document.getElementById('passwordStrengthBar').style.width = '0%';
                                document.getElementById('passwordStrengthText').textContent =
                                    'Kekuatan password';
                                document.getElementById('passwordStrengthText').className =
                                    'text-muted d-block mt-1';
                                document.getElementById('passwordMatchText').textContent = '';
                            });
                        } else {
                            // Validation errors
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    const errorElement = document.getElementById(`${field}_error`);
                                    if (errorElement) {
                                        errorElement.textContent = data.errors[field][0];
                                    }
                                });
                            }

                            // Show error SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat mengubah password.',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                            confirmButtonColor: '#dc3545'
                        });
                    })
                    .finally(() => {
                        // Reset button state
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');
                    });
            });

            // Clear errors when modal is hidden
            const modalElement = document.getElementById('changePasswordModal');
            modalElement.addEventListener('hidden.bs.modal', function() {
                clearPasswordErrors();
                changePasswordForm.reset();
                document.getElementById('passwordStrengthBar').style.width = '0%';
                document.getElementById('passwordStrengthText').textContent = 'Kekuatan password';
                document.getElementById('passwordStrengthText').className = 'text-muted d-block mt-1';
                document.getElementById('passwordMatchText').textContent = '';
            });
        }

        function clearPasswordErrors() {
            const errorElements = document.querySelectorAll('[id$="_error"]');
            errorElements.forEach(element => {
                element.textContent = '';
            });
        }

        // Logout function
        function logoutAdmin(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin logout dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0856C8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('profile-logout-form').submit();
                }
            });
        }
    </script>
@endsection
