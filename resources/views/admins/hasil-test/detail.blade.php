@extends('layouts.admin')

@section('title', 'Detail Test - ' . $pengguna->name)

@push('styles')
<style>
    /* Override any conflicting layout styles */
    .page-content {
        padding: 30px 25px !important;
    }

    @media (max-width: 992px) {
        .page-content {
            padding: 25px 20px !important;
        }
    }

    @media (max-width: 576px) {
        .page-content {
            padding: 20px 15px !important;
        }
    }
</style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.test-quality.index') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>

        <!-- User Profile Card -->
        <div class="profile-header-card">
            <div class="row align-items-center g-4">
                <div class="col-md-8">
                    <div class="d-flex align-items-start align-items-lg-center flex-column flex-lg-row justify-content-start justify-content-lg-center gap-3">
                        <div class="profile-avatar mx-auto text-capitalize">
                            {{ substr($pengguna->nama_lengkap, 0, 1) }}
                        </div>
                        <div class="profile-info">
                            <h2 class="profile-name text-capitalize">{{ $pengguna->nama_lengkap }}</h2>
                            <div class="profile-details">
                                <div class="detail-item">
                                    <i class="fas fa-location-dot"></i>
                                    <span>{{ $pengguna->alamat }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $pengguna->nomor_telepon ?? '-' }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Bergabung: {{ \Carbon\Carbon::parse($pengguna->created_at)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="profile-stats">
                        <div class="stat-item">
                            <h3 class="stat-value">{{ $pengguna->sleepTests->count() }}</h3>
                            <p class="stat-label">Total Test</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="stat-value">{{ $pengguna->sleepTests->where('status', 'completed')->count() }}</h3>
                            <p class="stat-label">Selesai</p>
                        </div>
                        <div class="stat-item">
                            <h3 class="stat-value">{{ $pengguna->sleepTests->where('status', 'ongoing')->count() }}</h3>
                            <p class="stat-label">Berjalan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Header -->
        <div class="section-header">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-start justify-content-lg-between gap-3">
                <h4 class="section-title">
                    <i class="fas fa-file-medical-alt me-2"></i>Riwayat Test Kualitas Tidur
                </h4>
                @if($pengguna->sleepTests->count() > 0)
                    <a href="{{ route('admin.test-quality.create', ['test' => $pengguna->sleepTests->first()->id]) }}" 
                       class="btn btn-primary-custom">
                        <i class="fas fa-plus me-2"></i>Isi Test Baru
                    </a>
                @endif
            </div>
        </div>

        <!-- Test List -->
        @forelse($pengguna->sleepTests as $test)
        <div class="test-card test-status-{{ $test->status }}">
            <div class="test-card-header">
                <div class="row align-items-start align-items-lg-center g-3">
                    <div class="col-12 col-lg-8">
                        <div class="d-flex align-items-start gap-3">
                            <div class="test-number">
                                <span>#{{ $loop->iteration }}</span>
                            </div>
                            <div class="test-info grow">
                                <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                    <h5 class="test-title mb-0">Test Kualitas Tidur #{{ $loop->iteration }}</h5>
                                    <!-- Mobile Action Button -->
                                    <div class="dropdown d-lg-none">
                                        <button class="btn-action-menu" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                                   data-bs-target="#testDetailModal{{ $test->id }}">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                                </a>
                                            </li>
                                            @if($test->status == 'ongoing')
                                            <li>
                                                <a class="dropdown-item" 
                                                   href="{{ route('admin.test-quality.create', ['test' => $test->id]) }}">
                                                    <i class="fas fa-edit me-2"></i>Isi Test
                                                </a>
                                            </li>
                                            @endif
                                            @if($test->firstTest && !$test->firstTest->is_confirmed)
                                            <li>
                                                <form action="{{ route('admin.test-quality.confirm', ['test' => $test->id, 'type' => 'first']) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-check me-2"></i>Konfirmasi Test Pertama
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                            @if($test->lastTest && !$test->lastTest->is_confirmed)
                                            <li>
                                                <form action="{{ route('admin.test-quality.confirm', ['test' => $test->id, 'type' => 'last']) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-check me-2"></i>Konfirmasi Test Terakhir
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div class="test-badges">
                                    <span class="info-badge">
                                        <i class="fas fa-calendar"></i>
                                        <span class="d-none d-sm-inline">{{ \Carbon\Carbon::parse($test->created_at)->format('d M Y') }}</span>
                                        <span class="d-inline d-sm-none">{{ \Carbon\Carbon::parse($test->created_at)->format('d/m/y') }}</span>
                                    </span>
                                    <span class="info-badge">
                                        <i class="fas fa-flag"></i>
                                        <span class="d-none d-md-inline">{{ $test->current_test == 'first' ? 'Test Pertama' : 'Test Terakhir' }}</span>
                                        <span class="d-inline d-md-none">{{ $test->current_test == 'first' ? 'Pertama' : 'Terakhir' }}</span>
                                    </span>
                                    <span class="status-badge status-{{ $test->status }}">
                                        @if($test->status == 'completed')
                                            <i class="fas fa-check-circle"></i> <span class="d-none d-sm-inline">Selesai</span>
                                        @elseif($test->status == 'ongoing')
                                            <i class="fas fa-spinner"></i> <span class="d-none d-sm-inline">Berjalan</span>
                                        @else
                                            <i class="fas fa-times-circle"></i> <span class="d-none d-sm-inline">Dibatalkan</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="test-period">
                                    <i class="fas fa-hourglass-half me-1"></i>
                                    <span class="d-none d-md-inline">Periode: {{ \Carbon\Carbon::parse($test->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($test->end_date)->format('d M Y') }}</span>
                                    <span class="d-inline d-md-none">{{ \Carbon\Carbon::parse($test->start_date)->format('d/m') }} - {{ \Carbon\Carbon::parse($test->end_date)->format('d/m/y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="test-actions">
                            @php
                                $progressPercentage = 0;
                                if ($test->firstTest && $test->lastTest) {
                                    $progressPercentage = 100;
                                } elseif ($test->firstTest || $test->lastTest) {
                                    $progressPercentage = 50;
                                }
                            @endphp
                            <div class="progress-indicator">
                                <div class="progress-circle" style="--progress: {{ $progressPercentage }}%;">
                                    <span class="progress-value">{{ $progressPercentage }}%</span>
                                </div>
                                <span class="progress-label">Progress</span>
                            </div>
                            <!-- Desktop Action Button -->
                            <div class="dropdown d-none d-lg-block">
                                <button class="btn-action-menu" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" 
                                           data-bs-target="#testDetailModal{{ $test->id }}">
                                            <i class="fas fa-eye me-2"></i>Lihat Detail
                                        </a>
                                    </li>
                                    @if($test->status == 'ongoing')
                                    <li>
                                        <a class="dropdown-item" 
                                           href="{{ route('admin.test-quality.create', ['test' => $test->id]) }}">
                                            <i class="fas fa-edit me-2"></i>Isi Test
                                        </a>
                                    </li>
                                    @endif
                                    @if($test->firstTest && !$test->firstTest->is_confirmed)
                                    <li>
                                        <form action="{{ route('admin.test-quality.confirm', ['test' => $test->id, 'type' => 'first']) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-check me-2"></i>Konfirmasi Test Pertama
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                    @if($test->lastTest && !$test->lastTest->is_confirmed)
                                    <li>
                                        <form action="{{ route('admin.test-quality.confirm', ['test' => $test->id, 'type' => 'last']) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-check me-2"></i>Konfirmasi Test Terakhir
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="test-card-body">
                <div class="row g-4">
                    <!-- Test Pertama -->
                    @if($test->firstTest)
                    <div class="col-md-6">
                        <div class="test-section">
                            <div class="test-section-header">
                                <h6 class="test-section-title">
                                    <i class="fas fa-moon me-2"></i>Test Pertama (Hari ke-1)
                                </h6>
                                <span class="confirmation-badge {{ $test->firstTest->is_confirmed ? 'confirmed' : 'pending' }}">
                                    @if($test->firstTest->is_confirmed)
                                        <i class="fas fa-check-circle"></i> Dikonfirmasi
                                    @else
                                        <i class="fas fa-clock"></i> Menunggu
                                    @endif
                                </span>
                            </div>
                            <div class="test-section-body">
                                <div class="score-display">
                                    <div class="score-circle-large {{ $test->firstTest->total_score <= 5 ? 'score-good' : 'score-bad' }}">
                                        <span class="score-number">{{ $test->firstTest->total_score }}</span>
                                        <span class="score-label">{{ $test->firstTest->total_score <= 5 ? 'Baik' : 'Buruk' }}</span>
                                    </div>
                                </div>
                                <div class="test-details-grid">
                                    <div class="detail-row">
                                        <span class="detail-label">Waktu Tidur</span>
                                        <span class="detail-value">{{ $test->firstTest->bedtime }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Waktu Bangun</span>
                                        <span class="detail-value">{{ $test->firstTest->wakeup_time }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Durasi Tidur</span>
                                        <span class="detail-value">{{ $test->firstTest->sleep_duration }} jam</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Kembali Tertidur</span>
                                        <span class="detail-value">{{ $test->firstTest->time_to_sleep }} menit</span>
                                    </div>
                                </div>
                                @if($test->firstTest->is_confirmed)
                                <div class="confirmation-info">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Dikonfirmasi pada {{ \Carbon\Carbon::parse($test->firstTest->confirmed_at)->format('d M Y, H:i') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-md-6">
                        <div class="test-section test-section-empty">
                            <div class="empty-state-small">
                                <i class="fas fa-moon empty-icon"></i>
                                <p class="empty-text">Test Pertama Belum Diisi</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Test Terakhir -->
                    @if($test->lastTest)
                    <div class="col-md-6">
                        <div class="test-section">
                            <div class="test-section-header">
                                <h6 class="test-section-title">
                                    <i class="fas fa-sun me-2"></i>Test Terakhir (Hari ke-7)
                                </h6>
                                <span class="confirmation-badge {{ $test->lastTest->is_confirmed ? 'confirmed' : 'pending' }}">
                                    @if($test->lastTest->is_confirmed)
                                        <i class="fas fa-check-circle"></i> Dikonfirmasi
                                    @else
                                        <i class="fas fa-clock"></i> Menunggu
                                    @endif
                                </span>
                            </div>
                            <div class="test-section-body">
                                <div class="score-display">
                                    <div class="score-circle-large {{ $test->lastTest->total_score <= 5 ? 'score-good' : 'score-bad' }}">
                                        <span class="score-number">{{ $test->lastTest->total_score }}</span>
                                        <span class="score-label">{{ $test->lastTest->total_score <= 5 ? 'Baik' : 'Buruk' }}</span>
                                    </div>
                                </div>
                                <div class="test-details-grid">
                                    <div class="detail-row">
                                        <span class="detail-label">Waktu Tidur</span>
                                        <span class="detail-value">{{ $test->lastTest->bedtime }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Waktu Bangun</span>
                                        <span class="detail-value">{{ $test->lastTest->wakeup_time }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Durasi Tidur</span>
                                        <span class="detail-value">{{ $test->lastTest->sleep_duration }} jam</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Lama Tertidur</span>
                                        <span class="detail-value">{{ $test->lastTest->time_to_sleep }} menit</span>
                                    </div>
                                </div>
                                @if($test->lastTest->is_confirmed)
                                <div class="confirmation-info">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Dikonfirmasi pada {{ \Carbon\Carbon::parse($test->lastTest->confirmed_at)->format('d M Y, H:i') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-md-6">
                        <div class="test-section test-section-empty">
                            <div class="empty-state-small">
                                <i class="fas fa-sun empty-icon"></i>
                                <p class="empty-text">Test Terakhir Belum Diisi</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Comparison Result -->
                @if($test->firstTest && $test->lastTest && $test->status == 'completed')
                <div class="comparison-section">
                    <h6 class="comparison-title">
                        <i class="fas fa-chart-line me-2"></i>Hasil Perbandingan
                    </h6>
                    <div class="comparison-body">
                        <div class="comparison-item">
                            <span class="comparison-label">Skor Sebelum</span>
                            <span class="comparison-value {{ $test->total_score_before <= 5 ? 'good' : 'bad' }}">
                                {{ $test->total_score_before }}
                            </span>
                        </div>
                        <div class="comparison-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div class="comparison-item">
                            <span class="comparison-label">Skor Sesudah</span>
                            <span class="comparison-value {{ $test->total_score_after <= 5 ? 'good' : 'bad' }}">
                                {{ $test->total_score_after }}
                            </span>
                        </div>
                        <div class="comparison-result">
                            @php
                                $diff = $test->total_score_before - $test->total_score_after;
                                $improvement = $diff > 0;
                            @endphp
                            @if($improvement)
                                <span class="result-badge improvement">
                                    <i class="fas fa-circle-check me-1"></i>
                                    Membaik ({{ abs($diff) }} poin)
                                </span>
                            @elseif($diff < 0)
                                <span class="result-badge decline">
                                    <i class="fas fa-circle-xmark me-1"></i>
                                    Menurun ({{ abs($diff) }} poin)
                                </span>
                            @else
                                <span class="result-badge stable">
                                    <i class="fas fa-equals me-1"></i>
                                    Stabil
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Detail Modal -->
        <div class="modal fade" id="testDetailModal{{ $test->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modern-modal">
                    <div class="modal-header-modern">
                        <h5 class="modal-title-modern">
                            <i class="fas fa-file-medical-alt me-2"></i>Detail Lengkap Test #{{ $loop->iteration }}
                        </h5>
                        <button type="button" class="btn-close-modern" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body-modern" style="max-height: 70vh; overflow-y: auto;">
                        <!-- Test Info -->
                        <div class="modal-section">
                            <h6 class="modal-section-title">Informasi Test</h6>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="status-badge status-{{ $test->status }}">
                                        @if($test->status == 'completed')
                                            <i class="fas fa-check-circle"></i> Selesai
                                        @elseif($test->status == 'ongoing')
                                            <i class="fas fa-spinner"></i> Berjalan
                                        @else
                                            <i class="fas fa-times-circle"></i> Dibatalkan
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Periode Test</span>
                                    <span class="info-value">
                                        {{ \Carbon\Carbon::parse($test->start_date)->format('d M Y') }} - 
                                        {{ \Carbon\Carbon::parse($test->end_date)->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Test Saat Ini</span>
                                    <span class="info-value">
                                        {{ $test->current_test == 'first' ? 'Test Pertama' : 'Test Terakhir' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Tanggal Dibuat</span>
                                    <span class="info-value">
                                        {{ \Carbon\Carbon::parse($test->created_at)->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Component Scores -->
                        @if($test->firstTest)
                        <div class="modal-section">
                            <h6 class="modal-section-title">Skor Komponen PSQI (Test Pertama)</h6>
                            <div class="components-grid">
                                @for($i = 1; $i <= 7; $i++)
                                    @php
                                        $componentKey = "component_$i";
                                        $score = $test->firstTest->$componentKey ?? 0;
                                        $class = $score == 0 ? 'low' : ($score <= 2 ? 'medium' : 'high');
                                        $labels = [
                                            1 => 'Kualitas Tidur',
                                            2 => 'Latensi Tidur',
                                            3 => 'Durasi Tidur',
                                            4 => 'Efisiensi Tidur',
                                            5 => 'Gangguan Tidur',
                                            6 => 'Penggunaan Obat',
                                            7 => 'Disfungsi Siang Hari'
                                        ];
                                    @endphp
                                    <div class="component-card component-{{ $class }}">
                                        <div class="component-number">C{{ $i }}</div>
                                        <div class="component-label">{{ $labels[$i] }}</div>
                                        <div class="component-score">{{ $score }}</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        @endif

                        @if($test->lastTest)
                        <div class="modal-section">
                            <h6 class="modal-section-title">Skor Komponen PSQI (Test Terakhir)</h6>
                            <div class="components-grid">
                                @for($i = 1; $i <= 7; $i++)
                                    @php
                                        $componentKey = "component_$i";
                                        $score = $test->lastTest->$componentKey ?? 0;
                                        $class = $score == 0 ? 'low' : ($score <= 2 ? 'medium' : 'high');
                                        $labels = [
                                            1 => 'Kualitas Tidur',
                                            2 => 'Latensi Tidur',
                                            3 => 'Durasi Tidur',
                                            4 => 'Efisiensi Tidur',
                                            5 => 'Gangguan Tidur',
                                            6 => 'Penggunaan Obat',
                                            7 => 'Disfungsi Siang Hari'
                                        ];
                                    @endphp
                                    <div class="component-card component-{{ $class }}">
                                        <div class="component-number">C{{ $i }}</div>
                                        <div class="component-label">{{ $labels[$i] }}</div>
                                        <div class="component-score">{{ $score }}</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        @endif

                        <!-- Detailed Data First Test -->
                        @if($test->firstTest)
                        <div class="modal-section">
                            <h6 class="modal-section-title">
                                <i class="fas fa-moon me-2"></i>Data Lengkap Test Pertama
                            </h6>
                            <div class="table-responsive">
                                <table class="detail-info-table">
                                    <tr>
                                        <td class="label-col">Waktu Mulai Tidur</td>
                                        <td class="value-col">{{ $test->firstTest->bedtime }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Waktu Untuk Tertidur</td>
                                        <td class="value-col">{{ $test->firstTest->time_to_sleep }} menit</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Waktu Bangun</td>
                                        <td class="value-col">{{ $test->firstTest->wakeup_time }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Durasi Tidur</td>
                                        <td class="value-col">{{ $test->firstTest->sleep_duration }} jam</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Skor Total</td>
                                        <td class="value-col">
                                            <span class="score-badge {{ $test->firstTest->total_score <= 5 ? 'good' : 'bad' }}">
                                                {{ $test->firstTest->total_score }} 
                                                ({{ $test->firstTest->total_score <= 5 ? 'Baik' : 'Buruk' }})
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Status Konfirmasi</td>
                                        <td class="value-col">
                                            @if($test->firstTest->is_confirmed)
                                                <span class="confirmation-badge confirmed">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Dikonfirmasi pada {{ \Carbon\Carbon::parse($test->firstTest->confirmed_at)->format('d M Y, H:i') }}
                                                </span>
                                            @else
                                                <span class="confirmation-badge pending">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Belum Dikonfirmasi
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- Detailed Data Last Test -->
                        @if($test->lastTest)
                        <div class="modal-section">
                            <h6 class="modal-section-title">
                                <i class="fas fa-sun me-2"></i>Data Lengkap Test Terakhir
                            </h6>
                            <div class="table-responsive">
                                <table class="detail-info-table">
                                    <tr>
                                        <td class="label-col">Waktu Mulai Tidur</td>
                                        <td class="value-col">{{ $test->lastTest->bedtime }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Waktu Untuk Tertidur</td>
                                        <td class="value-col">{{ $test->lastTest->time_to_sleep }} menit</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Waktu Bangun</td>
                                        <td class="value-col">{{ $test->lastTest->wakeup_time }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Durasi Tidur</td>
                                        <td class="value-col">{{ $test->lastTest->sleep_duration }} jam</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Skor Total</td>
                                        <td class="value-col">
                                            <span class="score-badge {{ $test->lastTest->total_score <= 5 ? 'good' : 'bad' }}">
                                                {{ $test->lastTest->total_score }} 
                                                ({{ $test->lastTest->total_score <= 5 ? 'Baik' : 'Buruk' }})
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-col">Status Konfirmasi</td>
                                        <td class="value-col">
                                            @if($test->lastTest->is_confirmed)
                                                <span class="confirmation-badge confirmed">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Dikonfirmasi pada {{ \Carbon\Carbon::parse($test->lastTest->confirmed_at)->format('d M Y, H:i') }}
                                                </span>
                                            @else
                                                <span class="confirmation-badge pending">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Belum Dikonfirmasi
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer-modern">
                        <button type="button" class="btn-modal-close" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Tutup
                        </button>
                        @if($test->status == 'ongoing')
                        <a href="{{ route('admin.test-quality.create', ['test' => $test->id]) }}" 
                           class="btn btn-primary-custom">
                            <i class="fas fa-edit me-2"></i>Edit Test
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state-main">
            <div class="empty-state-content">
                <i class="fas fa-file-medical-alt empty-icon"></i>
                <h5 class="empty-title">Belum Ada Test Kualitas Tidur</h5>
                <p class="empty-text">Pengguna ini belum pernah mengisi test kualitas tidur</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Custom Styles -->
    <style>
        /* ===== Back Button ===== */
        .btn-back {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.25rem;
            background: #fff;
            color: #6c757d;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: #f8f9fa;
            color: var(--primary);
            border-color: var(--primary);
            transform: translateX(-4px);
        }

        /* ===== Profile Header Card ===== */
        .profile-header-card {
            background: linear-gradient(135deg, var(--primary) 0%, #064a9e 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 24px rgba(8, 86, 200, 0.2);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            border: 4px solid rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            color: #fff;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .profile-details {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9375rem;
        }

        .detail-item i {
            color: rgba(255, 255, 255, 0.7);
        }

        .profile-stats {
            display: flex;
            gap: 2rem;
            justify-content: flex-end;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            margin: 0;
        }

        /* ===== Section Header ===== */
        .section-header {
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .section-title {
            color: var(--primary);
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        /* ===== Test Card ===== */
        .test-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            border: 1px solid #f0f0f0;
            border-left: 5px solid #6c757d;
            transition: all 0.3s ease;
        }

        .test-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .test-status-completed {
            border-left-color: #28a745;
        }

        .test-status-ongoing {
            border-left-color: #ffc107;
        }

        .test-status-abandoned {
            border-left-color: #6c757d;
        }

        .test-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .test-number {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, #064a9e 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .test-info {
            flex: 1;
            min-width: 0; /* Prevents flex item overflow */
        }

        .test-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.75rem;
            word-wrap: break-word;
        }

        .test-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .info-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #6c757d;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-completed {
            background: #d1f5e6;
            color: #0a7a4a;
        }

        .status-ongoing {
            background: #fff3cd;
            color: #856404;
        }

        .status-abandoned {
            background: #e9ecef;
            color: #6c757d;
        }

        .test-period {
            color: #6c757d;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Test Actions */
        .test-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            justify-content: flex-end;
        }

        .progress-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .progress-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: conic-gradient(var(--primary) 0% var(--progress, 0%), #e9ecef 0% 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .progress-circle::before {
            content: '';
            position: absolute;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #fff;
        }

        .progress-value {
            position: relative;
            z-index: 1;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--primary);
        }

        .progress-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
        }

        .btn-action-menu {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action-menu:hover {
            background: #e9ecef;
            color: var(--primary);
        }

        /* Test Card Body */
        .test-card-body {
            padding: 1.5rem;
        }

        .test-section {
            background: #f8f9fa;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .test-section-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 300px;
        }

        .test-section-header {
            background: #fff;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .test-section-title {
            margin: 0;
            font-size: 0.9375rem;
            font-weight: 700;
            color: #212529;
        }

        .confirmation-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .confirmation-badge.confirmed {
            background: #d1f5e6;
            color: #0a7a4a;
        }

        .confirmation-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .test-section-body {
            padding: 1.25rem;
        }

        .score-display {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .score-circle-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 4px solid;
        }

        .score-circle-large.score-good {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-color: #d1f5e6;
        }

        .score-circle-large.score-bad {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-color: #f8d7da;
        }

        .score-number {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }

        .score-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 0.25rem;
        }

        .test-details-grid {
            display: grid;
            gap: 0.75rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .detail-label {
            font-size: 0.875rem;
            color: #6c757d;
            font-weight: 600;
        }

        .detail-value {
            font-size: 0.9375rem;
            color: #212529;
            font-weight: 700;
        }

        .confirmation-info {
            margin-top: 1rem;
            padding: 0.75rem;
            background: #d1f5e6;
            border-radius: 8px;
            color: #0a7a4a;
            font-size: 0.8125rem;
            font-weight: 600;
            text-align: center;
        }

        /* Empty State Small */
        .empty-state-small {
            text-align: center;
            padding: 2rem 1rem;
        }

        .empty-state-small .empty-icon {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-state-small .empty-text {
            color: #6c757d;
            font-size: 0.9375rem;
            margin: 0;
        }

        /* ===== Comparison Section - IMPROVED RESPONSIVE ===== */
        .comparison-section {
            margin-top: 1.5rem;
            padding: 1.5rem;
            background: #fff;
            border-radius: 12px;
            border: 2px solid var(--primary);
        }

        .comparison-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
            text-align: center;
        }

        .comparison-body {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto;
            align-items: center;
            gap: 1rem;
        }

        .comparison-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .comparison-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .comparison-value {
            font-size: 2rem;
            font-weight: 700;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            min-width: 80px;
            text-align: center;
        }

        .comparison-value.good {
            background: #d1f5e6;
            color: #0a7a4a;
        }

        .comparison-value.bad {
            background: #f8d7da;
            color: #721c24;
        }

        .comparison-arrow {
            font-size: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .comparison-result {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            margin-top: 0.5rem;
        }

        .result-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 20px;
            font-size: 0.9375rem;
            font-weight: 700;
        }

        .result-badge.improvement {
            background: #d1f5e6;
            color: #0a7a4a;
        }

        .result-badge.decline {
            background: #f8d7da;
            color: #721c24;
        }

        .result-badge.stable {
            background: #e7f3ff;
            color: var(--primary);
        }

        /* Modal Styles */
        .modern-modal {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header-modern {
            display: flex;
            justify-content: space-between;
            align-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, #064a9e 100%);
            padding: 1.5rem 2rem;
            border: none;
        }

        .modal-title-modern {
            color: #fff;
            font-weight: 600;
            font-size: 1.25rem;
            margin: 0;
        }

        .btn-close-modern {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-close-modern:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .modal-body-modern {
            padding: 2rem;
        }

        .modal-section {
            margin-bottom: 2rem;
        }

        .modal-section:last-child {
            margin-bottom: 0;
        }

        .modal-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 0.9375rem;
            color: #212529;
            font-weight: 600;
        }

        /* Component Cards */
        .components-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .component-card {
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            border: 2px solid;
        }

        .component-card.component-low {
            background: rgba(40, 167, 69, 0.1);
            border-color: #28a745;
        }

        .component-card.component-medium {
            background: rgba(255, 193, 7, 0.1);
            border-color: #ffc107;
        }

        .component-card.component-high {
            background: rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
        }

        .component-number {
            font-size: 0.75rem;
            font-weight: 700;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .component-label {
            font-size: 0.8125rem;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .component-score {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .component-low .component-score {
            color: #28a745;
        }

        .component-medium .component-score {
            color: #ffc107;
        }

        .component-high .component-score {
            color: #dc3545;
        }

        /* Detail Info Table */
        .detail-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-info-table tr {
            border-bottom: 1px solid #e9ecef;
        }

        .detail-info-table tr:last-child {
            border-bottom: none;
        }

        .detail-info-table td {
            padding: 1rem;
        }

        .label-col {
            width: 40%;
            font-weight: 600;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .value-col {
            color: #212529;
            font-weight: 600;
            font-size: 0.9375rem;
        }

        .score-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 700;
        }

        .score-badge.good {
            background: #d1f5e6;
            color: #0a7a4a;
        }

        .score-badge.bad {
            background: #f8d7da;
            color: #721c24;
        }

        .modal-footer-modern {
            padding: 1.25rem 2rem;
            background: #f8f9fa;
            border: none;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .btn-modal-close {
            background: #6c757d;
            color: #fff;
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-modal-close:hover {
            background: #5a6268;
        }

        /* Empty State Main */
        .empty-state-main {
            background: #fff;
            border-radius: 16px;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .empty-state-content .empty-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            font-size: 0.9375rem;
            color: #6c757d;
            margin: 0;
        }

        /* ===== Responsive Design ===== */
        @media (max-width: 991.98px) {
            .profile-stats {
                justify-content: flex-start;
                margin-top: 1.5rem;
            }

            .test-actions {
                justify-content: flex-start;
                margin-top: 1rem;
            }
        }

        /* Tablet Responsive - Comparison Section */
        @media (max-width: 767.98px) {
            .profile-header-card {
                padding: 1.5rem;
            }

            .profile-name {
                font-size: 1.5rem;
            }

            .profile-details {
                flex-direction: column;
                gap: 0.75rem;
            }

            .profile-stats {
                gap: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            /* Test Card Header - Tablet */
            .test-card-header {
                padding: 1.25rem;
            }

            .test-number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .test-title {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }

            .test-badges {
                gap: 0.375rem;
                margin-bottom: 0.5rem;
            }

            .info-badge {
                padding: 0.25rem 0.625rem;
                font-size: 0.75rem;
            }

            .status-badge {
                padding: 0.25rem 0.625rem;
                font-size: 0.75rem;
            }

            .test-period {
                font-size: 0.8125rem;
            }

            .test-actions {
                justify-content: space-between;
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid #e9ecef;
            }

            .progress-indicator {
                flex-direction: row;
                gap: 0.75rem;
            }

            .progress-circle {
                width: 50px;
                height: 50px;
            }

            .progress-circle::before {
                width: 40px;
                height: 40px;
            }

            .progress-value {
                font-size: 0.75rem;
            }

            .progress-label {
                font-size: 0.8125rem;
            }

            .test-card-body {
                padding: 1.25rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .components-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            /* Comparison Section - Tablet */
            .comparison-section {
                padding: 1.25rem;
            }

            .comparison-body {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .comparison-item:nth-child(1) {
                order: 1;
            }

            .comparison-arrow:nth-child(2) {
                order: 3;
                transform: rotate(90deg);
            }

            .comparison-item:nth-child(3) {
                order: 5;
            }

            .comparison-arrow:nth-child(4) {
                display: none;
            }

            .comparison-result {
                order: 7;
                margin-top: 0.5rem;
            }

            .comparison-value {
                font-size: 1.75rem;
                padding: 0.625rem 1.25rem;
            }

            .comparison-arrow {
                font-size: 1.25rem;
            }

            .modal-body-modern {
                padding: 1.5rem;
            }
        }

        /* Mobile Responsive - Comparison Section */
        @media (max-width: 575.98px) {
            .profile-avatar {
                width: 64px;
                height: 64px;
                font-size: 1.5rem;
            }

            .profile-name {
                font-size: 1.25rem;
            }

            /* Test Card Header - Mobile */
            .test-card-header {
                padding: 1rem;
            }

            .test-number {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }

            .test-title {
                font-size: 0.9375rem;
                line-height: 1.3;
            }

            .test-badges {
                gap: 0.25rem;
            }

            .info-badge {
                padding: 0.25rem 0.5rem;
                font-size: 0.6875rem;
                gap: 0.25rem;
            }

            .info-badge i {
                font-size: 0.75rem;
            }

            .status-badge {
                padding: 0.25rem 0.5rem;
                font-size: 0.6875rem;
                gap: 0.25rem;
            }

            .status-badge i {
                font-size: 0.75rem;
            }

            .test-period {
                font-size: 0.75rem;
            }

            .test-period i {
                font-size: 0.875rem;
            }

            .test-actions {
                gap: 0.75rem;
                padding-top: 0.75rem;
                margin-top: 0.75rem;
            }

            .progress-circle {
                width: 45px;
                height: 45px;
            }

            .progress-circle::before {
                width: 36px;
                height: 36px;
            }

            .progress-value {
                font-size: 0.6875rem;
            }

            .progress-label {
                font-size: 0.75rem;
            }

            .btn-action-menu {
                width: 32px;
                height: 32px;
            }

            .test-card-body {
                padding: 1rem;
            }

            .components-grid {
                grid-template-columns: 1fr;
            }

            /* Comparison Section - Mobile */
            .comparison-section {
                padding: 1rem;
            }

            .comparison-title {
                font-size: 0.9375rem;
                margin-bottom: 1rem;
            }

            .comparison-body {
                gap: 1rem;
            }

            .comparison-label {
                font-size: 0.6875rem;
            }

            .comparison-value {
                font-size: 1.5rem;
                padding: 0.5rem 1rem;
                min-width: 70px;
            }

            .comparison-arrow {
                font-size: 1rem;
                padding: 0.5rem 0;
            }

            .result-badge {
                font-size: 0.8125rem;
                padding: 0.625rem 1rem;
            }
        }

        /* Extra Small Mobile */
        @media (max-width: 374.98px) {
            /* Test Card Header - Extra Small */
            .test-card-header {
                padding: 0.875rem;
            }

            .test-number {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }

            .test-title {
                font-size: 0.875rem;
            }

            .test-badges {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.375rem;
            }

            .info-badge,
            .status-badge {
                font-size: 0.625rem;
                padding: 0.25rem 0.5rem;
            }

            .test-period {
                font-size: 0.6875rem;
            }

            .test-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }

            .progress-indicator {
                justify-content: center;
            }

            .btn-action-menu {
                width: 100%;
                justify-content: center;
            }

            /* Comparison Section - Extra Small */
            .comparison-value {
                font-size: 1.25rem;
                padding: 0.5rem 0.75rem;
                min-width: 60px;
            }

            .comparison-label {
                font-size: 0.625rem;
            }

            .result-badge {
                font-size: 0.75rem;
                padding: 0.5rem 0.875rem;
            }
        }
    </style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Handle dropdown menu
        document.querySelectorAll('.btn-action-menu').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    });
</script>
@endpush