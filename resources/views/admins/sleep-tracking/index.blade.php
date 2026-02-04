@extends('layouts.admin')

@section('title', 'Sleep Tracking')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-section mb-4">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-8">
                    <div class="page-title-wrapper">
                        <h1 class="page-title mb-2 fw-bold" style="color: var(--primary);">
                            <i class="fas fa-bed me-2"></i>Sleep Tracking
                        </h1>
                        <p class="page-subtitle text-muted mb-0">Data monitoring tidur ibu hamil</p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="d-flex justify-content-lg-end">
                        <button class="btn btn-primary-custom btn-refresh" onclick="refreshData()">
                            <i class="fas fa-sync-alt me-2"></i>
                            <span>Refresh Data</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-3 g-lg-4 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-primary">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Total Pengguna</h6>
                            <h2 class="stats-value" id="totalUsers">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-success">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-bed"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Total Data</h6>
                            <h2 class="stats-value" id="totalRecords">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-info">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Rata-rata Durasi</h6>
                            <h2 class="stats-value stats-value-small" id="avgDuration">0 jam</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-warning">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-redo"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Rata-rata Waktu Kembali</h6>
                            <h2 class="stats-value stats-value-small" id="avgWakeBackTime">0 mnt</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="data-table-card">
            <div class="data-table-header">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-6">
                        <h5 class="table-title mb-0">
                            <i class="fas fa-table me-2"></i> Daftar Pengguna Sleep Tracking
                        </h5>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="search-wrapper">
                            <div class="search-input-group">
                                <span class="search-icon">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="search-input" id="searchInput"
                                    placeholder="Cari nama pengguna...">
                                <button class="search-button" type="button" id="searchBtn">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data-table-body">
                <div class="table-container">
                    <table class="modern-table" id="sleepTable">
                        <thead>
                            <tr>
                                <th class="th-number">#</th>
                                <th class="th-name">Nama Lengkap</th>
                                <th class="th-age">Umur</th>
                                <th class="th-pregnancy">Usia Kehamilan</th>
                                <th class="th-child">Hamil Anak Ke</th>
                                <th class="th-data">Total Data</th>
                                <th class="th-latest">Data Terakhir</th>
                                <th class="th-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($dataUsers) > 0)
                                @foreach ($dataUsers as $index => $user)
                                    <tr data-id="{{ $user['id'] }}" class="table-row">
                                        <td class="td-number">
                                            <span class="row-number">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="td-name">
                                            <div class="user-info">
                                                <div class="user-avatar-small">
                                                    {{ substr($user['nama_lengkap'], 0, 1) }}
                                                </div>
                                                <span class="user-name">{{ $user['nama_lengkap'] }}</span>
                                            </div>
                                        </td>
                                        <td class="td-age">
                                            <span class="age-text">{{ $user['umur'] }} tahun</span>
                                        </td>
                                        <td class="td-pregnancy">
                                            <span class="pregnancy-text">{{ $user['usia_kehamilan'] }}</span>
                                        </td>
                                        <td class="td-child">
                                            <span class="child-badge">{{ $user['hamil_anak_ke'] }}</span>
                                        </td>
                                        <td class="td-data">
                                            <span class="data-badge d-flex flex-column flex-lg-row justify-content-center justify-content-lg-start align-items-center align-items-lg-start">
                                                <i class="fas fa-bed me-1"></i>
                                                {{ $user['total_sleep_records'] }} data
                                            </span>
                                        </td>
                                        <td class="td-latest">
                                            @if ($user['latest_sleep'])
                                                <div class="latest-sleep-info">
                                                    <div class="sleep-date">{{ $user['latest_sleep']['tanggal'] }}</div>
                                                    <div class="sleep-time">
                                                        {{ $user['latest_sleep']['waktu_tidur'] }} - {{ $user['latest_sleep']['waktu_bangun'] }}
                                                    </div>
                                                    <div class="sleep-duration">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $user['latest_sleep']['durasi'] }}
                                                    </div>
                                                    @if ($user['latest_sleep']['waktu_tidur_kembali'])
                                                        <div class="sleep-return">
                                                            <i class="fas fa-redo me-1"></i>
                                                            Kembali: {{ $user['latest_sleep']['waktu_tidur_kembali'] }} mnt
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="td-action">
                                            <button type="button" class="action-btn action-btn-view"
                                                onclick="showDetail({{ $user['id'] }})" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                                <span class="action-text">Detail</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="empty-state">
                                        <div class="empty-state-content">
                                            <i class="fas fa-bed empty-icon"></i>
                                            <p class="empty-text">Belum ada data sleep tracking</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if (count($dataUsers) > 0)
                <div class="data-table-footer">
                    <div class="row align-items-center g-3">
                        <div class="col-12 col-md-6">
                            <div class="footer-info">
                                <span class="text-muted">
                                    Menampilkan <strong class="text-dark">{{ count($dataUsers) }}</strong> pengguna dengan data sleep tracking
                                </span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="pagination-wrapper">
                                <nav aria-label="Page navigation">
                                    <ul class="modern-pagination">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail (Tetap sama dengan yang sebelumnya) -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary text-white border-0">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="fas fa-bed me-2"></i> Detail Sleep Tracking
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="modalLoading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Memuat data sleep tracking...</p>
                    </div>
                    <div id="modalContent" class="d-none">
                        <!-- User Info -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <h4 id="detailNama" class="fw-bold mb-1"></h4>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-user me-1"></i> ID: <span id="detailId"></span> | 
                                        <i class="fas fa-phone me-1 ms-2"></i> <span id="detailTelepon"></span>
                                    </p>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <div class="card card-custom h-100">
                                            <div class="card-body text-center p-3">
                                                <h6 class="text-muted mb-2">Umur</h6>
                                                <h4 class="fw-bold text-primary mb-0" id="detailUmur"></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-custom h-100">
                                            <div class="card-body text-center p-3">
                                                <h6 class="text-muted mb-2">Usia Kehamilan</h6>
                                                <h4 class="fw-bold text-primary mb-0" id="detailUsiaKehamilan"></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-custom h-100">
                                            <div class="card-body text-center p-3">
                                                <h6 class="text-muted mb-2">Hamil Anak Ke</h6>
                                                <h4 class="fw-bold text-primary mb-0" id="detailHamilAnakKe"></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-custom h-100">
                                            <div class="card-body text-center p-3">
                                                <h6 class="text-muted mb-2">Total Data</h6>
                                                <h4 class="fw-bold text-primary mb-0" id="detailTotalData"></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-custom h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div class="avatar-wrapper d-inline-block">
                                                <img id="detailAvatar" src="" alt="Avatar" 
                                                     class="avatar-lg border-4 border-white shadow-sm">
                                            </div>
                                        </div>
                                        <div class="text-muted small">
                                            <div class="mb-2">
                                                <i class="fas fa-home me-1"></i>
                                                <span id="detailAlamat"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sleep Statistics -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card card-custom">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Statistik Tidur</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Rata-rata Durasi</h6>
                                                    <h3 class="fw-bold text-primary" id="statAvgDuration"></h3>
                                                    <p class="small text-muted mb-0">per malam</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Durasi Terpendek</h6>
                                                    <h3 class="fw-bold text-warning" id="statMinDuration"></h3>
                                                    <p class="small text-muted mb-0">tidur paling sebentar</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Durasi Terpanjang</h6>
                                                    <h3 class="fw-bold text-success" id="statMaxDuration"></h3>
                                                    <p class="small text-muted mb-0">tidur paling lama</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Waktu Tidur</h6>
                                                    <div class="mt-2">
                                                        <span class="badge bg-success me-2" id="statEarlySleep">0</span>
                                                        <span class="badge bg-primary me-2" id="statNormalSleep">0</span>
                                                        <span class="badge bg-secondary" id="statLateSleep">0</span>
                                                    </div>
                                                    <p class="small text-muted mb-0 mt-2">Early | Normal | Late</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Wake Back Time Statistics -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card card-custom">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="fas fa-redo me-2"></i> Statistik Waktu Tidur Kembali</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-4 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Data dengan Waktu Kembali</h6>
                                                    <h3 class="fw-bold text-info mb-1" id="statWakeBackCount">0</h3>
                                                    <div class="progress" style="height: 8px;">
                                                        <div id="statWakeBackPercentageBar" class="progress-bar bg-info" 
                                                             role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                    <p class="small text-muted mb-0 mt-1" id="statWakeBackPercentage">0%</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Rata-rata Waktu Kembali</h6>
                                                    <h3 class="fw-bold text-primary mb-0" id="statAvgWakeBackTime">0 mnt</h3>
                                                    <p class="small text-muted mb-0">per kebangunan</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Waktu Tercepat</h6>
                                                    <h3 class="fw-bold text-success mb-0" id="statMinWakeBackTime">0 mnt</h3>
                                                    <p class="small text-muted mb-0">kembali paling cepat</p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-4 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Waktu Terlama</h6>
                                                    <h3 class="fw-bold text-warning mb-0" id="statMaxWakeBackTime">0 mnt</h3>
                                                    <p class="small text-muted mb-0">kembali paling lama</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-8 mb-3">
                                                <div class="text-center">
                                                    <h6 class="text-muted mb-2">Distribusi Waktu Kembali</h6>
                                                    <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                                        <div class="text-center">
                                                            <span class="badge bg-success d-block mb-1">Cepat</span>
                                                            <small class="text-muted" id="statQuickReturn">0 (0%)</small>
                                                        </div>
                                                        <div class="text-center">
                                                            <span class="badge bg-warning d-block mb-1">Sedang</span>
                                                            <small class="text-muted" id="statModerateReturn">0 (0%)</small>
                                                        </div>
                                                        <div class="text-center">
                                                            <span class="badge bg-danger d-block mb-1">Lama</span>
                                                            <small class="text-muted" id="statLongReturn">0 (0%)</small>
                                                        </div>
                                                    </div>
                                                    <p class="small text-muted mb-0 mt-2">Cepat: ≤15 mnt | Sedang: 16-30 mnt | Lama: >30 mnt</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sleep Chart -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card card-custom">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> Grafik Durasi Tidur (30 Hari Terakhir)</h5>
                                        <div class="text-muted small">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Satuan: Jam
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="sleepChart" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sleep Data Table -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-custom">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Data Sleep Tracking</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" id="sleepDetailTable">
                                                <thead>
                                                    <tr>
                                                        <th class="ps-4">#</th>
                                                        <th>Tanggal</th>
                                                        <th>Waktu Tidur</th>
                                                        <th>Waktu Bangun</th>
                                                        <th>Durasi</th>
                                                        <th>Kebangunan</th>
                                                        <th>Waktu Tidur Kembali</th>
                                                        <th>Alasan</th>
                                                        <th>Catatan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sleepDetailBody">
                                                    <!-- Data akan diisi oleh JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light rounded-bottom-3">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* ===== Page Header ===== */
        .page-header-section {
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .page-title {
            font-size: 1.75rem;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 0.925rem;
        }

        .btn-refresh {
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(8, 86, 200, 0.15);
            transition: all 0.3s ease;
        }

        .btn-refresh:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(8, 86, 200, 0.25);
        }

        /* ===== Statistics Cards ===== */
        .stats-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .stats-card-body {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stats-icon-wrapper {
            flex-shrink: 0;
        }

        .stats-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stats-content {
            flex: 1;
            min-width: 0;
        }

        .stats-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: #212529;
            line-height: 1;
        }

        .stats-value-small {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .stats-card-warning .stats-icon {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        /* ===== Data Table Card ===== */
        .data-table-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
        }

        .data-table-header {
            background: linear-gradient(135deg, var(--primary) 0%, #064a9e 100%);
            padding: 1.5rem;
        }

        .table-title {
            color: #fff;
            font-weight: 600;
            font-size: 1.125rem;
        }

        /* ===== Search ===== */
        .search-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .search-input-group {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 0.25rem;
            width: 100%;
            max-width: 350px;
            backdrop-filter: blur(10px);
        }

        .search-icon {
            padding: 0 0.75rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .search-input {
            flex: 1;
            border: none;
            background: transparent;
            color: #fff;
            padding: 0.5rem 0.25rem;
            outline: none;
            font-size: 0.925rem;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-button {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        /* ===== Modern Table ===== */
        .table-container {
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .modern-table thead tr {
            background: #f8f9fa;
        }

        .modern-table th {
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
            white-space: nowrap;
        }

        .modern-table td {
            padding: 1.25rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9375rem;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background: #f8f9ff;
        }

        .modern-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Table Cells */
        .th-action,
        .td-action {
            text-align: center;
        }

        .row-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: #f0f0f0;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            color: #495057;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, #064a9e 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 600;
            color: #212529;
        }

        .age-text {
            color: #495057;
        }

        .pregnancy-text {
            color: #495057;
        }

        .child-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 0.75rem;
            background: #e7f3ff;
            color: var(--primary);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .data-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: #e7f3ff;
            color: var(--primary);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .latest-sleep-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .sleep-date {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
        }

        .sleep-time {
            color: #6c757d;
            font-size: 0.8125rem;
        }

        .sleep-duration {
            color: var(--primary);
            font-size: 0.8125rem;
        }

        .sleep-return {
            color: #28a745;
            font-size: 0.75rem;
            background: #d4edda;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            margin-top: 0.25rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-btn-view {
            background: #e7f3ff;
            color: var(--primary);
        }

        .action-btn-view:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(8, 86, 200, 0.25);
        }

        .action-text {
            display: none;
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 1rem !important;
            text-align: center;
        }

        .empty-state-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: #dee2e6;
        }

        .empty-text {
            margin: 0;
            color: #6c757d;
            font-size: 1rem;
        }

        /* ===== Table Footer ===== */
        .data-table-footer {
            padding: 1.25rem 1.5rem;
            background: #fafbfc;
            border-top: 1px solid #e9ecef;
        }

        .footer-info {
            font-size: 0.9375rem;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
        }

        .modern-pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.5rem;
        }

        .modern-pagination .page-item {
            list-style: none;
        }

        .modern-pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .modern-pagination .page-link:hover {
            background: #e7f3ff;
            border-color: var(--primary);
        }

        .modern-pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .modern-pagination .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ===== Responsive Design ===== */
        @media (max-width: 1199.98px) {
            .stats-card-body {
                padding: 1.25rem;
            }

            .stats-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }

            .stats-value {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 991.98px) {
            .page-title {
                font-size: 1.5rem;
            }

            .search-wrapper {
                justify-content: flex-start;
            }

            .search-input-group {
                max-width: 100%;
            }
        }

        @media (max-width: 767.98px) {
            .page-header-section {
                margin-bottom: 1.5rem;
            }

            .stats-card-body {
                padding: 1rem;
            }

            .stats-icon {
                width: 44px;
                height: 44px;
                font-size: 1.125rem;
            }

            .stats-value {
                font-size: 1.5rem;
            }

            .stats-label {
                font-size: 0.8125rem;
            }

            .data-table-header {
                padding: 1.25rem;
            }

            .modern-table th,
            .modern-table td {
                padding: 1rem;
            }

            .user-avatar-small {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }

            .action-btn {
                padding: 0.5rem;
            }

            .action-text {
                display: none;
            }

            .modal-body-modern {
                padding: 1.5rem;
            }

            .profile-card {
                padding: 1.5rem;
            }

            .detail-name {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .page-title {
                font-size: 1.25rem;
            }

            .page-subtitle {
                font-size: 0.875rem;
            }

            .stats-value-small {
                font-size: 0.75rem;
            }

            .table-title {
                font-size: 1rem;
            }

            .modern-table {
                font-size: 0.875rem;
            }

            .modern-table th,
            .modern-table td {
                padding: 0.75rem;
            }

            .user-info {
                gap: 0.5rem;
            }

            .user-name {
                font-size: 0.875rem;
            }

            .pagination-wrapper {
                justify-content: center;
            }

            .footer-info {
                text-align: center;
                margin-bottom: 1rem;
            }
        }

        /* Print Styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .print-content,
            .print-content * {
                visibility: visible;
            }

            .print-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .data-table-header,
            .data-table-footer,
            .action-btn, {
                display: none !important;
            }
        }

        /* Custom styles for modal (dari sebelumnya) */
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        .table th {
            background-color: var(--primary-lighter);
            color: var(--primary);
            font-weight: 600;
            padding: 12px 16px;
            border-bottom: 2px solid var(--border-color);
        }

        .table td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr:hover {
            background-color: var(--blue-100);
        }

        .btn-group .btn {
            border-radius: 8px !important;
            margin: 0 2px;
            padding: 6px 10px;
        }

        .avatar-lg {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--white);
            box-shadow: var(--shadow-sm);
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .page-link {
            color: var(--primary);
            border-radius: 8px;
            margin: 0 4px;
            border: 1px solid var(--border-color);
        }

        .page-link:hover {
            color: var(--primary-dark);
            background-color: var(--primary-lighter);
            border-color: var(--primary);
        }

        /* Custom styles for wake back time badges */
        .badge-wake-back {
            background: linear-gradient(135deg, #9c27b0, #673ab7);
            color: white;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        .badge-wake-back-quick {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .badge-wake-back-moderate {
            background: linear-gradient(135deg, #ffc107, #ff9800);
        }

        .badge-wake-back-long {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        /* Progress bar styles */
        .progress {
            border-radius: 10px;
            height: 10px;
        }

        .progress-bar {
            border-radius: 10px;
        }

        /* Statistics cards */
        .stat-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                margin: 2px 0;
                width: 100%;
            }

            .stat-card {
                padding: 15px;
            }
        }
    </style>

    <script>
        // Global variables
        let sleepChart = null;
        let currentUserId = null;

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadStatistics();
            initSearch();
        });

        // Load statistics data
        function loadStatistics() {
            fetch('{{ route("admin.sleep-tracking.statistics") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('totalUsers').textContent = data.data.total_users;
                        document.getElementById('totalRecords').textContent = data.data.total_records;
                        document.getElementById('avgDuration').textContent = data.data.avg_duration + ' jam';
                        document.getElementById('avgWakeBackTime').textContent = data.data.avg_wake_back_time + ' mnt';
                    }
                })
                .catch(error => {
                    console.error('Error loading statistics:', error);
                });
        }

        // Initialize search functionality
        function initSearch() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');

            searchBtn.addEventListener('click', performSearch);
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    performSearch();
                } else {
                    performSearch(); // Live search
                }
            });
        }

        // Perform search
        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#sleepTable tbody tr:not(.empty-state)');

            let visibleCount = 0;
            rows.forEach(row => {
                const nama = row.querySelector('.user-name');
                if (nama) {
                    const namaText = nama.textContent.toLowerCase();
                    if (namaText.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            // Show empty state if no results
            const tbody = document.querySelector('#sleepTable tbody');
            const existingEmpty = tbody.querySelector('.empty-state');

            if (visibleCount === 0 && searchTerm !== '') {
                if (!existingEmpty) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.className = 'empty-state search-empty';
                    emptyRow.innerHTML = `
                        <td colspan="8" class="empty-state">
                            <div class="empty-state-content">
                                <i class="fas fa-search empty-icon"></i>
                                <p class="empty-text">Tidak ada hasil untuk "${searchTerm}"</p>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(emptyRow);
                }
            } else {
                const searchEmpty = tbody.querySelector('.search-empty');
                if (searchEmpty) {
                    searchEmpty.remove();
                }
            }
        }

        // Refresh data
        function refreshData() {
            Swal.fire({
                title: 'Menyegarkan Data',
                text: 'Mohon tunggu sebentar...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Reload page after 1 second
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }

        // Show detail modal
        function showDetail(id) {
            currentUserId = id;
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const modalContent = document.getElementById('modalContent');
            const modalLoading = document.getElementById('modalLoading');

            // Reset modal state
            modalContent.classList.add('d-none');
            modalLoading.classList.remove('d-none');
            
            // Destroy existing chart
            if (sleepChart) {
                sleepChart.destroy();
            }

            // Fetch data
            fetch(`/admin/sleep-tracking/${id}/details`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Populate modal data
                        populateModalData(data.data);
                        
                        // Create chart
                        createSleepChart(data.data.sleep_data);
                        
                        // Populate sleep data table
                        populateSleepTable(data.data.sleep_data);
                        
                        // Show content
                        modalLoading.classList.add('d-none');
                        modalContent.classList.remove('d-none');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Gagal memuat data',
                            confirmButtonColor: '#0856C8'
                        });
                        modal.hide();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memuat data',
                        confirmButtonColor: '#0856C8'
                    });
                    modal.hide();
                });

            modal.show();
        }

        // Populate modal with data
        function populateModalData(data) {
            // User info
            document.getElementById('detailId').textContent = data.user.id;
            document.getElementById('detailNama').textContent = data.user.nama_lengkap;
            document.getElementById('detailTelepon').textContent = data.user.nomor_telepon;
            document.getElementById('detailUmur').textContent = data.user.umur + ' tahun';
            document.getElementById('detailUsiaKehamilan').textContent = 
                data.user.usia_kehamilan ? data.user.usia_kehamilan + ' minggu' : '-';
            document.getElementById('detailHamilAnakKe').textContent = data.user.hamil_anak_ke || '-';
            document.getElementById('detailAlamat').textContent = data.user.alamat;
            document.getElementById('detailTotalData').textContent = data.statistics.total_records;

            // Sleep statistics
            document.getElementById('statAvgDuration').textContent = data.statistics.avg_duration_formatted;
            document.getElementById('statMinDuration').textContent = data.statistics.min_duration_formatted;
            document.getElementById('statMaxDuration').textContent = data.statistics.max_duration_formatted;
            document.getElementById('statEarlySleep').textContent = data.statistics.sleep_by_time.early;
            document.getElementById('statNormalSleep').textContent = data.statistics.sleep_by_time.normal;
            document.getElementById('statLateSleep').textContent = data.statistics.sleep_by_time.late;

            // Wake back time statistics
            const wakeBackStats = data.statistics.wake_back_stats;
            document.getElementById('statWakeBackCount').textContent = wakeBackStats.total_with_wake_back;
            document.getElementById('statWakeBackPercentage').textContent = wakeBackStats.percentage + '%';
            document.getElementById('statAvgWakeBackTime').textContent = wakeBackStats.avg_wake_back_time + ' mnt';
            document.getElementById('statMinWakeBackTime').textContent = wakeBackStats.min_wake_back_time || '0 mnt';
            document.getElementById('statMaxWakeBackTime').textContent = wakeBackStats.max_wake_back_time || '0 mnt';
            document.getElementById('statQuickReturn').textContent = 
                wakeBackStats.quick_return + ' (' + wakeBackStats.quick_return_percentage + '%)';
            document.getElementById('statModerateReturn').textContent = 
                wakeBackStats.moderate_return + ' (' + wakeBackStats.moderate_return_percentage + '%)';
            document.getElementById('statLongReturn').textContent = 
                wakeBackStats.long_return + ' (' + wakeBackStats.long_return_percentage + '%)';
            
            // Update progress bar
            const progressBar = document.getElementById('statWakeBackPercentageBar');
            progressBar.style.width = wakeBackStats.percentage + '%';

            // Avatar
            const avatar = document.getElementById('detailAvatar');
            avatar.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.user.nama_lengkap)}&background=0856C8&color=fff&size=256&font-size=0.4&bold=true`;
        }

        // Create sleep chart
        function createSleepChart(sleepData) {
            const ctx = document.getElementById('sleepChart').getContext('2d');
            
            // Prepare data
            const labels = sleepData.map(item => item.tanggal);
            const durations = sleepData.map(item => item.durasi);
            
            // Calculate average line
            const avgDuration = durations.reduce((a, b) => a + b, 0) / durations.length;
            
            sleepChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Durasi Tidur (jam)',
                            data: durations,
                            borderColor: '#0856C8',
                            backgroundColor: 'rgba(8, 86, 200, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#0856C8',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Rata-rata',
                            data: Array(labels.length).fill(avgDuration),
                            borderColor: '#FF6384',
                            borderWidth: 1,
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        const hours = Math.floor(context.parsed.y);
                                        const minutes = Math.round((context.parsed.y - hours) * 60);
                                        label += hours + ' jam ' + minutes + ' menit';
                                    }
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
                                text: 'Durasi (jam)'
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

        // Populate sleep data table
        function populateSleepTable(sleepData) {
            const tbody = document.getElementById('sleepDetailBody');
            tbody.innerHTML = '';
            
            sleepData.forEach((item, index) => {
                const row = document.createElement('tr');
                
                // Determine wake back time badge class
                let wakeBackBadgeClass = 'badge-wake-back';
                let wakeBackTimeText = '-';
                
                if (item.waktu_tidur_kembali) {
                    wakeBackTimeText = `${item.waktu_tidur_kembali} menit`;
                    
                    if (item.waktu_tidur_kembali <= 15) {
                        wakeBackBadgeClass += ' badge-wake-back-quick';
                    } else if (item.waktu_tidur_kembali <= 30) {
                        wakeBackBadgeClass += ' badge-wake-back-moderate';
                    } else {
                        wakeBackBadgeClass += ' badge-wake-back-long';
                    }
                }
                
                // Determine wake up badge
                const wakeUpBadge = item.jumlah_kebangunan > 0 ? 
                    `<span class="badge bg-warning">${item.jumlah_kebangunan}x</span>` : 
                    `<span class="badge bg-success">Tidak Ada</span>`;
                
                // Create wake back time cell
                const wakeBackCell = item.waktu_tidur_kembali ? 
                    `<td><span class="${wakeBackBadgeClass}">${wakeBackTimeText}</span></td>` : 
                    `<td><span class="text-muted">-</span></td>`;
                
                row.innerHTML = `
                    <td class="ps-4">${index + 1}</td>
                    <td>${item.tanggal_full}</td>
                    <td>${item.waktu_tidur}</td>
                    <td>${item.waktu_bangun}</td>
                    <td>
                        <span class="badge bg-primary">${item.durasi_formatted}</span>
                    </td>
                    <td>${wakeUpBadge}</td>
                    ${wakeBackCell}
                    <td>
                        ${item.alasan_kebangunan ? 
                            `<span class="text-muted small">${item.alasan_kebangunan}</span>` : 
                            `<span class="text-muted">-</span>`}
                    </td>
                    <td>
                        ${item.catatan_lain ? 
                            `<span class="text-muted small">${item.catatan_lain}</span>` : 
                            `<span class="text-muted">-</span>`}
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Function to format wake back time
        function formatWakeBackTime(minutes) {
            if (!minutes) return '-';
            return `${minutes} menit`;
        }
    </script>
@endsection