@extends('layouts.app')
@section('title', 'Dashboard - SI Besti')
@section('content')
    <div class="dashboard-container py-3" style="margin-bottom: 20px;">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg welcome-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column align-items-start">
                                <h3 class="fw-bold mb-2 welcome-text">
                                    <i class="fas fa-person-breastfeeding me-2"></i>Hi, {{ $pengguna->nama_lengkap }}!
                                </h3>
                                <p class="mb-0 date-text">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    {{ now()->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            <div class="text-end">
                                <button type="button"
                                    class="btn btn-logout btn-sm d-flex flex-row align-items-center justify-content-center"
                                    id="logoutBtn">
                                    <i class="fas fa-sign-out-alt me-1"></i>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Grid Section -->
        <div class="row g-4">
            <!-- Left Column: User Information & Charts -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <!-- User Information Card -->
                    <div class="col-12">
                        <div class="card border-0 shadow-lg info-card h-100">
                            <div class="card-header-custom">
                                <h5 class="mb-0">
                                    <i class="fas fa-id-card me-2"></i>Informasi Pribadi
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <table class="table table-borderless info-table">
                                            <tr>
                                                <td width="40%" class="text-muted">
                                                    <i class="fas fa-user me-2 icon-info"></i>Nama Lengkap
                                                </td>
                                                <td class="fw-semibold">{{ $pengguna->nama_lengkap }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <i class="fas fa-phone me-2 icon-info"></i>Nomor Telepon
                                                </td>
                                                <td class="fw-semibold">{{ $pengguna->nomor_telepon }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <i class="fas fa-birthday-cake me-2 icon-info"></i>Umur
                                                </td>
                                                <td class="fw-semibold">{{ $pengguna->umur }} tahun</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <i class="fas fa-venus-mars me-2 icon-info"></i>Jenis Kelamin
                                                </td>
                                                <td class="fw-semibold">
                                                    @if ($pengguna->jenis_kelamin == 'L')
                                                        Laki-laki
                                                    @else
                                                        Perempuan
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless info-table">
                                            <tr>
                                                <td width="40%" class="text-muted">
                                                    <i class="fas fa-home me-2 icon-info"></i>Alamat
                                                </td>
                                                <td class="fw-semibold">{{ $pengguna->alamat }}</td>
                                            </tr>
                                            @if ($pengguna->usia_kehamilan)
                                                <tr>
                                                    <td class="text-muted">
                                                        <i class="fas fa-baby me-2 icon-info"></i>Usia Kehamilan
                                                    </td>
                                                    <td class="fw-semibold">{{ $pengguna->usia_kehamilan }} minggu</td>
                                                </tr>
                                            @endif
                                            @if ($pengguna->hamil_anak_ke)
                                                <tr>
                                                    <td class="text-muted">
                                                        <i class="fas fa-baby-carriage me-2 icon-info"></i>Hamil Anak Ke
                                                    </td>
                                                    <td class="fw-semibold">{{ $pengguna->hamil_anak_ke }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-muted">
                                                    <i class="fas fa-children me-2 icon-info"></i>Jumlah Anak
                                                </td>
                                                <td class="fw-semibold">{{ $pengguna->jumlah_anak }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Charts Section -->
                    <div class="col-12">
                        <div class="row g-4">
                            <!-- Grafik Sleep Tracking -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-lg chart-card h-100">
                                    <div class="card-header-custom">
                                        <h5 class="mb-0">
                                            <i class="fas fa-chart-line me-2"></i>Grafik Sleep Tracking
                                        </h5>
                                    </div>
                                    <div class="card-body p-4">
                                        @if ($sleepTrackingData)
                                            <div class="chart-container" style="position: relative; height: 250px;">
                                                <canvas id="sleepTrackingChart"></canvas>
                                            </div>
                                        @else
                                            <div class="text-center py-5 empty-state">
                                                <div class="empty-icon mb-3">
                                                    <i class="fas fa-chart-line fa-3x"></i>
                                                </div>
                                                <p class="text-muted mb-3">Belum ada data sleep tracking.</p>
                                                <a href="{{ route('pengguna.sleep-tracking.index') }}"
                                                    class="btn btn-custom btn-sm">
                                                    <i class="fas fa-plus me-1"></i>Tambah Data
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Grafik Test Kualitas Tidur -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-lg chart-card h-100">
                                    <div class="card-header-custom">
                                        <h5 class="mb-0">
                                            <i class="fas fa-chart-bar me-2"></i>Grafik Test Kualitas Tidur
                                        </h5>
                                    </div>
                                    <div class="card-body p-4">
                                        @if ($qualityTestData)
                                            <div class="chart-container" style="position: relative; height: 200px;">
                                                <canvas id="qualityTestChart"></canvas>
                                            </div>
                                            <div class="mt-3">
                                                @if ($qualityTestData['has_last_test'])
                                                    <div class="text-center">
                                                        <small class="text-muted chart-info">
                                                            <i class="fas fa-info-circle me-1"></i>
                                                            Perbandingan: {{ $qualityTestData['first_date'] }} vs
                                                            {{ $qualityTestData['last_date'] }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <div class="alert alert-custom mb-0 py-2" role="alert">
                                                        <small>
                                                            <i class="fas fa-clock me-1"></i>
                                                            <strong>Status:</strong> Test hari pertama selesai
                                                            ({{ $qualityTestData['first_date'] }}).
                                                            Menunggu test hari terakhir.
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-center py-5 empty-state">
                                                <div class="empty-icon mb-3">
                                                    <i class="fas fa-chart-bar fa-3x"></i>
                                                </div>
                                                <p class="text-muted mb-3">Belum ada test kualitas tidur yang dimulai.</p>
                                                <a href="{{ route('pengguna.quality-test.index') }}"
                                                    class="btn btn-custom btn-sm">
                                                    <i class="fas fa-play me-1"></i>Mulai Test
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Column: Features -->
            <div class="col-lg-4">
                <div class="row g-4">
                    <!-- Sleep Tracking Feature -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card border-0 shadow-lg feature-card h-100">
                            <div class="card-body text-center d-flex flex-column p-4">
                                <div class="feature-icon-wrapper mb-3">
                                    <div class="feature-icon">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold mb-2">Sleep Tracking</h5>
                                <p class="card-text text-muted grow mb-4">Input dan tracking jam tidur sampai jam bangun
                                    Anda.</p>
                                <a href="{{ route('pengguna.sleep-tracking.index') }}" class="btn btn-feature mt-auto">
                                    <i class="fas fa-gear me-2"></i>Atur Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Test Kualitas Tidur Feature -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card border-0 shadow-lg feature-card h-100">
                            <div class="card-body text-center d-flex flex-column p-4">
                                <div class="feature-icon-wrapper mb-3">
                                    <div class="feature-icon">
                                        <i class="fas fa-file-signature"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold mb-2">Test Kualitas Tidur</h5>
                                <p class="card-text text-muted grow mb-4">Segera test kualitas tidur untuk mengetahui
                                    kualitas tidur Anda.</p>
                                <a href="{{ route('pengguna.quality-test.index') }}" class="btn btn-feature mt-auto">
                                    <i class="fas fa-comments me-2"></i>Mulai Test
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Murottal Al-Qur'an Feature -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card border-0 shadow-lg feature-card h-100">
                            <div class="card-body text-center d-flex flex-column p-4">
                                <div class="feature-icon-wrapper mb-3">
                                    <div class="feature-icon">
                                        <i class="fas fa-hands-praying"></i>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold mb-2">Murottal Al-Qur'an</h5>
                                <p class="card-text text-muted grow mb-4">Putar Murottal Al-Qur'an untuk menemani waktu
                                    tidur Anda.</p>
                                <a href="{{ route('pengguna.murottal') }}" class="btn btn-feature mt-auto">
                                    <i class="fas fa-play me-2"></i>Putar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            --gradient-danger: linear-gradient(135deg, #dc3545 0%, #e63946 100%);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e8f0fe 100%);
            font-family: 'Poppins', sans-serif;
        }

        /* Welcome Card */
        .welcome-card {
            background: var(--gradient-primary);
            border-radius: 20px !important;
            overflow: hidden;
            position: relative;
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

        .welcome-card .card-body {
            position: relative;
            z-index: 1;
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

        .avatar-circle {
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
            transition: all 0.3s ease;
        }

        .avatar-circle:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.3);
        }

        /* Logout Button */
        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 25px;
            padding: 0.4rem 1rem;
            font-size: 1.2rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            min-width: 100px;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
            color: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-logout:active {
            color: #ffffff;
            transform: translateY(0);
        }

        /* Info Card */
        .info-card {
            border-radius: 20px !important;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(8, 86, 200, 0.15) !important;
        }

        .card-header-custom {
            background: var(--gradient-primary);
            color: #ffffff;
            padding: 1.25rem 1.5rem;
            border-radius: 20px 20px 0 0 !important;
            font-weight: 600;
        }

        .info-table tr {
            border-bottom: 1px solid #f0f4f8;
            transition: background 0.2s ease;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table tr:hover {
            background: #f8fafc;
        }

        .info-table td {
            padding: 14px 8px;
            vertical-align: middle;
        }

        .icon-info {
            color: var(--blue-700);
            font-size: 1.1rem;
        }

        /* Chart Cards */
        .chart-card {
            border-radius: 20px !important;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(8, 86, 200, 0.15) !important;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: var(--gradient-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--blue-700);
        }

        .btn-custom {
            background: var(--gradient-primary);
            color: #ffffff;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.3);
            color: #ffffff;
        }

        .alert-custom {
            background: linear-gradient(135deg, #E8F0FE 0%, #ffffff 100%);
            border: 1px solid var(--blue-300);
            border-radius: 12px;
            color: var(--blue-900);
        }

        .chart-info {
            padding: 0.5rem 1rem;
            background: #f8fafc;
            border-radius: 8px;
            display: inline-block;
        }

        /* Feature Cards */
        .feature-card {
            border-radius: 20px !important;
            background: #ffffff;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
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

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(8, 86, 200, 0.2) !important;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon-wrapper {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            position: relative;
        }

        .feature-icon {
            width: 100px;
            height: 100px;
            background: var(--gradient-light);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--blue-700);
            transition: all 0.4s ease;
            position: relative;
        }

        .feature-card:hover .feature-icon {
            background: var(--gradient-primary);
            color: #ffffff;
            transform: rotateY(360deg) scale(1.1);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.3);
        }

        .feature-card .card-title {
            color: var(--blue-900);
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .feature-card:hover .card-title {
            color: var(--blue-700);
        }

        .btn-feature {
            background: transparent;
            color: var(--blue-700);
            border: 2px solid var(--blue-700);
            padding: 0.6rem 1.75rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-feature::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-feature:hover {
            color: #ffffff;
            border-color: var(--blue-900);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.3);
        }

        .btn-feature:hover::before {
            left: 0;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            width: 100%;
        }

        .chart-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }

        /* Dashboard Container */
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Card Shadows */
        .shadow-lg {
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-text {
                font-size: 1.4rem;
            }

            .avatar-circle {
                width: 60px;
                height: 60px;
                font-size: 1.4rem;
            }

            .btn-logout {
                min-width: 80px;
                height: 60px;
                padding: 0.3rem 0.8rem;
                font-size: 1rem;
            }

            .chart-container {
                height: 200px !important;
            }

            .feature-icon-wrapper,
            .feature-icon {
                width: 80px;
                height: 80px;
            }

            .feature-icon {
                font-size: 2rem;
            }

            .card-header-custom h5 {
                font-size: 1rem;
            }

            .info-table td {
                padding: 10px 5px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .welcome-card::before {
                width: 250px;
                height: 250px;
            }

            .card-body {
                padding: 1.25rem !important;
            }

            .btn-feature,
            .btn-custom {
                padding: 0.5rem 1.25rem;
                font-size: 0.875rem;
            }
        }

        @media (min-width: 992px) {
            .col-lg-8 {
                padding-right: 1rem;
            }

            .col-lg-4 {
                padding-left: 1rem;
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

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Smooth Transitions */
        * {
            transition: all 0.2s ease;
        }

        a,
        button {
            transition: all 0.3s ease !important;
        }
    </style>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @if ($sleepTrackingData || $qualityTestData)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endif

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tombol Logout dengan SweetAlert
            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        text: 'Apakah Anda yakin ingin logout?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#0856C8',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'swal2-popup-custom',
                            confirmButton: 'swal2-confirm-custom',
                            cancelButton: 'swal2-cancel-custom'
                        },
                        buttonsStyling: false,
                        reverseButtons: true,
                        backdrop: 'rgba(0, 0, 0, 0.4)'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form to submit the logout request
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('logout') }}';

                            // Add CSRF token
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            form.appendChild(csrfToken);

                            // Add to document and submit
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }

            // Grafik Sleep Tracking
            @if ($sleepTrackingData)
                const sleepTrackingCtx = document.getElementById('sleepTrackingChart');
                if (sleepTrackingCtx) {
                    const sleepTrackingChart = new Chart(sleepTrackingCtx, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($sleepTrackingData['dates']) !!},
                            datasets: [{
                                label: 'Durasi Tidur (Jam)',
                                data: {!! json_encode($sleepTrackingData['durations']) !!},
                                backgroundColor: 'rgba(8, 86, 200, 0.1)',
                                borderColor: 'rgba(8, 86, 200, 1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: 'rgba(8, 86, 200, 1)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgba(8, 86, 200, 1)',
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            label += context.parsed.y.toFixed(2) + ' jam';
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jam'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return value + ' jam';
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Tanggal'
                                    }
                                }
                            }
                        }
                    });
                }
            @endif
            // Grafik Test Kualitas Tidur
            @if ($qualityTestData)
                @php
                    $hasLastTest = $qualityTestData['has_last_test'];
                    $firstScore = $qualityTestData['first_score'];
                    $lastScore = $hasLastTest ? $qualityTestData['last_score'] : null;
                @endphp

                const qualityTestCtx = document.getElementById('qualityTestChart');
                if (qualityTestCtx) {
                    const qualityTestChart = new Chart(qualityTestCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Hari Pertama', 'Hari Terakhir'],
                            datasets: [{
                                label: 'Skor Kualitas Tidur',
                                data: [
                                    {{ $firstScore }},
                                    @if ($hasLastTest)
                                        {{ $lastScore }}
                                    @else
                                        null
                                    @endif
                                ],
                                backgroundColor: [
                                    {{ $firstScore }} <= 5 ? 'rgba(40, 167, 69, 0.7)' :
                                    'rgba(220, 53, 69, 0.7)',
                                    @if ($hasLastTest)
                                        {{ $lastScore }} <= 5 ? 'rgba(40, 167, 69, 0.7)' :
                                            'rgba(220, 53, 69, 0.7)'
                                    @else
                                        'rgba(108, 117, 125, 0.3)'
                                    @endif
                                ],
                                borderColor: [
                                    {{ $firstScore }} <= 5 ? 'rgba(40, 167, 69, 1)' :
                                    'rgba(220, 53, 69, 1)',
                                    @if ($hasLastTest)
                                        {{ $lastScore }} <= 5 ? 'rgba(40, 167, 69, 1)' :
                                            'rgba(220, 53, 69, 1)'
                                    @else
                                        'rgba(108, 117, 125, 0.5)'
                                    @endif
                                ],
                                borderWidth: 2,
                                borderDash: function(context) {
                                    @if (!$hasLastTest)
                                        if (context.dataIndex === 1) {
                                            return [5, 5];
                                        }
                                    @endif
                                    return [];
                                }
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }

                                            @if (!$hasLastTest)
                                                if (context.dataIndex === 1) {
                                                    return 'Menunggu test hari ke-7';
                                                }
                                            @endif

                                            if (context.parsed.y !== null) {
                                                label += context.parsed.y;
                                                label += ' (' + (context.parsed.y <= 5 ? 'Baik' :
                                                    'Buruk') + ')';
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 21,
                                    title: {
                                        display: true,
                                        text: 'Skor PSQI'
                                    },
                                    ticks: {
                                        stepSize: 3
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Periode Test'
                                    }
                                }
                            }
                        },
                        plugins: [{
                            @if (!$hasLastTest)
                                afterDraw: function(chart) {
                                    const ctx = chart.ctx;
                                    const xAxis = chart.scales.x;
                                    const yAxis = chart.scales.y;

                                    // Posisi untuk bar kedua (Hari Terakhir)
                                    const x = xAxis.getPixelForValue(1);
                                    const y = yAxis.getPixelForValue(10);

                                    ctx.save();
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';
                                    ctx.font = 'bold 14px Arial';
                                    ctx.fillStyle = 'rgba(108, 117, 125, 0.8)';
                                    ctx.fillText('Menunggu', x, y);
                                    ctx.font = '12px Arial';
                                    ctx.fillText('Test Hari Ke-7', x, y + 20);
                                    ctx.restore();
                                }
                            @endif
                        }]
                    });
                }
            @endif
        });

        // Custom styles for SweetAlert
        const style = document.createElement('style');
        style.textContent = `
            .swal2-popup-custom {
                border-radius: 20px !important;
                font-family: 'Poppins', sans-serif;
            }
            .swal2-confirm-custom {
                background: linear-gradient(135deg, #0856C8 0%, #2674E6 100%) !important;
                border: none !important;
                border-radius: 25px !important;
                padding: 0.5rem 2rem !important;
                font-weight: 500 !important;
                color: white;
                transition: all 0.3s ease !important;
                margin-left: 5px;
            }
            .swal2-confirm-custom:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 5px 15px rgba(8, 86, 200, 0.3) !important;
            }
            .swal2-cancel-custom {
                background: transparent !important;
                border: 2px solid #6c757d !important;
                color: #6c757d !important;
                border-radius: 25px !important;
                padding: 0.5rem 2rem !important;
                font-weight: 500 !important;
                transition: all 0.3s ease !important;
                margin-right: 5px;
            }
            .swal2-cancel-custom:hover {
                background: #f8f9fa !important;
                transform: translateY(-2px) !important;
            }
            .swal2-title {
                color: #0856C8 !important;
                font-weight: 600 !important;
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
