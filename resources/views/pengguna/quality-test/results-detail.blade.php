@extends('layouts.app')

@section('title', 'Detail Hasil Tes - PSQI')

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

    /* Summary Card */
    .summary-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
        border: 2px solid transparent;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: var(--gradient-primary);
        transform: scaleX(1);
    }

    .summary-title {
        color: var(--blue-900);
        font-weight: 700;
        font-size: 1.3rem;
        border-left: 5px solid var(--blue-600);
        padding-left: 15px;
        margin-bottom: 20px;
    }

    /* Score Comparison */
    .score-comparison {
        background: var(--gradient-light);
        border-radius: 20px;
        padding: 30px;
        border: 2px solid var(--blue-200);
    }

    .score-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 15px 25px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .score-badge-before {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
        box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
    }

    .score-badge-after {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 4px 10px rgba(8, 86, 200, 0.3);
    }

    .score-value {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1;
        margin: 10px 0;
    }

    .score-before-value {
        color: #6c757d;
    }

    .score-after-value {
        color: var(--blue-900);
    }

    /* Improvement Display */
    .improvement-card {
        background: var(--gradient-light);
        border-radius: 20px;
        padding: 20px;
        border: 2px solid var(--blue-200);
        text-align: center;
    }

    .improvement-value {
        font-size: 3rem;
        font-weight: 800;
        margin: 10px 0;
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

    /* Component Comparison */
    .component-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 15px;
        border: 2px solid var(--blue-100);
        transition: all 0.3s ease;
        height: 100%;
    }

    .component-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(8, 86, 200, 0.1);
        border-color: var(--blue-300);
    }

    .component-name {
        color: var(--blue-900);
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .component-scores {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .component-before {
        color: #6c757d;
        font-weight: 600;
    }

    .component-after {
        color: var(--blue-700);
        font-weight: 600;
    }

    .component-change {
        font-size: 0.9rem;
        font-weight: 600;
    }

    .change-positive {
        color: #28a745;
    }

    .change-negative {
        color: #dc3545;
    }

    .change-neutral {
        color: #6c757d;
    }

    /* Disturbance Table */
    .table-responsive {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(8, 86, 200, 0.1);
    }

    .table-responsive table {
        margin: 0;
    }

    .table-responsive thead th {
        background: var(--gradient-primary);
        color: #ffffff;
        font-weight: 700;
        border: none;
        padding: 15px;
        text-align: center;
    }

    .table-responsive tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid var(--blue-100);
    }

    .table-responsive tbody tr:last-child td {
        border-bottom: none;
    }

    .disturbance-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .disturbance-low {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .disturbance-medium {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    .disturbance-high {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }

    /* Time Comparison */
    .time-comparison-card {
        background: var(--gradient-light);
        border-radius: 20px;
        padding: 20px;
        border: 2px solid var(--blue-200);
        margin-bottom: 20px;
    }

    .time-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(8, 86, 200, 0.1);
    }

    .time-item:last-child {
        border-bottom: none;
    }

    .time-label {
        color: var(--blue-800);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .time-value {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .time-change {
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Quality Assessment */
    .quality-assessment {
        background: var(--gradient-light);
        border-radius: 20px;
        padding: 25px;
        border-left: 8px solid var(--blue-600);
        margin-bottom: 20px;
    }

    .quality-icon {
        font-size: 3.5rem;
        margin-bottom: 15px;
    }

    .quality-message {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--blue-900);
    }

    /* Print Button */
    .btn-print {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 25px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(8, 86, 200, 0.4);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-title {
            font-size: 1.5rem;
        }

        .score-value {
            font-size: 2.5rem;
        }

        .improvement-value {
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

    .summary-card {
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
                            <i class="fas fa-chart-line me-2"></i>Detail Hasil Tes Kualitas Tidur
                        </h2>
                        <p class="header-subtitle mb-0">
                            Periode: {{ \Carbon\Carbon::parse($test->start_date)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($test->end_date)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('pengguna.quality-test.result') }}" class="btn btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overall Assessment -->
        @if(isset($overallQuality))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="quality-assessment text-center">
                    <div class="quality-icon text-{{ $overallQuality['color'] }}">
                        <i class="fas {{ $overallQuality['icon'] }}"></i>
                    </div>
                    <h3 class="mb-2 text-{{ $overallQuality['color'] }}">
                        {{ $overallQuality['label'] }}
                    </h3>
                    <p class="quality-message mb-0">
                        {{ $overallQuality['message'] }}
                    </p>
                    @if ($scoreImprovement != 0)
                        <p class="mb-0 mt-2">
                            Skor total Anda {{ $scoreImprovement < 0 ? 'menurun' : 'meningkat' }} sebanyak
                            <strong>{{ abs($scoreImprovement) }} poin</strong>
                            ({{ abs($improvementPercentage) }}%)
                        </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Score Comparison -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="score-comparison text-center">
                    <span class="score-badge score-badge-before">
                        <i class="fas fa-play-circle"></i>Sebelum Intervensi
                    </span>
                    <div class="score-value score-before-value mt-3">
                        {{ $test->total_score_before }}
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-{{ $firstTest->total_score <= 5 ? 'success' : 'danger' }} fs-6">
                            <i class="fas fa-{{ $firstTest->total_score <= 5 ? 'smile' : 'frown' }} me-2"></i>
                            {{ $firstTest->total_score <= 5 ? 'Kualitas Baik' : 'Kualitas Buruk' }}
                        </span>
                    </div>
                    <p class="text-muted small mb-0 mt-2">
                        <i class="fas fa-calendar-day me-1"></i>
                        {{ \Carbon\Carbon::parse($test->start_date)->format('d M Y') }}
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="improvement-card h-100">
                    <h5 class="fw-bold text-{{ $scoreImprovement < 0 ? 'success' : ($scoreImprovement > 0 ? 'danger' : 'secondary') }}">
                        <i class="fas fa-exchange-alt me-2"></i>Perubahan Skor
                    </h5>
                    <div class="improvement-value {{ $scoreImprovement < 0 ? 'improvement-positive' : ($scoreImprovement > 0 ? 'improvement-negative' : 'improvement-neutral') }}">
                        {{ $scoreImprovement < 0 ? '▼' : ($scoreImprovement > 0 ? '▲' : '—') }}
                        {{ abs($scoreImprovement) }}
                    </div>
                    <div class="mb-2">
                        {{ abs($improvementPercentage) }}%
                    </div>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Skor lebih rendah berarti kualitas tidur lebih baik
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="score-comparison text-center">
                    <span class="score-badge score-badge-after">
                        <i class="fas fa-flag-checkered"></i>Setelah Intervensi
                    </span>
                    <div class="score-value score-after-value mt-3">
                        {{ $test->total_score_after }}
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-{{ $lastTest->total_score <= 5 ? 'success' : 'danger' }} fs-6">
                            <i class="fas fa-{{ $lastTest->total_score <= 5 ? 'smile' : 'frown' }} me-2"></i>
                            {{ $lastTest->total_score <= 5 ? 'Kualitas Baik' : 'Kualitas Buruk' }}
                        </span>
                    </div>
                    <p class="text-muted small mb-0 mt-2">
                        <i class="fas fa-calendar-day me-1"></i>
                        {{ \Carbon\Carbon::parse($test->end_date)->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Component Comparison -->
        @if(isset($componentChanges) && count($componentChanges) > 0)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="summary-card">
                    <div class="card-body p-4">
                        <h5 class="summary-title">
                            <i class="fas fa-layer-group me-2"></i>Perbandingan Komponen PSQI
                        </h5>
                        <div class="row g-3">
                            @foreach ($componentChanges as $component)
                                <div class="col-md-6 col-lg-4">
                                    <div class="component-card">
                                        <div class="component-name">
                                            {{ $component['name'] }}
                                        </div>
                                        <div class="component-scores">
                                            <span class="component-before">
                                                Sebelum: {{ $component['before'] }}
                                            </span>
                                            <span class="component-after">
                                                Sesudah: {{ $component['after'] }}
                                            </span>
                                        </div>
                                        <div class="component-change {{ $component['change'] < 0 ? 'change-positive' : ($component['change'] > 0 ? 'change-negative' : 'change-neutral') }}">
                                            @if ($component['change'] < 0)
                                                <i class="fas fa-arrow-down me-1"></i>Membaik {{ abs($component['change']) }} poin
                                            @elseif($component['change'] > 0)
                                                <i class="fas fa-arrow-up me-1"></i>Memburuk {{ $component['change'] }} poin
                                            @else
                                                <i class="fas fa-minus me-1"></i>Tidak berubah
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Time Comparison -->
        @if(isset($sleepTimeImprovement))
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="summary-card">
                    <div class="card-body p-4">
                        <h5 class="summary-title">
                            <i class="fas fa-clock me-2"></i>Perbandingan Waktu Tidur
                        </h5>
                        <div class="time-comparison-card">
                            @foreach ($sleepTimeImprovement as $key => $value)
                                @if ($key == 'bedtime_change')
                                    <div class="time-item">
                                        <span class="time-label">
                                            <i class="fas fa-moon me-2"></i>Waktu Mulai Tidur
                                        </span>
                                        <span class="time-change {{ strpos($value, 'Lebih awal') !== false ? 'text-success' : 'text-warning' }}">
                                            {{ $value }}
                                        </span>
                                    </div>
                                @elseif($key == 'time_to_sleep_change')
                                    <div class="time-item">
                                        <span class="time-label">
                                            <i class="fas fa-hourglass-half me-2"></i>Waktu untuk Tertidur
                                        </span>
                                        <span class="time-change {{ $value < 0 ? 'text-success' : ($value > 0 ? 'text-warning' : 'text-secondary') }}">
                                            @if ($value < 0)
                                                <i class="fas fa-arrow-down me-1"></i>Lebih cepat {{ abs($value) }} menit
                                            @elseif($value > 0)
                                                <i class="fas fa-arrow-up me-1"></i>Lebih lambat {{ $value }} menit
                                            @else
                                                Tidak berubah
                                            @endif
                                        </span>
                                    </div>
                                @elseif($key == 'wakeup_change')
                                    <div class="time-item">
                                        <span class="time-label">
                                            <i class="fas fa-sun me-2"></i>Waktu Bangun
                                        </span>
                                        <span class="time-change {{ strpos($value, 'Lebih awal') !== false ? 'text-success' : 'text-warning' }}">
                                            {{ $value }}
                                        </span>
                                    </div>
                                @elseif($key == 'duration_change')
                                    <div class="time-item">
                                        <span class="time-label">
                                            <i class="fas fa-bed me-2"></i>Durasi Tidur
                                        </span>
                                        <span class="time-change {{ $value > 0 ? 'text-success' : ($value < 0 ? 'text-warning' : 'text-secondary') }}">
                                            @if ($value > 0)
                                                <i class="fas fa-arrow-up me-1"></i>Bertambah {{ $value }} jam
                                            @elseif($value < 0)
                                                <i class="fas fa-arrow-down me-1"></i>Berkurang {{ abs($value) }} jam
                                            @else
                                                Tidak berubah
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Disturbance Comparison -->
            @if(isset($disturbanceLabels))
            <div class="col-md-6">
                <div class="summary-card">
                    <div class="card-body p-4">
                        <h5 class="summary-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>Perbandingan Gangguan Tidur
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Jenis Gangguan</th>
                                        <th class="text-center">Sebelum</th>
                                        <th class="text-center">Sesudah</th>
                                        <th class="text-center">Perubahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($disturbanceLabels as $key => $label)
                                        @php
                                            $before = $firstDisturbances[$key] ?? 0;
                                            $after = $lastDisturbances[$key] ?? 0;
                                            $change = $after - $before;
                                        @endphp
                                        <tr>
                                            <td class="fw-bold" style="font-size: 0.9rem;">{{ $label }}</td>
                                            <td class="text-center">
                                                <span class="disturbance-badge disturbance-{{ $before <= 1 ? 'low' : ($before == 2 ? 'medium' : 'high') }}">
                                                    {{ $before }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="disturbance-badge disturbance-{{ $after <= 1 ? 'low' : ($after == 2 ? 'medium' : 'high') }}">
                                                    {{ $after }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-bold {{ $change < 0 ? 'text-success' : ($change > 0 ? 'text-danger' : 'text-secondary') }}">
                                                    @if ($change < 0)
                                                        <i class="fas fa-arrow-down"></i> {{ abs($change) }}
                                                    @elseif($change > 0)
                                                        <i class="fas fa-arrow-up"></i> +{{ $change }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if(isset($firstDisturbanceTotal) && isset($lastDisturbanceTotal))
                                    <tr class="bg-light">
                                        <td class="fw-bold">TOTAL</td>
                                        <td class="text-center fw-bold">{{ $firstDisturbanceTotal }}</td>
                                        <td class="text-center fw-bold">{{ $lastDisturbanceTotal }}</td>
                                        <td class="text-center fw-bold {{ $disturbanceChange < 0 ? 'text-success' : ($disturbanceChange > 0 ? 'text-danger' : 'text-secondary') }}">
                                            @if ($disturbanceChange < 0)
                                                <i class="fas fa-arrow-down"></i> {{ abs($disturbanceChange) }}
                                            @elseif($disturbanceChange > 0)
                                                <i class="fas fa-arrow-up"></i> +{{ $disturbanceChange }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Detail Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="summary-card">
                    <div class="card-body p-4">
                        <h5 class="summary-title">
                            <i class="fas fa-info-circle me-2"></i>Detail Test Pertama
                        </h5>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-2"><strong>Tanggal Test:</strong></p>
                                <p class="mb-2"><strong>Waktu Tidur:</strong></p>
                                <p class="mb-2"><strong>Waktu Tertidur:</strong></p>
                                <p class="mb-2"><strong>Waktu Bangun:</strong></p>
                                <p class="mb-2"><strong>Durasi Tidur:</strong></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-2">{{ \Carbon\Carbon::parse($firstTest->test_date)->format('d M Y') }}</p>
                                <p class="mb-2">{{ \Carbon\Carbon::parse($firstTest->bedtime)->format('H:i') }}</p>
                                <p class="mb-2">{{ $firstTest->time_to_sleep }} menit</p>
                                <p class="mb-2">{{ \Carbon\Carbon::parse($firstTest->wakeup_time)->format('H:i') }}</p>
                                <p class="mb-2">{{ $firstTest->sleep_duration }} jam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="summary-card">
                    <div class="card-body p-4">
                        <h5 class="summary-title">
                            <i class="fas fa-info-circle me-2"></i>Detail Test Terakhir
                        </h5>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-2"><strong>Tanggal Test:</strong></p>
                                <p class="mb-2"><strong>Waktu Tidur:</strong></p>
                                <p class="mb-2"><strong>Waktu Tertidur:</strong></p>
                                <p class="mb-2"><strong>Waktu Bangun:</strong></p>
                                <p class="mb-2"><strong>Durasi Tidur:</strong></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-2">{{ \Carbon\Carbon::parse($lastTest->test_date)->format('d M Y') }}</p>
                                <p class="mb-2">{{ \Carbon\Carbon::parse($lastTest->bedtime)->format('H:i') }}</p>
                                <p class="mb-2">{{ $lastTest->time_to_sleep }} menit</p>
                                <p class="mb-2">{{ \Carbon\Carbon::parse($lastTest->wakeup_time)->format('H:i') }}</p>
                                <p class="mb-2">{{ $lastTest->sleep_duration }} jam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="row">
            <div class="col-md-12">
                <div class="summary-card">
                    <div class="card-body p-4">
                        <h5 class="summary-title">
                            <i class="fas fa-lightbulb me-2"></i>Interpretasi Hasil
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <h6><i class="fas fa-check-circle me-2"></i>Perubahan Positif</h6>
                                    <p class="mb-0">
                                        • Skor total yang menurun menunjukkan perbaikan kualitas tidur<br>
                                        • Waktu tertidur yang lebih singkat<br>
                                        • Durasi tidur yang lebih panjang<br>
                                        • Penurunan frekuensi gangguan tidur
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Perlu Perhatian</h6>
                                    <p class="mb-0">
                                        • Skor total > 5 menunjukkan kualitas tidur yang buruk<br>
                                        • Peningkatan penggunaan obat tidur<br>
                                        • Gangguan tidur yang lebih sering<br>
                                        • Kantuk siang hari yang meningkat
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Print functionality
        const printBtn = document.querySelector('.btn-print');
        if (printBtn) {
            printBtn.addEventListener('click', function() {
                window.print();
            });
        }
    });
</script>
@endpush