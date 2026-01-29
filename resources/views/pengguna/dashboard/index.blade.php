@extends('layouts.app')

@section('title', 'Dashboard - SI Besti')

@section('content')
    <div class="dashboard-container py-3" style="margin-bottom: 20px;">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, var(--blue-100), var(--blue-200));">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column align-items-start">
                                <h3 class="fw-bold mb-2" style="color: var(--blue-900);">
                                    <i class="fas fa-person-breastfeeding me-2"></i>Hi, {{ $pengguna->nama_lengkap }}!
                                </h3>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    {{ now()->translatedFormat('l, d F Y') }}
                                </p>
                            </div>

                            <div class="text-end">
                                <div class="avatar-circle bg-primary text-white">
                                    <i class="fas fa-user"></i>
                                </div>
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
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-id-card me-2"></i>Informasi Pribadi
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%" class="text-muted"><i class="fas fa-user me-2"></i>Nama Lengkap
                                                </td>
                                                <td class="fw-bold">{{ $pengguna->nama_lengkap }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i class="fas fa-phone me-2"></i>Nomor Telepon</td>
                                                <td class="fw-bold">{{ $pengguna->nomor_telepon }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i class="fas fa-birthday-cake me-2"></i>Umur</td>
                                                <td class="fw-bold">{{ $pengguna->umur }} tahun</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted"><i class="fas fa-venus-mars me-2"></i>Jenis Kelamin</td>
                                                <td class="fw-bold">
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
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%" class="text-muted"><i class="fas fa-home me-2"></i>Alamat</td>
                                                <td class="fw-bold">{{ $pengguna->alamat }}</td>
                                            </tr>
                                            @if ($pengguna->usia_kehamilan)
                                                <tr>
                                                    <td class="text-muted"><i class="fas fa-baby me-2"></i>Usia Kehamilan</td>
                                                    <td class="fw-bold">{{ $pengguna->usia_kehamilan }} minggu</td>
                                                </tr>
                                            @endif
                                            @if ($pengguna->hamil_anak_ke)
                                                <tr>
                                                    <td class="text-muted"><i class="fas fa-baby-carriage me-2"></i>Hamil Anak Ke
                                                    </td>
                                                    <td class="fw-bold">{{ $pengguna->hamil_anak_ke }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="text-muted"><i class="fas fa-children me-2"></i>Jumlah Anak</td>
                                                <td class="fw-bold">{{ $pengguna->jumlah_anak }}</td>
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
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-chart-line me-2"></i>Grafik Sleep Tracking
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if($sleepTrackingData)
                                            <div class="chart-container" style="position: relative; height: 250px;">
                                                <canvas id="sleepTrackingChart"></canvas>
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Belum ada data sleep tracking.</p>
                                                <a href="{{ route('pengguna.sleep-tracking.index') }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus me-1"></i>Tambah Data
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik Test Kualitas Tidur -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-chart-bar me-2"></i>Grafik Test Kualitas Tidur
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if($qualityTestData)
                                            <div class="chart-container" style="position: relative; height: 200px;">
                                                <canvas id="qualityTestChart"></canvas>
                                            </div>
                                            <div class="mt-3">
                                                @if($qualityTestData['has_last_test'])
                                                    <div class="text-center">
                                                        <small class="text-muted">
                                                            <i class="fas fa-info-circle me-1"></i>
                                                            Perbandingan: {{ $qualityTestData['first_date'] }} vs {{ $qualityTestData['last_date'] }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info mb-0 py-2" role="alert">
                                                        <small>
                                                            <i class="fas fa-clock me-1"></i>
                                                            <strong>Status:</strong> Test hari pertama selesai ({{ $qualityTestData['first_date'] }}). 
                                                            Menunggu test hari terakhir.
                                                            <a href="{{ route('pengguna.quality-test.index') }}" class="alert-link ms-1">
                                                                <i class="fas fa-arrow-right"></i>Detail
                                                            </a>
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Belum ada test kualitas tidur yang dimulai.</p>
                                                <a href="{{ route('pengguna.quality-test.index') }}" class="btn btn-sm btn-primary">
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
                        <div class="card border-0 shadow-sm h-100 hover-lift feature-card">
                            <div class="card-body text-center d-flex flex-column">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-bed text-primary fa-3x"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-2">Sleep Tracking</h5>
                                <p class="card-text text-muted grow">Input dan tracking jam tidur sampai jam bangun Anda.</p>
                                <a href="{{ route('pengguna.sleep-tracking.index') }}" class="btn btn-outline-primary btn-sm mt-auto">
                                    <i class="fas fa-gear me-2"></i>Atur Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Test Kualitas Tidur Feature -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100 hover-lift feature-card">
                            <div class="card-body text-center d-flex flex-column">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-file-signature text-primary fa-3x"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-2">Test Kualitas Tidur</h5>
                                <p class="card-text text-muted grow">Segera test kualitas tidur untuk mengetahui kualitas tidur Anda.
                                </p>
                                <a href="{{ route('pengguna.quality-test.index') }}" class="btn btn-outline-primary btn-sm mt-auto">
                                    <i class="fas fa-comments me-2"></i>Mulai Test
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Murottal Al-Qur'an Feature -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card border-0 shadow-sm h-100 hover-lift feature-card">
                            <div class="card-body text-center d-flex flex-column">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-hands-praying text-primary fa-3x"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-2">Murottal Al-Qur'an</h5>
                                <p class="card-text text-muted grow">Putar Murottal Al-Qur'an untuk menemani waktu tidur Anda.</p>
                                <a href="{{ route('pengguna.murottal') }}" class="btn btn-outline-primary btn-sm mt-auto">
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
        }

        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .avatar-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--blue-700), var(--blue-900));
        }

        .feature-icon {
            transition: transform 0.3s ease;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.15) !important;
        }

        .hover-lift:hover .feature-icon {
            transform: scale(1.1);
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        .table-borderless td {
            padding: 10px 0;
        }

        .badge {
            padding: 5px 12px;
            font-size: 0.9rem;
        }

        .list-group-item {
            border: none;
            padding: 12px 0;
        }

        .btn-outline-primary {
            border-width: 2px;
            font-weight: 500;
        }

        .chart-container {
            position: relative;
            width: 100%;
        }

        .chart-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }

        .feature-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .feature-card .card-body {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .feature-card .btn {
            margin-top: auto;
        }

        /* Responsive Grid Improvements */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .avatar-circle {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            h1.h3 {
                font-size: 1.5rem;
            }
            
            .chart-container {
                height: 200px !important;
            }

            .feature-card {
                margin-bottom: 1rem;
            }

            .table-borderless td {
                padding: 8px 0;
                font-size: 0.9rem;
            }

            .card-header h5 {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .col-md-6 {
                margin-bottom: 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .feature-icon i {
                font-size: 2.5rem !important;
            }
            
            .btn-outline-primary {
                padding: 0.25rem 0.5rem;
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

        /* Ensure content doesn't overlap with floating nav */
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>

    @if($sleepTrackingData || $qualityTestData)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Grafik Sleep Tracking
                @if($sleepTrackingData)
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
                @if($qualityTestData)
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
                                        @if($hasLastTest)
                                            {{ $lastScore }}
                                        @else
                                            null
                                        @endif
                                    ],
                                    backgroundColor: [
                                        {{ $firstScore }} <= 5 ? 'rgba(40, 167, 69, 0.7)' : 'rgba(220, 53, 69, 0.7)',
                                        @if($hasLastTest)
                                            {{ $lastScore }} <= 5 ? 'rgba(40, 167, 69, 0.7)' : 'rgba(220, 53, 69, 0.7)'
                                        @else
                                            'rgba(108, 117, 125, 0.3)'
                                        @endif
                                    ],
                                    borderColor: [
                                        {{ $firstScore }} <= 5 ? 'rgba(40, 167, 69, 1)' : 'rgba(220, 53, 69, 1)',
                                        @if($hasLastTest)
                                            {{ $lastScore }} <= 5 ? 'rgba(40, 167, 69, 1)' : 'rgba(220, 53, 69, 1)'
                                        @else
                                            'rgba(108, 117, 125, 0.5)'
                                        @endif
                                    ],
                                    borderWidth: 2,
                                    borderDash: function(context) {
                                        @if(!$hasLastTest)
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
                                                
                                                @if(!$hasLastTest)
                                                if (context.dataIndex === 1) {
                                                    return 'Menunggu test hari ke-7';
                                                }
                                                @endif
                                                
                                                if (context.parsed.y !== null) {
                                                    label += context.parsed.y;
                                                    label += ' (' + (context.parsed.y <= 5 ? 'Baik' : 'Buruk') + ')';
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
                                @if(!$hasLastTest)
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
        </script>
    @endif
@endsection