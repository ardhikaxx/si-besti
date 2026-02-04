@extends('layouts.app')

@section('title', 'Test PSQI - ' . ($type == 'first' ? 'Hari Pertama' : 'Hari Terakhir'))

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

        /* Back Button */
        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: #ffffff;
        }

        /* Progress Container */
        .progress-container {
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .progress-container .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .progress-container .text-primary {
            color: #ffffff !important;
        }

        .progress-container .progress {
            height: 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
        }

        .progress-container .progress-bar {
            background: linear-gradient(90deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);
        }

        /* Info Alert */
        .info-alert {
            background: var(--gradient-light);
            border-radius: 15px;
            border: none;
            padding: 20px;
            border-left: 5px solid var(--blue-600);
            box-shadow: 0 5px 15px rgba(8, 86, 200, 0.1);
        }

        .info-alert h6 {
            color: var(--blue-900);
            font-weight: 700;
        }

        .info-alert i {
            color: var(--blue-600);
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

        /* Info Box */
        .info-box {
            background: var(--gradient-light);
            padding: 15px 20px;
            border-radius: 12px;
            text-align: center;
            color: var(--blue-800);
            border: 2px solid var(--blue-200);
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

        .question-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .question-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .question-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .question-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .question-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .question-card:nth-child(6) {
            animation-delay: 0.6s;
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
    <div class="card border-0 header-card mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-start justify-content-lg-between mb-4 gap-3">
                <div>
                    <h2 class="mb-2 header-title">
                        <i class="fas fa-file-signature me-2"></i>Test Kualitas Tidur
                    </h2>
                    <p class="header-subtitle mb-1">
                        {{ $type == 'first' ? 'Test Pertama (Sebelum)' : 'Test Terakhir (Sesudah)' }} - Pittsburgh Sleep Quality Index (PSQI)
                    </p>
                    <p class="header-subtitle small mb-0">
                        <i class="fas fa-info-circle me-1"></i>Anda hanya mengisi Bagian 3-6
                    </p>
                </div>
                <div>
                    <a href="{{ route('pengguna.quality-test.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form id="psqiForm" action="{{ route('pengguna.quality-test.store', $type) }}" method="POST">
        @csrf

        <!-- Q6: Penggunaan obat -->
        <div class="card border-0 question-card">
            <div class="card-body">
                <h5 class="section-title">
                    <i class="fas fa-pills me-2"></i>Bagian 3: Penggunaan Obat Tidur
                </h5>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-capsules me-2"></i>6. Selama sebulan terakhir, berapa sering Anda menggunakan obat tidur?
                    </label>

                    <div class="row mt-3">
                        @php
                            $medicationOptions = [
                                0 => 'Tidak pernah',
                                1 => '1x seminggu',
                                2 => '2x seminggu',
                                3 => '≥3x seminggu',
                            ];
                        @endphp

                        @foreach ($medicationOptions as $value => $label)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="form-check card-option">
                                    <input class="form-check-input" type="radio" name="medication_use"
                                           id="medication{{ $value }}" value="{{ $value }}"
                                           {{ old('medication_use', $existingTest->medication_use ?? 0) == $value ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label w-100" for="medication{{ $value }}">
                                        <div class="card border option-card">
                                            <div class="fw-bold">{{ $label }}</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Q7: Kantuk siang hari -->
        <div class="card border-0 question-card">
            <div class="card-body">
                <h5 class="section-title">
                    <i class="fas fa-tired me-2"></i>Bagian 4: Kantuk Siang Hari
                </h5>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-battery-quarter me-2"></i>7. Selama sebulan terakhir, seberapa sering Anda mengantuk ketika melakukan aktivitas disiang hari?
                    </label>

                    <div class="row mt-3">
                        @php
                            $sleepinessOptions = [
                                0 => 'Tidak pernah',
                                1 => '1x seminggu',
                                2 => '2x seminggu',
                                3 => '≥3x seminggu',
                            ];
                        @endphp

                        @foreach ($sleepinessOptions as $value => $label)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="form-check card-option">
                                    <input class="form-check-input" type="radio" name="daytime_sleepiness"
                                           id="sleepiness{{ $value }}" value="{{ $value }}"
                                           {{ old('daytime_sleepiness', $existingTest->daytime_sleepiness ?? 0) == $value ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label w-100" for="sleepiness{{ $value }}">
                                        <div class="card border option-card">
                                            <div class="fw-bold">{{ $label }}</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Q8: Antusiasme -->
        <div class="card border-0 question-card">
            <div class="card-body">
                <h5 class="section-title">
                    <i class="fas fa-brain me-2"></i>Bagian 5: Antusiasme Menyelesaikan Masalah
                </h5>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-tasks me-2"></i>8. Selama satu bulan terakhir, berapa banyak masalah yang Anda dapatkan dan seberapa antusias Anda selesaikan permasalahan tersebut?
                    </label>

                    <div class="row mt-3">
                        @php
                            $enthusiasmOptions = [
                                0 => 'Tidak antusias',
                                1 => 'Kecil',
                                2 => 'Sedang',
                                3 => 'Besar',
                            ];
                        @endphp

                        @foreach ($enthusiasmOptions as $value => $label)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="form-check card-option">
                                    <input class="form-check-input" type="radio" name="enthusiasm"
                                           id="enthusiasm{{ $value }}" value="{{ $value }}"
                                           {{ old('enthusiasm', $existingTest->enthusiasm ?? 2) == $value ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label w-100" for="enthusiasm{{ $value }}">
                                        <div class="card border option-card">
                                            <div class="fw-bold">{{ $label }}</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Q9: Kepuasan tidur -->
        <div class="card border-0 question-card">
            <div class="card-body">
                <h5 class="section-title">
                    <i class="fas fa-smile me-2"></i>Bagian 6: Kepuasan Tidur
                </h5>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-star me-2"></i>9. Selama bulan terakhir, bagaimana Anda menilai kepuasan tidur Anda?
                    </label>

                    <div class="row mt-3">
                        @php
                            $satisfactionOptions = [
                                0 => 'Sangat Baik',
                                1 => 'Cukup Baik',
                                2 => 'Cukup Buruk',
                                3 => 'Sangat Buruk',
                            ];
                        @endphp

                        @foreach ($satisfactionOptions as $value => $label)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="form-check card-option">
                                    <input class="form-check-input" type="radio" name="sleep_satisfaction"
                                           id="satisfaction{{ $value }}" value="{{ $value }}"
                                           {{ old('sleep_satisfaction', $existingTest->sleep_satisfaction ?? 1) == $value ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label w-100" for="satisfaction{{ $value }}">
                                        <div class="card border option-card">
                                            <div class="fw-bold">{{ $label }}</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-action">
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="{{ route('pengguna.quality-test.index') }}" class="btn btn-secondary w-100 py-3">
                        <i class="fas fa-times me-2"></i>Batalkan
                    </a>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                        <i class="fas fa-paper-plane me-2"></i>Kirim untuk Diproses Admin
                    </button>
                </div>
            </div>
            <div class="info-box mt-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                Setelah dikirim, test akan diproses oleh admin untuk melengkapi bagian waktu tidur
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('psqiForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validation
            const radioGroups = [
                { name: 'medication_use', label: 'Penggunaan Obat Tidur' },
                { name: 'daytime_sleepiness', label: 'Kantuk Siang Hari' },
                { name: 'enthusiasm', label: 'Antusiasme' },
                { name: 'sleep_satisfaction', label: 'Kepuasan Tidur' }
            ];

            let isValid = true;
            const errors = [];

            radioGroups.forEach(group => {
                const radios = document.querySelectorAll(`input[name="${group.name}"]:checked`);
                if (radios.length === 0) {
                    isValid = false;
                    errors.push(group.label);
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pertanyaan Belum Lengkap',
                    html: `Harap lengkapi semua bagian:<br><br><strong>${errors.join('<br>')}</strong>`,
                    confirmButtonColor: '#0856C8',
                    confirmButtonText: 'OK, Saya Mengerti'
                });
                return false;
            }

            // Confirmation
            Swal.fire({
                title: 'Kirim Test?',
                html: `Test akan dikirim untuk diproses oleh admin.<br><br>
                       <small class="text-muted">Admin akan melengkapi informasi waktu tidur Anda.</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0856C8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Cek Lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengirim...',
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