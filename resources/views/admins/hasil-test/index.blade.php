@extends('layouts.admin')

@section('title', 'Hasil Test Kualitas Tidur')

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
        <!-- Page Header -->
        <div class="page-header-section mb-4">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-8">
                    <div class="page-title-wrapper">
                        <h1 class="page-title mb-2 fw-bold" style="color: var(--primary);">
                            <i class="fas fa-file-medical-alt me-2"></i>Hasil Test Kualitas Tidur
                        </h1>
                        <p class="page-subtitle text-muted mb-0">Kelola dan pantau hasil test kualitas tidur semua pengguna
                        </p>
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
                            <h2 class="stats-value">{{ $penggunas->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-info">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Total Test</h6>
                            <h2 class="stats-value">{{ $penggunas->sum('total_tests') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-success">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Test Selesai</h6>
                            <h2 class="stats-value">{{ $penggunas->sum('completed_tests') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-warning">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-spinner"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Test Berjalan</h6>
                            <h2 class="stats-value">{{ $penggunas->sum('ongoing_tests') }}</h2>
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
                            <i class="fas fa-table me-2"></i> Daftar Pengguna Test
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
                    <table class="modern-table" id="penggunaTable">
                        <thead>
                            <tr>
                                <th class="th-number">#</th>
                                <th class="th-name">Nama Lengkap</th>
                                <th class="th-total">Total Test</th>
                                <th class="th-status">Status</th>
                                <th class="th-date">Test Terakhir</th>
                                <th class="th-score">Skor Rata-rata</th>
                                <th class="th-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penggunas as $index => $pengguna)
                                <tr class="table-row" data-id="{{ $pengguna->id }}">
                                    <td class="td-number">
                                        <span class="row-number">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="td-name">
                                        <div class="user-info">
                                            <div class="user-avatar-small text-capitalize">
                                                {{ substr($pengguna['nama_lengkap'], 0, 1) }}
                                            </div>
                                            <span class="user-name text-capitalize">{{ $pengguna['nama_lengkap'] }}</span>
                                        </div>
                                    </td>
                                    <td class="td-total">
                                        <div class="test-progress">
                                            <span class="test-count">{{ $pengguna->total_tests }}</span>
                                            <div class="progress-bar-wrapper">
                                                @php
                                                    $completion =
                                                        $pengguna->total_tests > 0
                                                            ? ($pengguna->completed_tests / $pengguna->total_tests) *
                                                                100
                                                            : 0;
                                                @endphp
                                                <div class="progress-bar-container">
                                                    <div class="progress-bar-fill" style="width: {{ $completion }}%">
                                                    </div>
                                                </div>
                                                <span class="progress-text">{{ number_format($completion, 0) }}%</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td-status">
                                        @php
                                            $latestTest = $pengguna->sleepTests->first();
                                        @endphp
                                        @if ($latestTest)
                                            @if ($latestTest->status == 'completed')
                                                <span class="status-badge status-completed">
                                                    <i class="fas fa-check-circle me-1"></i>Selesai
                                                </span>
                                            @elseif($latestTest->status == 'ongoing')
                                                <span class="status-badge status-ongoing">
                                                    <i class="fas fa-spinner me-1"></i>Berjalan
                                                </span>
                                            @else
                                                <span class="status-badge status-cancelled">
                                                    <i class="fas fa-times-circle me-1"></i>Dibatalkan
                                                </span>
                                            @endif
                                        @else
                                            <span class="status-badge status-none">
                                                <i class="fas fa-minus-circle me-1"></i>Tidak Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="td-date">
                                        @if ($latestTest)
                                            <span
                                                class="date-text">{{ \Carbon\Carbon::parse($latestTest->created_at)->format('d M Y') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="td-score">
                                        @php
                                            $avgScore = $pengguna->sleepTests
                                                ->filter(function ($test) {
                                                    return $test->total_score_before && $test->total_score_after;
                                                })
                                                ->avg(function ($test) {
                                                    return ($test->total_score_before + $test->total_score_after) / 2;
                                                });
                                        @endphp
                                        @if ($avgScore)
                                            <div class="score-wrapper">
                                                <span class="score-value">{{ number_format($avgScore, 1) }}</span>
                                                @if ($avgScore <= 5)
                                                    <span class="quality-badge quality-good">
                                                        Baik
                                                    </span>
                                                @else
                                                    <span class="quality-badge quality-bad">
                                                        Buruk
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="td-action">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.test-quality.detail', $pengguna->id) }}"
                                                class="action-btn action-btn-view" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                                <span class="action-text">Detail</span>
                                            </a>
                                            @if ($latestTest)
                                                <a href="{{ route('admin.test-quality.create', ['test' => $latestTest->id]) }}"
                                                    class="action-btn action-btn-add" title="Tambah Test">
                                                    <i class="fas fa-plus"></i>
                                                    <span class="action-text d-none d-xl-inline">Test</span>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <div class="empty-state-content">
                                            <i class="fas fa-inbox empty-icon"></i>
                                            <p class="empty-text">Belum ada data test kualitas tidur</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($penggunas->count() > 0)
                <div class="data-table-footer">
                    <div class="row align-items-center g-3">
                        <div class="col-12 col-md-6">
                            <div class="footer-info">
                                <span class="text-muted">
                                    Menampilkan <strong class="text-dark">{{ $penggunas->count() }}</strong> pengguna test
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

    <!-- Custom Styles -->
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

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            color: #212529;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            font-size: 0.8125rem;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Test Progress */
        .test-progress {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .test-count {
            font-weight: 700;
            color: #212529;
            font-size: 1rem;
        }

        .progress-bar-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .progress-bar-container {
            flex: 1;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .progress-text {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            min-width: 40px;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
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

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .status-none {
            background: #e9ecef;
            color: #6c757d;
        }

        .date-text {
            color: #495057;
            font-weight: 500;
        }

        /* Score Display */
        .score-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .score-value {
            font-weight: 700;
            color: #212529;
            font-size: 1.125rem;
        }

        .quality-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quality-good {
            background: #d1f5e6;
            color: #0a7a4a;
        }

        .quality-bad {
            background: #f8d7da;
            color: #721c24;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
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
            text-decoration: none;
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

        .action-btn-add {
            background: var(--primary);
            color: #fff;
        }

        .action-btn-add:hover {
            background: #064a9e;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(8, 86, 200, 0.35);
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

            .action-text {
                display: inline;
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

            .score-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .page-title {
                font-size: 1.25rem;
            }

            .page-subtitle {
                font-size: 0.875rem;
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

            .user-email {
                font-size: 0.75rem;
            }

            .pagination-wrapper {
                justify-content: center;
            }

            .footer-info {
                text-align: center;
                margin-bottom: 1rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.375rem;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Print Styles */
        @media print {

            .data-table-header,
            .data-table-footer,
            .action-buttons,
            {
            display: none !important;
        }

        .modern-table th,
        .modern-table td {
            padding: 0.5rem !important;
        }
        }
    </style>

    <script>
        // Initialize search functionality
        document.addEventListener('DOMContentLoaded', function() {
            initSearch();
        });

        // Initialize search
        function initSearch() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');

            if (searchBtn) {
                searchBtn.addEventListener('click', performSearch);
            }

            if (searchInput) {
                searchInput.addEventListener('keyup', function(event) {
                    if (event.key === 'Enter') {
                        performSearch();
                    } else {
                        performSearch(); // Live search
                    }
                });
            }
        }

        // Perform search
        function performSearch() {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;

            const searchTerm = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('#penggunaTable tbody tr:not(.empty-state)');

            let visibleCount = 0;
            rows.forEach(row => {
                const userName = row.querySelector('.user-name');
                const userEmail = row.querySelector('.user-email');

                if (userName && userEmail) {
                    const nameText = userName.textContent.toLowerCase();
                    const emailText = userEmail.textContent.toLowerCase();

                    if (nameText.includes(searchTerm) || emailText.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            // Show empty state if no results
            const tbody = document.querySelector('#penggunaTable tbody');
            const existingEmpty = tbody.querySelector('.search-empty');

            if (visibleCount === 0 && searchTerm !== '') {
                if (!existingEmpty) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.className = 'empty-state search-empty';
                    emptyRow.innerHTML = `
                        <td colspan="7" class="empty-state">
                            <div class="empty-state-content">
                                <i class="fas fa-search empty-icon"></i>
                                <p class="empty-text">Tidak ada hasil untuk "${searchTerm}"</p>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(emptyRow);
                }
            } else {
                if (existingEmpty) {
                    existingEmpty.remove();
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
    </script>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add active class to sidebar menu
            const currentUrl = window.location.pathname;
            const menuItems = document.querySelectorAll('.sidebar-menu .nav-link');

            menuItems.forEach(item => {
                if (item.getAttribute('href') && currentUrl.includes(item.getAttribute('href'))) {
                    item.classList.add('active');
                }
            });
        });
    </script>
@endpush
