@extends('layouts.app')

@section('title', 'Test Kualitas Tidur - PSQI')

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
            --gradient-warning: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            --gradient-danger: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            --gradient-info: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e8f0fe 100%);
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1400px;
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
            font-size: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
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
            overflow: hidden;
        }

        .progress-container .progress-bar {
            background: linear-gradient(90deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);
        }

        /* Badges */
        .badge {
            border-radius: 20px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .badge.bg-secondary {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .badge.bg-primary {
            background: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        /* Buttons */
        .btn-success {
            background: var(--gradient-success);
            border: none;
            padding: 10px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }

        .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
        }

        /* Alert Boxes */
        .alert {
            border-radius: 15px;
            border: none;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-primary {
            background: var(--gradient-light);
            border-left: 5px solid var(--blue-600);
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border-left: 5px solid #17a2b8;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 5px solid #28a745;
        }

        .alert h6 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .alert i {
            font-size: 2rem;
        }

        /* Test Cards */
        .test-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .test-card::before {
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

        .test-card.available {
            border-color: var(--blue-400);
            box-shadow: 0 15px 40px rgba(8, 86, 200, 0.2);
        }

        .test-card.available::before {
            transform: scaleX(1);
        }

        .test-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(8, 86, 200, 0.2);
        }

        .test-card:hover::before {
            transform: scaleX(1);
        }

        /* Test Card Header */
        .test-card-header {
            padding-bottom: 15px;
            border-bottom: 2px solid var(--blue-100);
            margin-bottom: 20px;
        }

        .test-card-title {
            color: var(--blue-900);
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .status-badge.completed {
            background: var(--gradient-success);
            color: white;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }

        .status-badge.available {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 10px rgba(8, 86, 200, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .status-badge.locked {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
        }

        .status-badge.waiting {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #6c757d;
            border: 2px solid #dee2e6;
        }

        /* Description Box */
        .description-box {
            background: var(--gradient-light);
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 4px solid var(--blue-600);
        }

        /* Action Buttons */
        .action-btn {
            border-radius: 25px;
            padding: 12px 28px;
            font-weight: 700;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.3s, height 0.3s;
        }

        .action-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-fill-test {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 16px 32px;
            font-size: 1.1rem;
        }

        .btn-fill-test:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(8, 86, 200, 0.4);
        }

        .btn-edit-test {
            background: var(--gradient-primary);
            color: white;
            border: none;
        }

        .btn-edit-test:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.4);
        }

        .btn-confirm-test {
            background: var(--gradient-success);
            color: white;
            border: none;
        }

        .btn-confirm-test:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }

        /* Status Icons */
        .status-icon-container {
            margin: 20px 0;
        }

        .status-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: var(--gradient-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .status-icon.success {
            background: var(--gradient-success);
            color: white;
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }

        .status-icon.warning {
            background: var(--gradient-warning);
            color: white;
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
        }

        .status-icon.locked {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
        }

        /* Score Display */
        .score-display {
            background: var(--gradient-light);
            padding: 20px;
            border-radius: 15px;
            margin: 15px 0;
            border: 2px solid var(--blue-300);
        }

        .score-display .badge {
            font-size: 1.2rem;
            padding: 10px 24px;
        }

        /* Info Card */
        .info-card {
            background: var(--gradient-light);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            border: 2px solid var(--blue-200);
        }

        .info-card h6 {
            color: var(--blue-900);
            font-weight: 700;
        }

        .info-card ul {
            padding-left: 20px;
        }

        .info-card ul li {
            margin-bottom: 8px;
            color: var(--blue-800);
        }

        .info-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid var(--blue-600);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-title {
                font-size: 1.5rem;
            }

            .test-card-title {
                font-size: 1.1rem;
            }

            .btn-fill-test {
                padding: 14px 24px;
                font-size: 1rem;
            }

            .status-icon {
                width: 60px;
                height: 60px;
                font-size: 2rem;
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

        .test-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .test-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .test-card:nth-child(2) {
            animation-delay: 0.2s;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="card border-0 header-card mb-4">
            <div class="card-body p-4">
                <div
                    class="d-flex flex-column flex-lg-row align-items-start justify-content-start align-items-lg-center justify-content-lg-between mb-4 gap-3">
                    <div>
                        <h2 class="mb-2 header-title">
                            <i class="fas fa-file-signature me-2"></i>Test Kualitas Tidur
                        </h2>
                        <p class="header-subtitle mb-0">Pittsburgh Sleep Quality Index (PSQI) - 2 Hari Test dalam 7 Hari</p>
                    </div>
                    <div class="d-flex align-items-center">
                        @if ($currentTest->status == 'completed')
                            <a href="{{ route('pengguna.quality-test.result', $currentTest->id) }}"
                                class="btn btn-success me-2">
                                <i class="fas fa-chart-bar me-1"></i>Lihat Hasil
                            </a>
                            <button class="btn btn-primary" onclick="startNewTest()">
                                <i class="fas fa-plus me-1"></i>Test Baru
                            </button>
                        @else
                            @php
                                $progress = $currentTest->getProgressPercentage();
                            @endphp
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <span class="badge bg-secondary px-3 py-2 w-auto">
                                    <i class="fas fa-clock me-1"></i>{{ $testInfo['message'] }}
                                </span>
                                <span class="badge bg-primary px-3 py-2 w-auto">
                                    <i class="fas fa-chart-line me-1"></i>{{ $progress }}% Selesai
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="progress-container">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-tasks me-2"></i>Progress Test</span>
                        <span class="text-primary fw-bold">
                            @php
                                $firstTest = $currentTest->firstTest;
                                $lastTest = $currentTest->lastTest;
                                $completed = 0;
                                if ($firstTest && $firstTest->is_confirmed) {
                                    $completed++;
                                }
                                if ($lastTest && $lastTest->is_confirmed) {
                                    $completed++;
                                }
                            @endphp
                            <i class="fas fa-check-circle me-1"></i>{{ $completed }}/2 test selesai
                        </span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"
                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="text-center mt-3 text-muted small">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <strong>Periode:</strong> {{ \Carbon\Carbon::parse($currentTest->start_date)->format('d M Y') }}
                        (Hari 1) -
                        {{ \Carbon\Carbon::parse($currentTest->end_date)->format('d M Y') }} (Hari 7)
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Info -->
        @if ($currentTest->status == 'ongoing')
            @if ($testInfo['status'] == 'first_pending')
                <div class="alert alert-primary mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-3"></i>
                        <div>
                            <h6 class="mb-1">Test Pertama Tersedia!</h6>
                            <p class="mb-0">Silakan isi test pertama hari ini. Test terakhir akan terkunci sampai hari
                                ke-7.</p>
                        </div>
                    </div>
                </div>
            @elseif($testInfo['status'] == 'first_unconfirmed')
                <div class="alert alert-primary mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3"></i>
                        <div>
                            <h6 class="mb-1">Test Pertama Belum Dikonfirmasi!</h6>
                            <p class="mb-0">Anda sudah mengisi test pertama. Silakan konfirmasi sebelum menunggu test
                                terakhir.</p>
                        </div>
                    </div>
                </div>
            @elseif($testInfo['status'] == 'waiting_for_last')
                <div class="alert alert-info mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-check me-3"></i>
                        <div>
                            <h6 class="mb-1">Menunggu Test Terakhir</h6>
                            <p class="mb-0">Test pertama sudah selesai. Test terakhir akan tersedia pada
                                <strong>{{ \Carbon\Carbon::parse($currentTest->end_date)->format('d M Y') }}</strong>
                                ({{ $testInfo['days_left'] ?? 0 }} hari lagi).
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($testInfo['status'] == 'last_available')
                <div class="alert alert-success mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3"></i>
                        <div>
                            <h6 class="mb-1">Test Terakhir Tersedia!</h6>
                            <p class="mb-0">Silakan isi test terakhir hari ini untuk melihat hasil perbandingan.</p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Test Cards -->
        <div class="row g-4 mb-4">
            @foreach ($weekDays as $day)
                @if ($day['is_test_day'])
                    <div class="col-12 col-md-6">
                        <div class="card test-card @if ($day['can_take_test']) available @endif">
                            <div class="card-body p-4">
                                <!-- Day Header -->
                                <div class="test-card-header">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div>
                                            <h5 class="test-card-title mb-1">
                                                <i
                                                    class="fas fa-{{ $day['day_type'] == 'first' ? 'play-circle' : 'flag-checkered' }} me-2"></i>
                                                {{ $day['day_type'] == 'first' ? 'Test Pertama' : 'Test Terakhir' }}
                                            </h5>
                                            <p class="text-muted small mb-1">
                                                <i class="fas fa-calendar-day me-1"></i>{{ $day['day_name'] }},
                                                {{ $day['date_formatted'] }}
                                            </p>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-chart-line me-1"></i>Hari ke-{{ $day['day_number'] }} dari
                                                7
                                            </p>
                                        </div>
                                        <div>
                                            @if ($day['is_confirmed'])
                                                <span class="status-badge completed">
                                                    <i class="fas fa-check-circle"></i>Selesai
                                                </span>
                                            @elseif($day['can_take_test'])
                                                <span class="status-badge available">
                                                    <i class="fas fa-star"></i>Tersedia
                                                </span>
                                            @elseif($day['is_future'] || !$day['is_available'])
                                                <span class="status-badge locked">
                                                    <i class="fas fa-lock"></i>Terkunci
                                                </span>
                                            @else
                                                <span class="status-badge waiting">
                                                    <i class="fas fa-clock"></i>Menunggu
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="description-box">
                                    @if ($day['day_type'] == 'first')
                                        <p class="mb-2"><i class="fas fa-info-circle me-2"
                                                style="color: var(--blue-600);"></i>
                                            Test awal untuk menilai kualitas tidur Anda sebelum intervensi.
                                        </p>
                                        <p class="mb-0 small text-muted"><i class="fas fa-clock me-2"></i><strong>Batas
                                                waktu:</strong> Dapat diisi mulai hari ini</p>
                                    @else
                                        <p class="mb-2"><i class="fas fa-info-circle me-2"
                                                style="color: var(--blue-600);"></i>
                                            Test akhir untuk menilai perubahan kualitas tidur setelah 7 hari.
                                        </p>
                                        <p class="mb-0 small text-muted"><i class="fas fa-clock me-2"></i><strong>Batas
                                                waktu:</strong> Hanya dapat diisi pada hari ke-7</p>
                                    @endif
                                </div>

                                <!-- Status & Actions -->
                                <div class="text-center">
                                    @if ($day['has_test'])
                                        @if ($day['is_confirmed'])
                                            <div class="status-icon-container">
                                                <div class="status-icon success">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                                <div class="mt-3">
                                                    <span class="fw-bold" style="color: var(--blue-900);">Test Sudah
                                                        Terkonfirmasi</span>
                                                </div>
                                            </div>
                                            @if ($day['test']->total_score !== null)
                                                <div class="score-display">
                                                    <div class="mb-2">
                                                        <span class="badge bg-{{ $day['test']->getQualityColor() }}">
                                                            <i class="fas fa-star me-2"></i>Skor:
                                                            {{ $day['test']->total_score }}
                                                        </span>
                                                    </div>
                                                    <div class="small" style="color: var(--blue-700);">
                                                        Kualitas Tidur Anda: <strong
                                                            class="text-{{ $day['test']->getQualityColor() }}">
                                                            {{ $day['test']->getQualityLevel() }}
                                                        </strong>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="status-icon-container">
                                                <div class="status-icon warning">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </div>
                                                <div class="mt-3 mb-3">
                                                    <span class="fw-bold" style="color: var(--blue-900);">Belum
                                                        Dikonfirmasi</span>
                                                </div>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('pengguna.quality-test.edit', $day['day_type']) }}"
                                                    class="btn btn-edit-test action-btn">
                                                    <i class="fas fa-edit"></i>Edit Test
                                                </a>
                                                <form
                                                    action="{{ route('pengguna.quality-test.confirm', $day['day_type']) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-confirm-test action-btn w-100">
                                                        <i class="fas fa-check"></i>Konfirmasi Test
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @else
                                        @if ($day['can_take_test'])
                                            <a href="{{ route('pengguna.quality-test.show', $day['day_type']) }}"
                                                class="btn btn-fill-test action-btn w-100">
                                                <i class="fas fa-file-signature"></i>
                                                Isi Test {{ $day['day_type'] == 'first' ? 'Pertama' : 'Terakhir' }}
                                            </a>
                                        @elseif($day['is_future'] || !$day['is_available'])
                                            <div class="status-icon-container">
                                                <div class="status-icon locked">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                                <div class="mt-3">
                                                    <p class="text-muted mb-0">
                                                        @if ($day['day_type'] == 'last')
                                                            @if ($day['lock_reason'])
                                                                {{ $day['lock_reason'] }}
                                                            @else
                                                                Test akan tersedia pada hari ke-7<br>
                                                                ({{ $day['date_formatted'] }})
                                                            @endif
                                                        @else
                                                            Test telah lewat batas waktu
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <button class="btn btn-outline-secondary action-btn w-100" disabled>
                                                <i class="fas fa-ban"></i>Tidak Tersedia
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Info Card -->
        <div class="card border-0 info-card">
            <div class="card-body p-4">
                <h6 class="mb-3">
                    <i class="fas fa-info-circle me-2"></i>Informasi Test PSQI
                </h6>
                <p class="mb-3" style="color: var(--blue-800);">
                    Test Pittsburgh Sleep Quality Index (PSQI) mengukur kualitas tidur Anda selama sebulan terakhir melalui
                    7 komponen:
                </p>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <ul class="mb-0">
                            <li>Kualitas tidur subyektif</li>
                            <li>Latensi tidur</li>
                            <li>Durasi tidur</li>
                            <li>Efisiensi tidur</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="mb-0">
                            <li>Gangguan tidur</li>
                            <li>Penggunaan obat tidur</li>
                            <li>Disfungsi siang hari</li>
                        </ul>
                    </div>
                </div>

                <div class="info-box">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-lightbulb me-3" style="color: var(--blue-600); font-size: 1.5rem;"></i>
                        <div>
                            <strong style="color: var(--blue-900);">Interpretasi Skor:</strong>
                            <ul class="mb-0 mt-2">
                                <li><strong>Skor ≤ 5:</strong> Kualitas tidur Baik</li>
                                <li><strong>Skor > 5:</strong> Kualitas tidur Buruk</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function startNewTest() {
            Swal.fire({
                title: 'Mulai Test Baru?',
                text: 'Test yang sedang berjalan akan dihentikan. Apakah Anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0856C8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Mulai Baru!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route('pengguna.quality-test.start-new') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Test baru berhasil dimulai',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Terjadi kesalahan.',
                                    confirmButtonColor: '#0856C8'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal memulai test baru',
                                confirmButtonColor: '#0856C8'
                            });
                        });
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
