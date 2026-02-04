<!-- resources/views/admins/hasil-test/test-admin.blade.php -->
@extends('layouts.admin')

@section('title', 'Isi Bagian Admin - ' . ($type == 'first' ? 'Test Pertama' : 'Test Terakhir'))

@push('styles')
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
            --gradient-danger: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e8f0fe 100%);
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1200px;
        }

        /* Header Card */
        .header-card {
            background: var(--gradient-primary);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(8, 86, 200, 0.2);
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .header-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header-card .card-body {
            position: relative;
            z-index: 1;
        }

        .header-title {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.8rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        /* User Info */
        .user-info-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* Test Status */
        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .status-ongoing {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        /* Question Cards */
        .question-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            margin-bottom: 25px;
        }

        .question-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(8, 86, 200, 0.15);
            border-color: var(--blue-200);
        }

        .question-card .card-body {
            padding: 30px;
        }

        .section-title {
            color: var(--blue-900);
            font-weight: 700;
            font-size: 1.2rem;
            border-left: 5px solid var(--blue-600);
            padding-left: 15px;
            margin-bottom: 25px;
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: var(--blue-900);
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid var(--blue-200);
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 4px rgba(58, 125, 228, 0.15);
            outline: none;
        }

        .input-group-text {
            background: var(--gradient-light);
            border: 2px solid var(--blue-200);
            border-left: none;
            color: var(--blue-900);
            font-weight: 600;
        }

        .form-text {
            color: var(--blue-600);
            font-size: 0.85rem;
            margin-top: 8px;
        }

        /* Option Cards */
        .card-option {
            margin-bottom: 0;
        }

        .card-option .form-check-input {
            display: none;
        }

        .option-card {
            background: var(--gradient-light);
            border: 3px solid var(--blue-200) !important;
            border-radius: 15px;
            padding: 18px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .option-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .option-card:hover {
            border-color: var(--blue-400) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.2);
        }

        .card-option .form-check-input:checked+label .option-card {
            background: var(--gradient-primary);
            color: #ffffff;
            border-color: var(--blue-700) !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.3);
        }

        .card-option .form-check-input:checked+label .option-card::before {
            transform: scaleX(1);
        }

        .option-card .fw-bold {
            font-size: 1rem;
        }

        /* Table Styling */
        .table-responsive {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(8, 86, 200, 0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--gradient-primary);
            color: #ffffff;
            font-weight: 700;
            border: none;
            padding: 15px;
            text-align: center;
            font-size: 0.9rem;
        }

        .table thead th:first-child {
            text-align: left;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid var(--blue-100);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table-hover tbody tr:hover {
            background: var(--blue-100);
            transform: scale(1.01);
        }

        .table tbody td.fw-bold {
            color: var(--blue-900);
            font-weight: 600;
        }

        /* Radio Buttons in Table */
        .form-check {
            margin: 0;
        }

        .disturbance-radio {
            width: 22px;
            height: 22px;
            border: 2px solid var(--blue-300);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .disturbance-radio:checked {
            background-color: var(--blue-700);
            border-color: var(--blue-700);
            box-shadow: 0 0 0 4px rgba(8, 86, 200, 0.2);
        }

        .disturbance-radio:hover {
            border-color: var(--blue-500);
            transform: scale(1.1);
        }

        .disturbance-radio:focus {
            box-shadow: 0 0 0 4px rgba(8, 86, 200, 0.25);
        }

        /* Action Buttons */
        .form-action {
            padding: 30px 0 50px;
            margin-top: 30px;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border: none;
            padding: 15px 32px;
            border-radius: 25px;
            font-weight: 700;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
            color: #ffffff;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 15px 32px;
            border-radius: 25px;
            font-weight: 700;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.4);
            color: #ffffff;
        }

        /* Confirmation Checkbox */
        .confirm-checkbox {
            padding: 15px;
            border-radius: 15px;
            border: 2px solid var(--blue-200);
            transition: all 0.3s ease;
        }

        .confirm-checkbox:hover {
            border-color: var(--blue-400);
            background: var(--blue-100);
        }

        .form-check-input:checked~.confirm-checkbox {
            background: rgba(40, 167, 69, 0.1);
            border-color: #28a745;
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

        .question-card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-title {
                font-size: 1.4rem;
            }

            .question-card .card-body {
                padding: 20px;
            }

            .section-title {
                font-size: 1.1rem;
            }

            .table thead th {
                font-size: 0.75rem;
                padding: 10px 5px;
            }

            .table tbody td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }

            .option-card {
                padding: 15px;
            }
        }

        /* Error Highlight */
        .error-highlight {
            animation: shake 0.5s;
            border-color: var(--danger) !important;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.25) !important;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-10px);
            }

            75% {
                transform: translateX(10px);
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="card border-0 header-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="mb-2 header-title">
                            <i class="fas fa-user-cog me-2"></i>Isi Bagian Admin
                        </h2>
                        <p class="header-subtitle mb-1">
                            {{ $type == 'first' ? 'Test Pertama' : 'Test Terakhir' }} - PSQI
                        </p>
                        <p class="header-subtitle small mb-0">
                            <i class="fas fa-info-circle me-1"></i>Anda mengisi Bagian 1-2 (Informasi Waktu Tidur & Gangguan)
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('admin.test-quality.detail', $sleepTest->pengguna_id) }}" class="btn btn-light"
                            style="background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3);">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- User Info -->
                <div class="user-info-card">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    {{ substr($sleepTest->pengguna->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold">{{ $sleepTest->pengguna->nama_lengkap }}</h5>
                                    <p class="mb-0 text-muted">{{ $sleepTest->pengguna->nomor_telepon }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <div class="me-4">
                                    <small class="text-muted d-block">Status Test</small>
                                    <span class="badge bg-info">
                                        Menunggu Bagian Admin
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Bagian User Sudah Diisi</small>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Bagian 3-6
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form id="adminForm" action="{{ route('admin.test-quality.store', ['test' => $sleepTest->id, 'type' => $type]) }}"
            method="POST">
            @csrf

            <!-- Bagian 1: Informasi Waktu Tidur -->
            <div class="card border-0 question-card">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="fas fa-moon me-2"></i>Bagian 1: Informasi Waktu Tidur
                    </h5>

                    <div class="row g-4">
                        <!-- Q1: Waktu mulai tidur -->
                        <div class="col-md-6">
                            <label for="bedtime" class="form-label">
                                <i class="fas fa-clock me-2"></i>1. Pukul berapa biasanya Anda mulai tidur malam?
                            </label>
                            <input type="time" class="form-control" id="bedtime" name="bedtime"
                                value="{{ old('bedtime', $dailyTest->bedtime ?? '22:00') }}" required>
                            <div class="form-text">Jam ketika mulai mencoba tidur</div>
                        </div>

                        <!-- Q2: Waktu untuk tertidur -->
                        <div class="col-md-6">
                            <label for="time_to_sleep" class="form-label">
                                <i class="fas fa-hourglass-half me-2"></i>2. Berapa lama Anda biasanya baru bisa tertidur
                                tiap malam?
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="time_to_sleep" name="time_to_sleep"
                                    min="0" max="300" step="1"
                                    value="{{ old('time_to_sleep', $dailyTest->time_to_sleep ?? 15) }}" required>
                                <span class="input-group-text">menit</span>
                            </div>
                            <div class="form-text">Waktu dari berbaring sampai tertidur</div>
                        </div>

                        <!-- Q3: Waktu bangun -->
                        <div class="col-md-6">
                            <label for="wakeup_time" class="form-label">
                                <i class="fas fa-sun me-2"></i>3. Pukul berapa Anda biasanya bangun pagi?
                            </label>
                            <input type="time" class="form-control" id="wakeup_time" name="wakeup_time"
                                value="{{ old('wakeup_time', $dailyTest->wakeup_time ?? '06:00') }}" required>
                            <div class="form-text">Jam bangun utama di pagi hari</div>
                        </div>

                        <!-- Q4: Durasi tidur -->
                        <div class="col-md-6">
                            <label for="sleep_duration" class="form-label">
                                <i class="fas fa-bed me-2"></i>4. Berapa lama Anda tidur di malam hari? (Jam)
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="sleep_duration" name="sleep_duration"
                                    min="0" max="24" step="0.1"
                                    value="{{ old('sleep_duration', $dailyTest->sleep_duration ?? 8) }}" required>
                                <span class="input-group-text">jam</span>
                            </div>
                            <div class="form-text">Total waktu tidur aktual dalam jam</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Q5: Gangguan Tidur -->
            <div class="card border-0 question-card">
                <div class="card-body">
                    <h5 class="section-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>Bagian 2: Gangguan Tidur
                    </h5>
                    <p class="text-muted mb-4">5. Seberapa sering masalah di bawah ini mengganggu tidur Anda dalam sebulan
                        terakhir?</p>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Masalah</th>
                                    <th class="text-center">Tidak pernah<br><small>(0)</small></th>
                                    <th class="text-center">1x seminggu<br><small>(1)</small></th>
                                    <th class="text-center">2x seminggu<br><small>(2)</small></th>
                                    <th class="text-center">≥3x seminggu<br><small>(3)</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $disturbances = [
                                        'a' => 'a. Tidak mampu tertidur selama 30 menit sejak berbaring',
                                        'b' => 'b. Terbangun ditengah malam atau dini hari',
                                        'c' => 'c. Terbangun untuk kekamar mandi',
                                        'd' => 'd. Sulit bernafas dengan baik',
                                        'e' => 'e. Batuk atau mengorok',
                                        'f' => 'f. Kedinginan dimalam hari',
                                        'g' => 'g. Kepanasan di malam hari',
                                        'h' => 'h. Mimpi buruk',
                                        'i' => 'i. Terasa nyeri',
                                        'j' => 'j. Alasan lain...',
                                    ];

                                    $oldDisturbances = old('sleep_disturbances', $dailyTest->sleep_disturbances ?? []);
                                @endphp

                                @foreach ($disturbances as $key => $label)
                                    <tr>
                                        <td class="fw-bold">{{ $label }}</td>
                                        @for ($i = 0; $i <= 3; $i++)
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input disturbance-radio" type="radio"
                                                        name="sleep_disturbances[{{ $key }}]"
                                                        id="dist{{ $key }}_{{ $i }}"
                                                        value="{{ $i }}"
                                                        {{ isset($oldDisturbances[$key]) && $oldDisturbances[$key] == $i ? 'checked' : '' }}
                                                        required>
                                                </div>
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-action">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('admin.test-quality.detail', $sleepTest->pengguna_id) }}"
                            class="btn btn-secondary w-100 py-3">
                            <i class="fas fa-times me-2"></i>Batalkan
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="fas fa-save me-2"></i>Simpan Bagian Admin
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('adminForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validation
                let isValid = true;
                const errors = [];

                // Check required inputs
                const requiredInputs = [{
                        id: 'bedtime',
                        label: 'Waktu Mulai Tidur'
                    },
                    {
                        id: 'time_to_sleep',
                        label: 'Waktu Untuk Tertidur'
                    },
                    {
                        id: 'wakeup_time',
                        label: 'Waktu Bangun'
                    },
                    {
                        id: 'sleep_duration',
                        label: 'Durasi Tidur'
                    }
                ];

                requiredInputs.forEach(input => {
                    const element = document.getElementById(input.id);
                    if (!element.value) {
                        isValid = false;
                        errors.push(input.label);
                        element.classList.add('error-highlight');
                        setTimeout(() => element.classList.remove('error-highlight'), 3000);
                    }
                });

                // Check disturbance radios
                for (let i = 'a'.charCodeAt(0); i <= 'j'.charCodeAt(0); i++) {
                    const key = String.fromCharCode(i);
                    const radios = document.querySelectorAll(
                        `input[name="sleep_disturbances[${key}]"]:checked`);
                    if (radios.length === 0) {
                        if (errors.indexOf('Gangguan Tidur') === -1) {
                            errors.push('Gangguan Tidur');
                        }
                        isValid = false;
                    }
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        html: `Harap lengkapi semua bagian:<br><br><strong>${errors.join('<br>')}</strong>`,
                        confirmButtonColor: '#0856C8',
                        confirmButtonText: 'OK, Saya Mengerti'
                    });
                    return false;
                }

                // Confirmation
                Swal.fire({
                    title: 'Simpan Bagian Admin?',
                    html: `Bagian admin akan disimpan dan skor akan dihitung.<br><br>
                       <small class="text-muted">Setelah ini, pengguna dapat mengisi test berikutnya.</small>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0856C8',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Cek Lagi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
