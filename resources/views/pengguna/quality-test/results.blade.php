{{-- resources/views/pengguna/quality-test/results.blade.php --}}
@extends('layouts.app')

@section('title', 'Semua Hasil Tes Kualitas Tidur - PSQI')

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

        /* Result Card */
        .result-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .result-card::before {
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

        .result-card:hover::before {
            transform: scaleX(1);
        }

        .result-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(8, 86, 200, 0.2);
        }

        /* Test Period Header */
        .test-period-header {
            background: var(--gradient-light);
            border-radius: 20px 20px 0 0;
            padding: 20px;
            border-bottom: 2px solid var(--blue-200);
        }

        .test-period {
            color: var(--blue-900);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .date-badge {
            background: var(--gradient-primary);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Score Display */
        .score-display {
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 100%;
        }

        .score-before-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-color: #dee2e6;
        }

        .score-after-card {
            background: linear-gradient(135deg, #e8f0fe 0%, #c6dafc 100%);
            border-color: var(--blue-300);
        }

        .score-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 10px 0;
            line-height: 1;
        }

        .score-before-value {
            color: #6c757d;
        }

        .score-after-value {
            color: var(--blue-900);
        }

        .score-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Quality Badge */
        .quality-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1rem;
            margin: 10px 0;
        }

        .quality-badge-good {
            background: var(--gradient-success);
            color: white;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }

        .quality-badge-poor {
            background: var(--gradient-danger);
            color: white;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        /* Improvement Display */
        .improvement-display {
            background: var(--gradient-light);
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            border: 2px solid var(--blue-200);
        }

        .improvement-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--blue-900);
        }

        .improvement-label {
            font-size: 0.8rem;
            color: var(--blue-600);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .improvement-positive {
            color: #28a745;
        }

        .improvement-negative {
            color: #dc3545;
        }

        .improvement-neutral {
            color: #6c757d;
        }

        /* Action Buttons */
        .action-btn {
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-view-details {
            background: var(--gradient-primary);
            color: white;
            border: none;
            text-align: center;
        }

        .btn-view-details:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.4);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--blue-300);
            margin-bottom: 20px;
        }

        .empty-state-title {
            color: var(--blue-900);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .empty-state-text {
            color: var(--blue-700);
            margin-bottom: 30px;
        }

        /* Filter Section */
        .filter-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            border: 2px solid var(--blue-200);
            margin-bottom: 20px;
            padding: 20px;
        }

        .filter-title {
            color: var(--blue-900);
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .filter-badge {
            background: var(--gradient-light);
            border: 2px solid var(--blue-200);
            color: var(--blue-800);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-badge:hover {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--blue-500);
        }

        .filter-badge.active {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--blue-500);
        }

        /* Stats Card */
        .stats-card {
            width: auto;
            height: 135px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            border: 2px solid var(--blue-200);
            padding: 20px;
            margin-bottom: 20px;
        }

        .stats-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--blue-900);
        }

        .stats-label {
            font-size: 0.9rem;
            color: var(--blue-600);
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-title {
                font-size: 1.5rem;
            }

            .score-value {
                font-size: 2rem;
            }

            .improvement-value {
                font-size: 1.5rem;
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

        .result-card {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="card border-0 header-card mb-4">
            <div class="card-body p-4">
                <div
                    class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-start justify-content-lg-between mb-4 gap-3">
                    <div>
                        <h2 class="mb-2 header-title">
                            <i class="fas fa-chart-bar me-2"></i>Semua Hasil Tes Kualitas Tidur
                        </h2>
                        <p class="header-subtitle mb-0">Riwayat dan Perbandingan Semua Test PSQI yang Telah Dilakukan</p>
                    </div>
                    <div>
                        <a href="{{ route('pengguna.quality-test.index') }}" class="btn btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Test
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row mb-4">
            <div class="col-md-3 col-6">
                <div class="stats-card text-center">
                    <div class="stats-value">{{ $completedTests->count() }}</div>
                    <div class="stats-label">Total Test</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center">
                    <div class="stats-value">
                        {{ $completedTests->where('total_score_before', '<=', 5)->count() }}
                    </div>
                    <div class="stats-label">Kualitas Awal Baik</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center">
                    <div class="stats-value">
                        {{ $completedTests->where('total_score_after', '<=', 5)->count() }}
                    </div>
                    <div class="stats-label">Kualitas Akhir Baik</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card text-center">
                    @php
                        $improved = $completedTests
                            ->filter(function ($test) {
                                return $test->total_score_after < $test->total_score_before;
                            })
                            ->count();
                    @endphp
                    <div class="stats-value">{{ $improved }}</div>
                    <div class="stats-label">Test Membaik</div>
                </div>
            </div>
        </div>

        @if ($completedTests->count() > 0)
            <!-- Results List -->
            @foreach ($completedTests as $test)
                <div class="result-card">
                    <!-- Test Period Header -->
                    <div class="test-period-header">
                        <div
                            class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
                            <div>
                                <h5 class="test-period mb-2 mb-lg-0">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Periode Test #{{ $loop->iteration }}
                                    <span class="badge bg-primary ms-2">
                                        {{ \Carbon\Carbon::parse($test->created_at)->format('d M Y') }}
                                    </span>
                                </h5>
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-info-circle me-1"></i>
                                    ID Test: {{ $test->id }} | Status:
                                    <span class="badge bg-success">Selesai</span>
                                </p>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="date-badge">
                                    <i class="fas fa-play-circle me-1"></i>Hari 1:
                                    {{ \Carbon\Carbon::parse($test->start_date)->format('d M') }}
                                </span>
                                <span class="date-badge">
                                    <i class="fas fa-flag-checkered me-1"></i>Hari 7:
                                    {{ \Carbon\Carbon::parse($test->end_date)->format('d M') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="p-4">
                        <div class="row align-items-center">
                            <!-- Before Score -->
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="score-display score-before-card">
                                    <div class="score-label">Sebelum Intervensi</div>
                                    <div class="score-value score-before-value">
                                        {{ $test->total_score_before ?? 'N/A' }}
                                    </div>
                                    @if ($test->firstTest && $test->firstTest->total_score !== null)
                                        <div class="mb-2">
                                            <span
                                                class="quality-badge quality-badge-{{ $test->firstTest->total_score <= 5 ? 'good' : 'poor' }}">
                                                <i
                                                    class="fas fa-{{ $test->firstTest->total_score <= 5 ? 'smile' : 'frown' }} me-1"></i>
                                                {{ $test->firstTest->total_score <= 5 ? 'Kualitas Baik' : 'Kualitas Buruk' }}
                                            </span>
                                        </div>
                                    @endif
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-calendar-day me-1"></i>Hari Pertama
                                    </p>
                                </div>
                            </div>

                            <!-- Improvement -->
                            <div class="col-md-2 mb-3 mb-md-0">
                                <div class="improvement-display">
                                    @if ($test->total_score_before !== null && $test->total_score_after !== null)
                                        @php
                                            $improvement = $test->total_score_after - $test->total_score_before;
                                        @endphp
                                        <div
                                            class="improvement-value {{ $improvement < 0 ? 'improvement-positive' : ($improvement > 0 ? 'improvement-negative' : 'improvement-neutral') }}">
                                            {{ $improvement < 0 ? '▼' : ($improvement > 0 ? '▲' : '—') }}
                                            {{ abs($improvement) }}
                                        </div>
                                        <div class="improvement-label">Perubahan</div>
                                    @else
                                        <div class="improvement-value improvement-neutral">—</div>
                                        <div class="improvement-label">Data Tidak Lengkap</div>
                                    @endif
                                </div>
                            </div>

                            <!-- After Score -->
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="score-display score-after-card">
                                    <div class="score-label">Setelah Intervensi</div>
                                    <div class="score-value score-after-value">
                                        {{ $test->total_score_after ?? 'N/A' }}
                                    </div>
                                    @if ($test->lastTest && $test->lastTest->total_score !== null)
                                        <div class="mb-2">
                                            <span
                                                class="quality-badge quality-badge-{{ $test->lastTest->total_score <= 5 ? 'good' : 'poor' }}">
                                                <i
                                                    class="fas fa-{{ $test->lastTest->total_score <= 5 ? 'smile' : 'frown' }} me-1"></i>
                                                {{ $test->lastTest->total_score <= 5 ? 'Kualitas Baik' : 'Kualitas Buruk' }}
                                            </span>
                                        </div>
                                    @endif
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-calendar-day me-1"></i>Hari Terakhir
                                    </p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="col-md-2">
                                <div class="d-grid">
                                    <a href="{{ route('pengguna.quality-test.result-detail', $test->id) }}"
                                        class="btn btn-view-details action-btn text-center">
                                        <i class="fas fa-eye me-2"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Summary -->
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2" style="color: var(--blue-700);">
                                            <i class="fas fa-clock me-1"></i>Waktu Tertidur:
                                        </span>
                                        <span class="fw-bold">
                                            @if ($test->firstTest && $test->lastTest)
                                                {{ $test->firstTest->time_to_sleep }}m →
                                                {{ $test->lastTest->time_to_sleep }}m
                                                @php
                                                    $change =
                                                        $test->lastTest->time_to_sleep -
                                                        $test->firstTest->time_to_sleep;
                                                @endphp
                                                <span
                                                    class="small {{ $change < 0 ? 'text-success' : ($change > 0 ? 'text-danger' : 'text-muted') }}">
                                                    ({{ $change < 0 ? '▼' : ($change > 0 ? '▲' : '—') }}{{ abs($change) }}m)
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2" style="color: var(--blue-700);">
                                            <i class="fas fa-bed me-1"></i>Durasi Tidur:
                                        </span>
                                        <span class="fw-bold">
                                            @if ($test->firstTest && $test->lastTest)
                                                {{ $test->firstTest->sleep_duration }}j →
                                                {{ $test->lastTest->sleep_duration }}j
                                                @php
                                                    $change =
                                                        $test->lastTest->sleep_duration -
                                                        $test->firstTest->sleep_duration;
                                                @endphp
                                                <span
                                                    class="small {{ $change > 0 ? 'text-success' : ($change < 0 ? 'text-danger' : 'text-muted') }}">
                                                    ({{ $change > 0 ? '▲' : ($change < 0 ? '▼' : '—') }}{{ abs($change) }}j)
                                                </span>
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h5 class="empty-state-title">Belum Ada Hasil Test</h5>
                <p class="empty-state-text">
                    Anda belum memiliki hasil test yang lengkap. Selesaikan test pertama dan terakhir untuk melihat hasil.
                </p>
                <a href="{{ route('pengguna.quality-test.index') }}" class="btn btn-primary">
                    <i class="fas fa-play-circle me-2"></i>Mulai Test
                </a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            const filterBadges = document.querySelectorAll('.filter-badge');
            filterBadges.forEach(badge => {
                badge.addEventListener('click', function() {
                    // Remove active class from all badges
                    filterBadges.forEach(b => b.classList.remove('active'));

                    // Add active class to clicked badge
                    this.classList.add('active');

                    // Get filter value
                    const filter = this.dataset.filter;

                    // Filter results (you can implement AJAX filtering here)
                    console.log('Filter by:', filter);
                });
            });
        });
    </script>
@endpush
