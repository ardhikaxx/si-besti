@extends('layouts.app')

@section('title', 'Sleep Tracking')

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

        .sleep-tracking-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            background: var(--gradient-primary);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.2);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .page-header-content {
            position: relative;
            z-index: 1;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            margin: 0;
        }

        .add-button-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .add-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .add-button:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .stats-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(8, 86, 200, 0.15);
        }

        .stats-card h5 {
            color: var(--blue-900);
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-item {
            background: var(--gradient-light);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            border: 2px solid var(--blue-200);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.2);
            border-color: var(--blue-400);
        }

        .stat-item:hover::before {
            transform: scaleX(1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--blue-900);
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--blue-900), var(--blue-700));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--blue-700);
            font-weight: 500;
        }

        .sleep-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .sleep-cards-container {
                grid-template-columns: 1fr;
            }
        }

        .sleep-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .sleep-card::before {
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

        .sleep-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(8, 86, 200, 0.2);
            border-color: var(--blue-400);
        }

        .sleep-card:hover::before {
            transform: scaleX(1);
        }

        .sleep-date {
            font-size: 0.9rem;
            color: #ffffff;
            background: var(--gradient-primary);
            padding: 8px 18px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(8, 86, 200, 0.3);
        }

        .sleep-time {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--blue-100);
        }

        .time-item {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: var(--gradient-light);
            border-radius: 15px;
            border: 2px solid var(--blue-200);
            transition: all 0.3s ease;
        }

        .time-item:hover {
            transform: scale(1.05);
            border-color: var(--blue-400);
            box-shadow: 0 5px 15px rgba(8, 86, 200, 0.2);
        }

        .time-label {
            font-size: 0.8rem;
            color: var(--blue-700);
            margin-bottom: 8px;
            display: block;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .time-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--blue-900);
        }

        .sleep-duration {
            background: var(--gradient-light);
            padding: 12px 20px;
            border-radius: 15px;
            font-weight: 600;
            color: var(--blue-900);
            display: inline-block;
            margin-bottom: 20px;
            font-size: 0.95rem;
            border: 2px solid var(--blue-200);
        }

        .sleep-details {
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.95rem;
            padding: 10px;
            background: #f8fafc;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: var(--blue-100);
        }

        .detail-label {
            color: var(--blue-700);
            font-weight: 600;
        }

        .detail-value {
            color: var(--blue-900);
            font-weight: 600;
            text-align: right;
            max-width: 60%;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .action-btn {
            padding: 10px 18px;
            border: none;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-view {
            background: linear-gradient(135deg, var(--blue-500), var(--blue-700));
            color: white;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(58, 125, 228, 0.4);
        }

        .btn-edit {
            background: var(--gradient-warning);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        }

        .btn-delete {
            background: var(--gradient-danger);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
        }

        .duration-badge {
            background: var(--gradient-success);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-block;
            margin-left: 8px;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .duration-warning {
            background: var(--gradient-warning);
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
        }

        .duration-danger {
            background: var(--gradient-danger);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            background: #ffffff;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.1);
            border: 3px dashed var(--blue-300);
        }

        .no-data-icon {
            font-size: 5rem;
            color: var(--blue-400);
            margin-bottom: 25px;
            width: 120px;
            height: 120px;
            background: var(--gradient-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: float 3s ease-in-out infinite;
        }

        .no-data-icon i {
            font-size: 50px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .no-data-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: var(--blue-900);
            font-weight: 700;
        }

        .no-data-text {
            margin-bottom: 30px;
            font-size: 1.1rem;
            color: var(--blue-700);
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .modal-header {
            background: var(--gradient-primary);
            color: white;
            padding: 25px 30px;
            border: none;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 2px solid var(--blue-100);
            background: #f8fafc;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: var(--blue-900);
            margin-bottom: 10px;
            display: block;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid var(--blue-200);
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            width: 100%;
            background: #ffffff;
        }

        .form-control:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 4px rgba(58, 125, 228, 0.15);
            outline: none;
            background: var(--blue-100);
        }

        .time-input-group {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
        }

        .time-separator {
            text-align: center;
            font-weight: 700;
            color: var(--blue-700);
            font-size: 1.3rem;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .duration-info {
            font-size: 0.85rem;
            color: var(--blue-600);
            margin-top: 10px;
            font-style: italic;
            padding: 10px;
            background: var(--blue-100);
            border-radius: 8px;
            border-left: 4px solid var(--blue-500);
        }

        .conditional-field {
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px solid var(--blue-200);
            transition: all 0.3s ease;
            margin-bottom: 25px;
        }

        .conditional-field.active {
            border-color: var(--blue-500);
            background: var(--blue-100);
        }

        .wake-back-input-container {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 15px;
            align-items: center;
        }

        .input-with-unit {
            position: relative;
        }

        .input-with-unit .form-control {
            padding-right: 80px;
        }

        .input-unit {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--blue-700);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 14px 30px;
            border-radius: 25px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.4);
        }

        .btn-secondary {
            background: #ffffff;
            border: 2px solid var(--blue-300);
            padding: 14px 30px;
            border-radius: 25px;
            font-weight: 700;
            color: var(--blue-700);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--blue-100);
            border-color: var(--blue-500);
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .detail-modal .modal-body {
            max-height: 65vh;
            overflow-y: auto;
        }

        .detail-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid var(--blue-100);
        }

        .detail-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--blue-900);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .detail-section-title i {
            color: var(--blue-600);
            font-size: 1.3rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .detail-item-large {
            background: var(--gradient-light);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid var(--blue-200);
            transition: all 0.3s ease;
        }

        .detail-item-large:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.15);
            border-color: var(--blue-400);
        }

        .detail-label-large {
            font-size: 0.9rem;
            color: var(--blue-700);
            margin-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value-large {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--blue-900);
        }

        .text-content {
            white-space: pre-wrap;
            line-height: 1.8;
            background: var(--blue-100);
            padding: 20px;
            border-radius: 12px;
            font-size: 0.95rem;
            color: var(--blue-900);
            border-left: 4px solid var(--blue-500);
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
        }

        .page-item .page-link {
            padding: 10px 18px;
            border: 2px solid var(--blue-300);
            border-radius: 12px;
            color: var(--blue-900);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .page-item.active .page-link {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--blue-700);
            box-shadow: 0 4px 10px rgba(8, 86, 200, 0.3);
        }

        .page-item:not(.active) .page-link:hover {
            background: var(--blue-100);
            border-color: var(--blue-500);
            transform: translateY(-2px);
        }

        .page-item.disabled .page-link {
            color: #9ca3af;
            background: #f3f4f6;
            cursor: not-allowed;
            border-color: #e5e7eb;
        }

        @media (max-width: 768px) {
            .page-header { padding: 20px; }
            .page-title { font-size: 1.5rem; }
            .stats-card { padding: 20px; }
            .sleep-card { padding: 20px; }
            .time-value { font-size: 1.2rem; }
            .modal-body { padding: 20px; }
            .add-button { padding: 10px 20px; font-size: 0.9rem; }
            .wake-back-input-container { grid-template-columns: 1fr; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .sleep-card { animation: fadeInUp 0.6s ease-out; }
        .conditional-field { animation: fadeIn 0.3s ease-out; }
    </style>
@endpush

@section('content')
    <div class="sleep-tracking-container">
        <div class="page-header">
            <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between page-header-content">
                <div class="text-center text-lg-start mb-3 mb-lg-0">
                    <h1 class="page-title"><i class="fas fa-bed me-2"></i>Sleep Tracking</h1>
                    <p class="page-subtitle">Pantau dan catat kualitas tidur Anda setiap hari</p>
                </div>
                <div class="add-button-container">
                    <button class="add-button" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        Tambah Catatan Tidur
                    </button>
                </div>
            </div>
        </div>

        <div class="stats-card">
            <h5><i class="fas fa-chart-line me-2"></i>Statistik Tidur Anda</h5>
            <div class="stats-grid" id="statisticsContainer">
                <div class="stat-item">
                    <div class="stat-value" id="statTotal">0</div>
                    <div class="stat-label"><i class="fas fa-book-open me-2"></i>Total Pencatatan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="statAverage">0 jam</div>
                    <div class="stat-label"><i class="fas fa-clock me-2"></i>Rata-rata Durasi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="statWakeups">0x</div>
                    <div class="stat-label"><i class="fas fa-wind me-2"></i>Rata-rata Kebangunan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" id="statWakeBack">0 mnt</div>
                    <div class="stat-label"><i class="fas fa-redo me-2"></i>Rata-rata Tidur Kembali</div>
                </div>
            </div>
        </div>

        <div id="sleepCardsContainer">
            @if ($sleepTrackings->count() > 0)
                <div class="sleep-cards-container">
                    @foreach ($sleepTrackings as $tracking)
                        @php
                            $hours = floor($tracking->durasi_tidur);
                            $minutes = round(($tracking->durasi_tidur - $hours) * 60);
                            $durationText = $hours > 0 ? $hours . ' jam' : '';
                            $durationText .= $minutes > 0 ? ' ' . $minutes . ' menit' : '';

                            $badgeClass = 'duration-badge';
                            if ($tracking->durasi_tidur >= 7) {
                                $badgeClass .= '';
                            } elseif ($tracking->durasi_tidur >= 5) {
                                $badgeClass .= ' duration-warning';
                            } else {
                                $badgeClass .= ' duration-danger';
                            }
                        @endphp
                        <div class="sleep-card" id="card-{{ $tracking->id }}">
                            <div class="sleep-date">
                                <i class="fas fa-calendar-alt me-2"></i>{{ date('d F Y', strtotime($tracking->tanggal_tidur)) }}
                            </div>
                            <div class="sleep-time">
                                <div class="time-item">
                                    <span class="time-label">Mulai Tidur</span>
                                    <span class="time-value">{{ date('H:i', strtotime($tracking->waktu_tidur)) }}</span>
                                </div>
                                <div class="time-item">
                                    <span class="time-label">Bangun</span>
                                    <span class="time-value">{{ date('H:i', strtotime($tracking->waktu_bangun)) }}</span>
                                </div>
                            </div>
                            <div class="sleep-duration">
                                <i class="fas fa-clock me-2"></i>Durasi: {{ $durationText }}
                                <span class="{{ $badgeClass }}">{{ number_format($tracking->durasi_tidur, 2) }} jam</span>
                            </div>
                            <div class="sleep-details">
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-wind me-2"></i>Kebangunan:</span>
                                    <span class="detail-value">{{ $tracking->jumlah_kebangunan }} kali</span>
                                </div>
                                @if ($tracking->waktu_tidur_kembali)
                                    <div class="detail-item">
                                        <span class="detail-label"><i class="fas fa-redo me-2"></i>Waktu Tidur Kembali:</span>
                                        <span class="detail-value">{{ $tracking->waktu_tidur_kembali }} menit</span>
                                    </div>
                                @endif
                                @if ($tracking->alasan_kebangunan)
                                    <div class="detail-item">
                                        <span class="detail-label"><i class="fas fa-comment-medical me-2"></i>Alasan:</span>
                                        <span class="detail-value">{{ Str::limit($tracking->alasan_kebangunan, 50) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-actions">
                                <button class="action-btn btn-view" onclick="viewDetail({{ $tracking->id }})">
                                    <i class="fas fa-eye"></i>Lihat
                                </button>
                                <button class="action-btn btn-edit" onclick="openEditModal({{ $tracking->id }})">
                                    <i class="fas fa-edit"></i>Edit
                                </button>
                                <button class="action-btn btn-delete" onclick="confirmDelete({{ $tracking->id }})">
                                    <i class="fas fa-trash"></i>Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($sleepTrackings->hasPages())
                    <div class="pagination-container">
                        <ul class="pagination">
                            <li class="page-item {{ $sleepTrackings->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $sleepTrackings->previousPageUrl() ?? '#' }}" aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            @foreach ($sleepTrackings->getUrlRange(max(1, $sleepTrackings->currentPage() - 2), min($sleepTrackings->lastPage(), $sleepTrackings->currentPage() + 2)) as $page => $url)
                                <li class="page-item {{ $page == $sleepTrackings->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            <li class="page-item {{ $sleepTrackings->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $sleepTrackings->nextPageUrl() ?? '#' }}" aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            @else
                <div class="empty-state text-center">
                    <div class="no-data-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h3 class="no-data-title">Belum Ada Catatan Tidur</h3>
                    <p class="no-data-text">Mulai catat tidur Anda untuk memantau kualitas tidur harian.</p>
                    <button class="add-button" onclick="openAddModal()" style="background: var(--gradient-primary); border: none;">
                        <i class="fas fa-plus"></i>
                        Tambah Catatan Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="sleepModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Catatan Tidur
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sleepForm" onsubmit="handleSubmit(event)">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="trackingId" name="id">
                        <input type="hidden" id="formMethod" name="_method" value="POST">

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-calendar me-2"></i>Tanggal Tidur *</label>
                            <input type="date" class="form-control" id="tanggal_tidur" name="tanggal_tidur" required max="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-clock me-2"></i>Waktu Tidur *</label>
                            <div class="time-input-group">
                                <input type="time" class="form-control" id="waktu_tidur" name="waktu_tidur" required onchange="calculateDuration()">
                                <span class="time-separator"><i class="fas fa-arrow-right"></i></span>
                                <input type="time" class="form-control" id="waktu_bangun" name="waktu_bangun" required onchange="calculateDuration()">
                            </div>
                            <div class="duration-info">
                                <i class="fas fa-info-circle me-2"></i>Durasi: <strong><span id="durationPreview">0 jam 0 menit</span></strong>
                                (<span id="durationDecimal">0.00 jam</span>)
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-wind me-2"></i>Berapa kali kebangun? *</label>
                            <input type="number" class="form-control" id="jumlah_kebangunan" name="jumlah_kebangunan" min="0" max="20" value="0" required onchange="toggleWakeBackTimeField(this.value)">
                            <div class="duration-info">Isi 0 jika tidak terbangun sama sekali</div>
                        </div>

                        <div class="conditional-field" id="wakeBackTimeContainer" style="display: none;">
                            <div class="form-group mb-2">
                                <label class="form-label"><i class="fas fa-redo me-2"></i>Rata-rata waktu untuk tidur kembali (dalam menit)</label>
                                <div class="wake-back-input-container">
                                    <div class="input-with-unit">
                                        <input type="number" class="form-control" id="waktu_tidur_kembali" name="waktu_tidur_kembali" min="1" max="120" placeholder="Misal: 15">
                                        <span class="input-unit">menit</span>
                                    </div>
                                </div>
                                <div class="duration-info">
                                    <i class="fas fa-info-circle me-1"></i>Perkiraan waktu yang dibutuhkan untuk kembali tidur setelah terbangun.
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-comment-medical me-2"></i>Alasan kebangunan (jika ada)</label>
                            <textarea class="form-control" id="alasan_kebangunan" name="alasan_kebangunan" rows="3" placeholder="Contoh: ke kamar mandi, mimpi buruk, merasa tidak nyaman, dll."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-sticky-note me-2"></i>Catatan lain</label>
                            <textarea class="form-control" id="catatan_lain" name="catatan_lain" rows="3" placeholder="Tambah catatan tentang kualitas tidur, mimpi, atau hal lain"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <span id="submitText"><i class="fas fa-save me-2"></i>Simpan</span>
                            <span id="submitLoading" class="loading-spinner" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade detail-modal" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Detail Catatan Tidur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentTrackingId = null;
        let modal = null;
        let detailModal = null;

        document.addEventListener('DOMContentLoaded', function() {
            modal = new bootstrap.Modal(document.getElementById('sleepModal'));
            detailModal = new bootstrap.Modal(document.getElementById('detailModal'));

            loadStatistics();
            setDefaultTimes();
            calculateDuration();
            toggleWakeBackTimeField(0);

            document.getElementById('sleepForm').addEventListener('submit', handleSubmit);
        });

        function setDefaultTimes() {
            const sleepEl = document.getElementById('waktu_tidur');
            const wakeEl = document.getElementById('waktu_bangun');
            if (sleepEl && !sleepEl.value) sleepEl.value = '22:00';
            if (wakeEl && !wakeEl.value) wakeEl.value = '06:00';
        }

        function toggleWakeBackTimeField(wakeups) {
            const container = document.getElementById('wakeBackTimeContainer');
            const input = document.getElementById('waktu_tidur_kembali');
            if (container && input) {
                if (parseInt(wakeups) > 0) {
                    container.style.display = 'block';
                    container.classList.add('active');
                } else {
                    container.style.display = 'none';
                    container.classList.remove('active');
                    input.value = '';
                }
            }
        }

        function calculateDuration() {
            const sleepTime = document.getElementById('waktu_tidur').value;
            const wakeTime = document.getElementById('waktu_bangun').value;

            if (!sleepTime || !wakeTime) return;

            const sleepParts = sleepTime.split(':');
            const wakeParts = wakeTime.split(':');

            let sleepDate = new Date();
            sleepDate.setHours(parseInt(sleepParts[0]), parseInt(sleepParts[1]), 0);

            let wakeDate = new Date();
            wakeDate.setHours(parseInt(wakeParts[0]), parseInt(wakeParts[1]), 0);

            if (wakeDate <= sleepDate) {
                wakeDate.setDate(wakeDate.getDate() + 1);
            }

            const durationInMs = wakeDate - sleepDate;
            const durationInHours = durationInMs / (1000 * 60 * 60);

            const hours = Math.floor(durationInHours);
            const minutes = Math.round((durationInHours - hours) * 60);

            let durationText = '';
            if (hours > 0) durationText += hours + ' jam ';
            if (minutes > 0) durationText += minutes + ' menit';
            else if (hours === 0) durationText = '0 menit';

            document.getElementById('durationPreview').textContent = durationText.trim();
            document.getElementById('durationDecimal').textContent = durationInHours.toFixed(2) + ' jam';
        }

        async function loadStatistics() {
            try {
                const response = await fetch('{{ route('pengguna.sleep-tracking.statistics') }}');
                const result = await response.json();

                if (result.success) {
                    const stats = result.data;
                    document.getElementById('statTotal').textContent = stats.total_records;
                    document.getElementById('statAverage').textContent = stats.formatted_average_duration || '0 jam';
                    document.getElementById('statWakeups').textContent = (stats.average_wakeups || 0) + 'x';
                    document.getElementById('statWakeBack').textContent = (stats.average_wake_back_time || 0) + ' mnt';
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            }
        }

        function openAddModal() {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Tambah Catatan Tidur';
            document.getElementById('sleepForm').reset();
            document.getElementById('trackingId').value = '';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('tanggal_tidur').value = new Date().toISOString().split('T')[0];
            setDefaultTimes();
            calculateDuration();
            toggleWakeBackTimeField(0);
            modal.show();
        }

        async function openEditModal(id) {
            try {
                const response = await fetch('{{ route('pengguna.sleep-tracking.index') }}/' + id);
                const result = await response.json();

                if (result.success) {
                    const data = result.data;
                    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Catatan Tidur';
                    document.getElementById('trackingId').value = data.id;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('tanggal_tidur').value = data.tanggal_tidur;
                    document.getElementById('waktu_tidur').value = data.waktu_tidur.substring(0, 5);
                    document.getElementById('waktu_bangun').value = data.waktu_bangun.substring(0, 5);
                    document.getElementById('jumlah_kebangunan').value = data.jumlah_kebangunan;
                    document.getElementById('waktu_tidur_kembali').value = data.waktu_tidur_kembali || '';
                    document.getElementById('alasan_kebangunan').value = data.alasan_kebangunan || '';
                    document.getElementById('catatan_lain').value = data.catatan_lain || '';

                    toggleWakeBackTimeField(data.jumlah_kebangunan);
                    setTimeout(calculateDuration, 100);
                    modal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat Data',
                        text: result.message,
                        confirmButtonColor: '#0856C8'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal memuat data untuk diedit',
                    confirmButtonColor: '#0856C8'
                });
            }
        }

        async function viewDetail(id) {
            try {
                const response = await fetch('{{ route('pengguna.sleep-tracking.index') }}/' + id);
                const result = await response.json();

                if (result.success) {
                    const data = result.data;
                    const date = new Date(data.tanggal_tidur);
                    const formattedDate = date.toLocaleDateString('id-ID', {
                        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                    });

                    const hours = Math.floor(data.durasi_tidur);
                    const minutes = Math.round((data.durasi_tidur - hours) * 60);
                    const durationText = (hours > 0 ? hours + ' jam' : '') + (minutes > 0 ? ' ' + minutes + ' menit' : '');

                    let durationBadgeClass = 'duration-badge';
                    if (data.durasi_tidur >= 7) { } else if (data.durasi_tidur >= 5) { durationBadgeClass += ' duration-warning'; } else { durationBadgeClass += ' duration-danger'; }

                    const wakeBackSection = data.waktu_tidur_kembali ? `
                        <div class="detail-grid">
                            <div class="detail-item-large">
                                <div class="detail-label-large">Waktu Tidur Kembali</div>
                                <div class="detail-value-large">${data.waktu_tidur_kembali} menit</div>
                            </div>
                        </div>
                    ` : '';

                    const reasonSection = data.alasan_kebangunan ? `
                        <div class="detail-section">
                            <h6 class="detail-section-title"><i class="fas fa-comment-medical"></i>Alasan Kebangunan</h6>
                            <div class="text-content">${data.alasan_kebangunan}</div>
                        </div>
                    ` : '';

                    const notesSection = data.catatan_lain ? `
                        <div class="detail-section">
                            <h6 class="detail-section-title"><i class="fas fa-sticky-note"></i>Catatan Lain</h6>
                            <div class="text-content">${data.catatan_lain}</div>
                        </div>
                    ` : '';

                    document.getElementById('detailContent').innerHTML = `
                        <div class="detail-section">
                            <h6 class="detail-section-title"><i class="fas fa-calendar-alt"></i>${formattedDate}</h6>
                            <div class="detail-grid">
                                <div class="detail-item-large">
                                    <div class="detail-label-large">Mulai Tidur</div>
                                    <div class="detail-value-large">${data.waktu_tidur}</div>
                                </div>
                                <div class="detail-item-large">
                                    <div class="detail-label-large">Waktu Bangun</div>
                                    <div class="detail-value-large">${data.waktu_bangun}</div>
                                </div>
                                <div class="detail-item-large">
                                    <div class="detail-label-large">Durasi Tidur</div>
                                    <div class="detail-value-large">${durationText} <span class="${durationBadgeClass}">${Number(data.durasi_tidur).toFixed(2)} jam</span></div>
                                </div>
                                <div class="detail-item-large">
                                    <div class="detail-label-large">Jumlah Kebangunan</div>
                                    <div class="detail-value-large">${data.jumlah_kebangunan} kali</div>
                                </div>
                            </div>
                        </div>
                        ${wakeBackSection}
                        ${reasonSection}
                        ${notesSection}
                    `;
                    detailModal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat Detail',
                        text: result.message,
                        confirmButtonColor: '#0856C8'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal memuat detail catatan tidur',
                    confirmButtonColor: '#0856C8'
                });
            }
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus catatan tidur ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteRecord(id);
                }
            });
        }

        async function deleteRecord(id) {
            try {
                const response = await fetch('{{ route('pengguna.sleep-tracking.index') }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Catatan tidur berhasil dihapus',
                        confirmButtonColor: '#0856C8'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: result.message,
                        confirmButtonColor: '#0856C8'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menghapus catatan tidur',
                    confirmButtonColor: '#0856C8'
                });
            }
        }

        async function handleSubmit(event) {
            event.preventDefault();
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');

            submitText.style.display = 'none';
            submitLoading.style.display = 'inline-block';
            submitBtn.disabled = true;

            const id = document.getElementById('trackingId').value;
            const method = document.getElementById('formMethod').value;
            const formData = new FormData(document.getElementById('sleepForm'));

            try {
                const url = method === 'PUT'
                    ? '{{ route('pengguna.sleep-tracking.index') }}/' + id
                    : '{{ route('pengguna.sleep-tracking.store') }}';

                const response = await fetch(url, {
                    method: method === 'PUT' ? 'PUT' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                        confirmButtonColor: '#0856C8'
                    }).then(() => {
                        modal.hide();
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: result.message,
                        confirmButtonColor: '#0856C8'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menyimpan catatan tidur',
                    confirmButtonColor: '#0856C8'
                });
            } finally {
                submitText.style.display = 'inline';
                submitLoading.style.display = 'none';
                submitBtn.disabled = false;
            }
        }
    </script>
@endpush
