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
            color: white;
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
                    <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                        <a href="{{ route('pengguna.quality-test.result') }}" class="btn btn-success me-2">
                            <i class="fas fa-chart-bar me-1"></i>Semua Hasil
                        </a>
                        <span class="status-badge text-white">
                            <i
                                class="fas fa-{{ $testStatus['color'] == 'info' ? 'cog' : ($testStatus['color'] == 'success' ? 'check' : 'clock') }} me-1"></i>
                            {{ $testStatus['message'] }}
                        </span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="progress-container">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted"><i class="fas fa-tasks me-2"></i>Progress Test</span>
                        <span class="text-primary fw-bold">
                            <i class="fas fa-check-circle me-1"></i>{{ $progress }}% selesai
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
        @if ($testStatus['status'] == 'waiting_admin' || $testStatus['status'] == 'waiting_admin_last')
            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-cog me-3 fa-2x"></i>
                    <div>
                        <h6 class="mb-1">Sedang Diproses Admin</h6>
                        <p class="mb-0">Test Anda telah disimpan dan sedang diproses oleh admin.
                            Admin akan mengisi bagian informasi waktu tidur dan gangguan tidur.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Test Cards -->
        <div class="row g-4 mb-4">
            <!-- Test Pertama -->
            <div class="col-12 col-md-6">
                <div class="card test-card @if ($currentTest->canUserTakeTest('first')) available @endif">
                    <div class="card-body p-4">
                        <!-- Day Header -->
                        <div class="test-card-header">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h5 class="test-card-title mb-1">
                                        <i class="fas fa-play-circle me-2"></i>
                                        Test Pertama
                                    </h5>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-calendar-day me-1"></i>
                                        {{ \Carbon\Carbon::parse($currentTest->start_date)->format('l, d M Y') }}
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-chart-line me-1"></i>Hari ke-1 dari 7
                                    </p>
                                </div>
                                <div>
                                    @if ($firstTest)
                                        @if ($firstTest->filled_by_admin)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Selesai
                                            </span>
                                        @elseif($firstTest->is_confirmed)
                                            <span class="badge bg-info">
                                                <i class="fas fa-cog"></i> Diproses Admin
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> Menunggu
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-clock"></i> Belum Dimulai
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="description-box">
                            <p class="mb-2"><i class="fas fa-info-circle me-2" style="color: var(--blue-600);"></i>
                                Test awal untuk menilai kualitas tidur Anda sebelum intervensi.
                            </p>
                            <p class="mb-0 small text-muted"><i class="fas fa-user me-2"></i>
                                <strong>Anda mengisi:</strong> Bagian 3-6 (Penggunaan Obat hingga Kepuasan Tidur)
                            </p>
                            <p class="mb-0 small text-muted"><i class="fas fa-user-cog me-2"></i>
                                <strong>Admin mengisi:</strong> Bagian 1-2 (Informasi Waktu Tidur dan Gangguan)
                            </p>
                        </div>

                        <!-- Status & Actions -->
                        <div class="text-center mt-4">
                            @if ($firstTest)
                                @if ($firstTest->filled_by_admin)
                                    <div class="status-icon-container">
                                        <div class="status-icon success">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="mt-3">
                                            <span class="fw-bold" style="color: var(--blue-900);">Test Selesai</span>
                                        </div>
                                    </div>
                                    @if ($firstTest->total_score !== null)
                                        <div class="score-display">
                                            <div class="mb-2">
                                                <span class="badge bg-{{ $firstTest->getQualityColor() }}">
                                                    <i class="fas fa-star me-2"></i>Skor: {{ $firstTest->total_score }}
                                                </span>
                                            </div>
                                            <div class="small" style="color: var(--blue-700);">
                                                Kualitas Tidur Anda: <strong
                                                    class="text-{{ $firstTest->getQualityColor() }}">
                                                    {{ $firstTest->getQualityLevel() }}
                                                </strong>
                                            </div>
                                        </div>
                                    @endif
                                @elseif($firstTest->is_confirmed)
                                    <div class="status-icon-container">
                                        <div class="status-icon info">
                                            <i class="fas fa-cog fa-spin"></i>
                                        </div>
                                        <div class="mt-3 mb-3">
                                            <span class="fw-bold" style="color: var(--blue-900);">Sedang Diproses
                                                Admin</span>
                                            <p class="text-muted small mb-0">
                                                Admin akan mengisi bagian informasi waktu tidur
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('pengguna.quality-test.show', 'first') }}"
                                        class="btn btn-fill-test action-btn w-100">
                                        <i class="fas fa-file-signature"></i>
                                        Isi Test Pertama
                                    </a>
                                @endif
                            @else
                                @if ($currentTest->canUserTakeTest('first'))
                                    <a href="{{ route('pengguna.quality-test.show', 'first') }}"
                                        class="btn btn-fill-test action-btn w-100">
                                        <i class="fas fa-file-signature"></i>
                                        Isi Test Pertama
                                    </a>
                                @else
                                    <div class="status-icon-container">
                                        <div class="status-icon locked">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <div class="mt-3">
                                            <p class="text-muted mb-0">
                                                Test akan tersedia sesuai jadwal
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Terakhir -->
            <div class="col-12 col-md-6">
                <div class="card test-card @if ($currentTest->canUserTakeTest('last')) available @endif">
                    <div class="card-body p-4">
                        <!-- Day Header -->
                        <div class="test-card-header">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h5 class="test-card-title mb-1">
                                        <i class="fas fa-flag-checkered me-2"></i>
                                        Test Terakhir
                                    </h5>
                                    <p class="text-muted small mb-1">
                                        <i class="fas fa-calendar-day me-1"></i>
                                        {{ \Carbon\Carbon::parse($currentTest->end_date)->format('l, d M Y') }}
                                    </p>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-chart-line me-1"></i>Hari ke-7 dari 7
                                    </p>
                                </div>
                                <div>
                                    @if ($lastTest)
                                        @if ($lastTest->filled_by_admin)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Selesai
                                            </span>
                                        @elseif($lastTest->is_confirmed)
                                            <span class="badge bg-info">
                                                <i class="fas fa-cog"></i> Diproses Admin
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> Menunggu
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-lock"></i> Terkunci
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="description-box">
                            <p class="mb-2"><i class="fas fa-info-circle me-2" style="color: var(--blue-600);"></i>
                                Test akhir untuk menilai perubahan kualitas tidur setelah 7 hari.
                            </p>
                            <p class="mb-0 small text-muted"><i class="fas fa-user me-2"></i>
                                <strong>Anda mengisi:</strong> Bagian 3-6 (Penggunaan Obat hingga Kepuasan Tidur)
                            </p>
                            <p class="mb-0 small text-muted"><i class="fas fa-user-cog me-2"></i>
                                <strong>Admin mengisi:</strong> Bagian 1-2 (Informasi Waktu Tidur dan Gangguan)
                            </p>
                            @if (!$firstTest || !$firstTest->filled_by_admin)
                                <p class="mb-0 small text-danger mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Test pertama harus selesai dulu
                                </p>
                            @endif
                        </div>

                        <!-- Status & Actions -->
                        <div class="text-center mt-4">
                            @if ($lastTest)
                                @if ($lastTest->filled_by_admin)
                                    <div class="status-icon-container">
                                        <div class="status-icon success">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="mt-3">
                                            <span class="fw-bold" style="color: var(--blue-900);">Test Selesai</span>
                                        </div>
                                    </div>
                                    @if ($lastTest->total_score !== null)
                                        <div class="score-display">
                                            <div class="mb-2">
                                                <span class="badge bg-{{ $lastTest->getQualityColor() }}">
                                                    <i class="fas fa-star me-2"></i>Skor: {{ $lastTest->total_score }}
                                                </span>
                                            </div>
                                            <div class="small" style="color: var(--blue-700);">
                                                Kualitas Tidur Anda: <strong
                                                    class="text-{{ $lastTest->getQualityColor() }}">
                                                    {{ $lastTest->getQualityLevel() }}
                                                </strong>
                                            </div>
                                        </div>
                                    @endif
                                @elseif($lastTest->is_confirmed)
                                    <div class="status-icon-container">
                                        <div class="status-icon info">
                                            <i class="fas fa-cog fa-spin"></i>
                                        </div>
                                        <div class="mt-3 mb-3">
                                            <span class="fw-bold" style="color: var(--blue-900);">Sedang Diproses
                                                Admin</span>
                                            <p class="text-muted small mb-0">
                                                Admin akan mengisi bagian informasi waktu tidur
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('pengguna.quality-test.show', 'last') }}"
                                        class="btn btn-fill-test action-btn w-100">
                                        <i class="fas fa-file-signature"></i>
                                        Isi Test Terakhir
                                    </a>
                                @endif
                            @else
                                @if ($currentTest->canUserTakeTest('last'))
                                    <a href="{{ route('pengguna.quality-test.show', 'last') }}"
                                        class="btn btn-fill-test action-btn w-100">
                                        <i class="fas fa-file-signature"></i>
                                        Isi Test Terakhir
                                    </a>
                                @else
                                    <div class="status-icon-container">
                                        <div class="status-icon locked">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                        <div class="mt-3">
                                            <p class="text-muted mb-0">
                                                @if (!$firstTest || !$firstTest->filled_by_admin)
                                                    Test pertama harus selesai dulu
                                                @else
                                                    Test akan tersedia pada hari ke-7
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card border-0 info-card">
            <div class="card-body p-4">
                <h6 class="mb-3">
                    <i class="fas fa-info-circle me-2"></i>Informasi Test PSQI
                </h6>
                <p class="mb-3" style="color: var(--blue-800);">
                    Test Pittsburgh Sleep Quality Index (PSQI) mengukur kualitas tidur Anda melalui 7 komponen:
                </p>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold" style="color: var(--blue-700);">
                                <i class="fas fa-user me-2"></i>Bagian yang Anda Isi:
                            </h6>
                            <ul class="mb-0">
                                <li><strong>Bagian 3:</strong> Penggunaan Obat Tidur</li>
                                <li><strong>Bagian 4:</strong> Kantuk Siang Hari</li>
                                <li><strong>Bagian 5:</strong> Antusiasme Menyelesaikan Masalah</li>
                                <li><strong>Bagian 6:</strong> Kepuasan Tidur</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="fw-bold" style="color: var(--blue-700);">
                                <i class="fas fa-user-cog me-2"></i>Bagian yang Diisi Admin:
                            </h6>
                            <ul class="mb-0">
                                <li><strong>Bagian 1:</strong> Informasi Waktu Tidur</li>
                                <li><strong>Bagian 2:</strong> Gangguan Tidur</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="info-box">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-lightbulb me-3" style="color: var(--blue-600); font-size: 1.5rem;"></i>
                        <div>
                            <strong style="color: var(--blue-900);">Proses Test:</strong>
                            <ul class="mb-0 mt-2">
                                <li>1. Anda mengisi bagian 3-6 dan submit</li>
                                <li>2. Status berubah menjadi "Sedang diproses admin"</li>
                                <li>3. Admin mengisi bagian 1-2</li>
                                <li>4. Hasil lengkap akan tersedia</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
