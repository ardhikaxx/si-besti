@extends('layouts.app')

@section('title', 'Sleep Tracking')

@push('styles')
    <style>
        .sleep-tracking-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            text-align: center;
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--blue-900);
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: var(--secondary);
            font-size: 0.9rem;
        }

        .stats-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-item {
            background: var(--primary-lighter);
            border-radius: var(--border-radius-sm);
            padding: 15px;
            text-align: center;
            border: 1px solid var(--blue-200);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--blue-900);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--secondary);
            font-weight: 500;
        }

        .add-button-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 25px;
        }

        .add-button {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .add-button:hover {
            background: var(--blue-950);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .sleep-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .sleep-cards-container {
                grid-template-columns: 1fr;
            }
        }

        .sleep-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .sleep-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--blue-400);
        }

        .sleep-date {
            font-size: 0.85rem;
            color: var(--blue-700);
            background: var(--blue-100);
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .sleep-time {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .time-item {
            flex: 1;
            text-align: center;
            padding: 10px;
            background: var(--light-bg);
            border-radius: var(--border-radius-sm);
        }

        .time-label {
            font-size: 0.8rem;
            color: var(--secondary);
            margin-bottom: 5px;
            display: block;
        }

        .time-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--blue-900);
        }

        .sleep-duration {
            background: linear-gradient(135deg, var(--blue-100), var(--blue-200));
            padding: 8px 15px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            color: var(--blue-900);
            display: inline-block;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .sleep-details {
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .detail-label {
            color: var(--secondary);
            font-weight: 500;
        }

        .detail-value {
            color: var(--blue-900);
            font-weight: 500;
            text-align: right;
            max-width: 60%;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: var(--border-radius-sm);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view {
            background: var(--blue-100);
            color: var(--blue-900);
        }

        .btn-view:hover {
            background: var(--blue-200);
        }

        .btn-edit {
            background: var(--warning);
            color: white;
        }

        .btn-edit:hover {
            background: #e0b000;
        }

        .btn-delete {
            background: var(--danger);
            color: white;
        }

        .btn-delete:hover {
            background: #c53030;
        }

        .no-data {
            text-align: center;
            padding: 50px 20px;
            color: var(--secondary);
        }

        .no-data-icon {
            font-size: 4rem;
            color: var(--blue-300);
            margin-bottom: 20px;
        }

        .no-data-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--blue-900);
        }

        .no-data-text {
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--shadow);
            border: 2px dashed var(--blue-300);
        }

        /* Modal Styles */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            background: var(--gradient-primary);
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 20px;
            border: none;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.3rem;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
            color: var(--blue-900);
            margin-bottom: 8px;
            display: block;
            font-size: 0.9rem;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            padding: 12px 15px;
            font-size: 0.9rem;
            transition: var(--transition);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--blue-500);
            box-shadow: 0 0 0 3px rgba(58, 125, 228, 0.1);
            outline: none;
        }

        .time-input-group {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
        }

        .time-separator {
            text-align: center;
            font-weight: 600;
            color: var(--blue-700);
            font-size: 1.2rem;
        }

        textarea.form-control {
            min-height: 80px;
            resize: vertical;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: var(--blue-950);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--secondary-light);
            border: 1px solid var(--border-color);
            padding: 12px 25px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            color: var(--secondary);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: var(--border-color);
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
            to {
                transform: rotate(360deg);
            }
        }

        .detail-modal .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }

        .detail-section {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--blue-900);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .detail-item-large {
            background: var(--light-bg);
            padding: 15px;
            border-radius: var(--border-radius-sm);
        }

        .detail-label-large {
            font-size: 0.9rem;
            color: var(--secondary);
            margin-bottom: 5px;
            font-weight: 500;
        }

        .detail-value-large {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--blue-900);
        }

        .text-content {
            white-space: pre-wrap;
            line-height: 1.6;
            background: var(--light-bg);
            padding: 15px;
            border-radius: var(--border-radius-sm);
            font-size: 0.9rem;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination {
            display: flex;
            gap: 5px;
            list-style: none;
            padding: 0;
        }

        .page-item .page-link {
            padding: 8px 15px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--blue-900);
            text-decoration: none;
            transition: var(--transition);
        }

        .page-item.active .page-link {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--blue-700);
        }

        .page-item:not(.active) .page-link:hover {
            background: var(--blue-100);
            border-color: var(--blue-400);
        }

        .page-item.disabled .page-link {
            color: var(--secondary);
            background: var(--light-bg);
            cursor: not-allowed;
        }

        .duration-info {
            font-size: 0.8rem;
            color: var(--blue-600);
            margin-top: 5px;
            font-style: italic;
        }

        .duration-badge {
            background: linear-gradient(135deg, var(--success), var(--success-dark));
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-left: 5px;
        }

        .duration-warning {
            background: linear-gradient(135deg, var(--warning), #e0b000);
        }

        .duration-danger {
            background: linear-gradient(135deg, var(--danger), #c53030);
        }
    </style>
@endpush

@section('content')
    <div class="sleep-tracking-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-between">
                <div class="text-center text-lg-start">
                    <h1 class="page-title"><i class="fas fa-bed"></i> Sleep Tracking</h1>
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

        <!-- Statistics -->
        <div class="stats-card">
            <h5 style="color: var(--blue-900); margin-bottom: 20px;">
                <i class="fas fa-chart-line"></i> Statistik Tidur Anda
            </h5>
            <div class="stats-grid" id="statisticsContainer">
                <!-- Statistics will be loaded here -->
                <div class="stat-item">
                    <div class="stat-value">0</div>
                    <div class="stat-label"><i class="fas fa-book-open me-2"></i>Total Pencatatan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">0 jam</div>
                    <div class="stat-label"><i class="fas fa-clock me-2"></i>Rata-rata Durasi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">0x</div>
                    <div class="stat-label"><i class="fas fa-wind me-2"></i>Rata-rata Kebangunan</div>
                </div>
            </div>
        </div>

        <!-- Sleep Cards -->
        <div id="sleepCardsContainer">
            @if ($sleepTrackings->count() > 0)
                <div class="sleep-cards-container">
                    @foreach ($sleepTrackings as $tracking)
                        @php
                            // Calculate duration in hours and minutes
                            $hours = floor($tracking->durasi_tidur);
                            $minutes = round(($tracking->durasi_tidur - $hours) * 60);
                            $durationText = $hours > 0 ? $hours . ' jam' : '';
                            $durationText .= $minutes > 0 ? ' ' . $minutes . ' menit' : '';

                            // Determine duration badge color
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
                            <div class="sleep-date">{{ date('d F Y', strtotime($tracking->tanggal_tidur)) }}</div>

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
                                <i class="fas fa-clock me-2"></i> Durasi: {{ $durationText }}
                                <span class="{{ $badgeClass }}">
                                    {{ number_format($tracking->durasi_tidur, 2) }} jam
                                </span>
                            </div>

                            <div class="sleep-details">
                                <div class="detail-item">
                                    <span class="detail-label">Kebangunan:</span>
                                    <span class="detail-value">{{ $tracking->jumlah_kebangunan }} kali</span>
                                </div>
                                @if ($tracking->alasan_kebangunan)
                                    <div class="detail-item">
                                        <span class="detail-label">Alasan:</span>
                                        <span class="detail-value">{{ Str::limit($tracking->alasan_kebangunan, 50) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-actions">
                                <button class="action-btn btn-view" onclick="viewDetail({{ $tracking->id }})">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                                <button class="action-btn btn-edit" onclick="openEditModal({{ $tracking->id }})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="action-btn btn-delete" onclick="confirmDelete({{ $tracking->id }})">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $sleepTrackings->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="no-data-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h3 class="no-data-title">Belum Ada Catatan Tidur</h3>
                    <p class="no-data-text">Mulai catat tidur Anda untuk memantau kualitas tidur harian.</p>
                    <button class="add-button" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        Tambah Catatan Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="sleepModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Catatan Tidur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="sleepForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="trackingId" name="id">

                        <div class="form-group">
                            <label class="form-label">Tanggal Tidur *</label>
                            <input type="date" class="form-control" id="tanggal_tidur" name="tanggal_tidur" required
                                max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Waktu Tidur *</label>
                            <div class="time-input-group">
                                <input type="time" class="form-control" id="waktu_tidur" name="waktu_tidur" required
                                    onchange="calculateDuration()">
                                <span class="time-separator">sampai</span>
                                <input type="time" class="form-control" id="waktu_bangun" name="waktu_bangun"
                                    required onchange="calculateDuration()">
                            </div>
                            <div class="duration-info">
                                Durasi: <span id="durationPreview">0 jam 0 menit</span>
                                (<span id="durationDecimal">0.00 jam</span>)
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Berapa kali kebangun? *</label>
                            <input type="number" class="form-control" id="jumlah_kebangunan" name="jumlah_kebangunan"
                                min="0" max="20" value="0" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alasan kebangunan (jika ada)</label>
                            <textarea class="form-control" id="alasan_kebangunan" name="alasan_kebangunan" rows="3"
                                placeholder="Misal: Ke kamar mandi, mimpi buruk, dll"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catatan lain</label>
                            <textarea class="form-control" id="catatan_lain" name="catatan_lain" rows="3"
                                placeholder="Tambah catatan tentang kualitas tidur, mimpi, atau hal lain"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <span id="submitText">Simpan</span>
                            <span id="submitLoading" class="loading-spinner" style="display: none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Detail Modal -->
    <div class="modal fade detail-modal" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Catatan Tidur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Detail content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let currentTrackingId = null;
        const modal = new bootstrap.Modal(document.getElementById('sleepModal'));
        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));

        // Load statistics on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadStatistics();
            setDefaultTimes();
            calculateDuration(); // Calculate initial duration
        });

        // Set default times for new entries
        function setDefaultTimes() {
            const now = new Date();
            const sleepTime = new Date(now);
            sleepTime.setHours(22, 0, 0); // Default sleep time: 22:00
            const wakeTime = new Date(now);
            wakeTime.setHours(6, 0, 0); // Default wake time: 06:00

            document.getElementById('waktu_tidur').value = sleepTime.toTimeString().slice(0, 5);
            document.getElementById('waktu_bangun').value = wakeTime.toTimeString().slice(0, 5);
        }

        // Calculate duration in real-time
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

            // If wake time is earlier than sleep time, assume it's the next day
            if (wakeDate <= sleepDate) {
                wakeDate.setDate(wakeDate.getDate() + 1);
            }

            const durationInMs = wakeDate - sleepDate;
            const durationInHours = durationInMs / (1000 * 60 * 60);

            const hours = Math.floor(durationInHours);
            const minutes = Math.round((durationInHours - hours) * 60);

            // Update preview
            let durationText = '';
            if (hours > 0) {
                durationText += `${hours} jam `;
            }
            if (minutes > 0) {
                durationText += `${minutes} menit`;
            } else if (hours === 0) {
                durationText = '0 menit';
            }

            document.getElementById('durationPreview').textContent = durationText.trim();
            document.getElementById('durationDecimal').textContent = durationInHours.toFixed(2) + ' jam';

            // Update badge color based on duration
            const durationBadge = document.getElementById('durationDecimal');
            if (durationInHours >= 7) {
                durationBadge.style.color = 'var(--success)';
            } else if (durationInHours >= 5) {
                durationBadge.style.color = 'var(--warning)';
            } else {
                durationBadge.style.color = 'var(--danger)';
            }
        }

        // Load statistics
        async function loadStatistics() {
            try {
                const response = await fetch('{{ route('pengguna.sleep-tracking.statistics') }}');
                const result = await response.json();

                if (result.success) {
                    const stats = result.data;
                    const statsContainer = document.getElementById('statisticsContainer');

                    statsContainer.innerHTML = `
                    <div class="stat-item">
                        <div class="stat-value">${stats.total_records}</div>
                        <div class="stat-label"><i class="fas fa-book-open me-2"></i>Total Pencatatan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">${stats.formatted_average_duration}</div>
                        <div class="stat-label"><i class="fas fa-clock me-2"></i>Rata-rata Durasi</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">${stats.average_wakeups}x</div>
                        <div class="stat-label"><i class="fas fa-wind me-2"></i>Rata-rata Kebangunan</div>
                    </div>
                `;
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memuat Statistik',
                    text: 'Terjadi kesalahan saat memuat statistik tidur',
                    confirmButtonColor: '#3a7de4'
                });
            }
        }

        // Open add modal
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Catatan Tidur';
            document.getElementById('sleepForm').reset();
            document.getElementById('trackingId').value = '';
            document.getElementById('tanggal_tidur').value = new Date().toISOString().split('T')[0];
            setDefaultTimes();
            calculateDuration();
            modal.show();
        }

        // Open edit modal
        async function openEditModal(id) {
            try {
                const response = await fetch(`/sleep-tracking/${id}`);
                const result = await response.json();

                if (result.success) {
                    const data = result.data;
                    document.getElementById('modalTitle').textContent = 'Edit Catatan Tidur';
                    document.getElementById('trackingId').value = data.id;
                    document.getElementById('tanggal_tidur').value = data.tanggal_tidur;
                    document.getElementById('waktu_tidur').value = data.waktu_tidur.substring(0, 5);
                    document.getElementById('waktu_bangun').value = data.waktu_bangun.substring(0, 5);
                    document.getElementById('jumlah_kebangunan').value = data.jumlah_kebangunan;
                    document.getElementById('alasan_kebangunan').value = data.alasan_kebangunan || '';
                    document.getElementById('catatan_lain').value = data.catatan_lain || '';

                    // Calculate and display duration
                    setTimeout(calculateDuration, 100);

                    modal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat Data',
                        text: result.message,
                        confirmButtonColor: '#3a7de4'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal memuat data untuk diedit',
                    confirmButtonColor: '#3a7de4'
                });
            }
        }

        // View detail
        async function viewDetail(id) {
            try {
                const response = await fetch(`/sleep-tracking/${id}`);
                const result = await response.json();

                if (result.success) {
                    const data = result.data;
                    const date = new Date(data.tanggal_tidur);
                    const formattedDate = date.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    // Calculate hours and minutes from duration
                    const hours = Math.floor(data.durasi_tidur);
                    const minutes = Math.round((data.durasi_tidur - hours) * 60);
                    const durationText = hours > 0 ? hours + ' jam' : '';
                    const finalDurationText = durationText + (minutes > 0 ? ' ' + minutes + ' menit' : '');

                    document.getElementById('detailContent').innerHTML = `
                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fas fa-calendar-day"></i>
                            Informasi Tanggal
                        </div>
                        <div class="detail-item-large">
                            <div class="detail-label-large">Tanggal Tidur</div>
                            <div class="detail-value-large">${formattedDate}</div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fas fa-clock"></i>
                            Waktu Tidur
                        </div>
                        <div class="detail-grid">
                            <div class="detail-item-large">
                                <div class="detail-label-large">Mulai Tidur</div>
                                <div class="detail-value-large">${data.waktu_tidur.substring(0,5)}</div>
                            </div>
                            <div class="detail-item-large">
                                <div class="detail-label-large">Bangun</div>
                                <div class="detail-value-large">${data.waktu_bangun.substring(0,5)}</div>
                            </div>
                            <div class="detail-item-large">
                                <div class="detail-label-large">Durasi Tidur</div>
                                <div class="detail-value-large">${finalDurationText} (${parseFloat(data.durasi_tidur).toFixed(2)} jam)</div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fas fa-bed"></i>
                            Kualitas Tidur
                        </div>
                        <div class="detail-grid">
                            <div class="detail-item-large">
                                <div class="detail-label-large">Jumlah Kebangunan</div>
                                <div class="detail-value-large">${data.jumlah_kebangunan} kali</div>
                            </div>
                        </div>
                    </div>

                    ${data.alasan_kebangunan ? `
                                                    <div class="detail-section">
                                                        <div class="detail-section-title">
                                                            <i class="fas fa-comment-medical"></i>
                                                            Alasan Kebangunan
                                                        </div>
                                                        <div class="text-content">${data.alasan_kebangunan}</div>
                                                    </div>
                                                    ` : ''}

                    ${data.catatan_lain ? `
                                                    <div class="detail-section">
                                                        <div class="detail-section-title">
                                                            <i class="fas fa-sticky-note"></i>
                                                            Catatan Lain
                                                        </div>
                                                        <div class="text-content">${data.catatan_lain}</div>
                                                    </div>
                                                    ` : ''}

                    <div class="detail-section">
                        <div class="detail-section-title">
                            <i class="fas fa-history"></i>
                            Riwayat Pencatatan
                        </div>
                        <div class="detail-grid">
                            <div class="detail-item-large">
                                <div class="detail-label-large">Dibuat Pada</div>
                                <div class="detail-value-large">${new Date(data.created_at).toLocaleString('id-ID')}</div>
                            </div>
                            <div class="detail-item-large">
                                <div class="detail-label-large">Terakhir Diperbarui</div>
                                <div class="detail-value-large">${new Date(data.updated_at).toLocaleString('id-ID')}</div>
                            </div>
                        </div>
                    </div>
                `;

                    detailModal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memuat Detail',
                        text: result.message,
                        confirmButtonColor: '#3a7de4'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal memuat detail catatan tidur',
                    confirmButtonColor: '#3a7de4'
                });
            }
        }

        // Confirm delete with SweetAlert2
        function confirmDelete(id) {
            currentTrackingId = id;

            Swal.fire({
                title: 'Hapus Catatan Tidur?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3a7de4',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteTracking();
                }
            });
        }

        // Delete tracking
        async function deleteTracking() {
            if (!currentTrackingId) return;

            try {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const response = await fetch(`/sleep-tracking/${currentTrackingId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    // Remove card from DOM
                    const card = document.getElementById(`card-${currentTrackingId}`);
                    if (card) {
                        card.remove();
                    }

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Dihapus!',
                        text: 'Catatan tidur berhasil dihapus',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Reload statistics
                    loadStatistics();

                    // Check if no cards left
                    const cardsContainer = document.getElementById('sleepCardsContainer');
                    if (!cardsContainer.querySelector('.sleep-card')) {
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menghapus',
                        text: result.message,
                        confirmButtonColor: '#3a7de4'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menghapus catatan tidur',
                    confirmButtonColor: '#3a7de4'
                });
            } finally {
                currentTrackingId = null;
            }
        }

        // Handle form submission
        document.getElementById('sleepForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = document.getElementById('trackingId').value;
            const url = id ? `/sleep-tracking/${id}` : '/sleep-tracking';
            const method = id ? 'PUT' : 'POST';

            try {
                showLoading(document.getElementById('submitBtn'), true);

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: new URLSearchParams(formData)
                });

                const result = await response.json();

                if (result.success) {
                    modal.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: result.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: result.message,
                        confirmButtonColor: '#3a7de4'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menyimpan data catatan tidur',
                    confirmButtonColor: '#3a7de4'
                });
            } finally {
                showLoading(document.getElementById('submitBtn'), false);
            }
        });

        // Show loading state
        function showLoading(button, isLoading) {
            const text = button.querySelector('#submitText') || button.querySelector('#deleteText');
            const loading = button.querySelector('#submitLoading') || button.querySelector('#deleteLoading');

            if (isLoading) {
                text.style.display = 'none';
                loading.style.display = 'inline-block';
                button.disabled = true;
            } else {
                text.style.display = 'inline';
                loading.style.display = 'none';
                button.disabled = false;
            }
        }
    </script>
@endpush
