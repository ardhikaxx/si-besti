@extends('layouts.admin')

@section('title', 'Sleep Tracking')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-lg-row justify-content-start justify-content-lg-between align-items-start align-items-lg-center mb-4 gap-2 gap-lg-0">
            <div>
                <h1 class="h3 mb-0 fw-bold" style="color: var(--primary);">Sleep Tracking</h1>
                <p class="text-muted mb-0">Data monitoring tidur ibu hamil</p>
            </div>
            <div>
                <button class="btn btn-primary-custom" onclick="refreshData()">
                    <i class="fas fa-sync-alt me-2"></i> Refresh Data
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                                <i class="fas fa-users fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Pengguna</h6>
                                <h3 class="mb-0 fw-bold" id="totalUsers">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                                <i class="fas fa-bed fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Total Data</h6>
                                <h3 class="mb-0 fw-bold" id="totalRecords">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-info bg-opacity-10 text-info rounded-3 p-2 me-3">
                                <i class="fas fa-clock fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Rata-rata Durasi</h6>
                                <h3 class="mb-0 fw-bold" id="avgDuration">0 jam</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-3 p-2 me-3">
                                <i class="fas fa-calendar-day fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Hari Ini</h6>
                                <h3 class="mb-0 fw-bold" id="todayRecords">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="card card-custom">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-white"><i class="fas fa-table me-2"></i> Daftar Pengguna Sleep Tracking</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group input-group-sm me-2" style="width: 250px;">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari nama...">
                            <button class="btn btn-outline-light" type="button" id="searchBtn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="sleepTable">
                        <thead>
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nama Lengkap</th>
                                <th>Umur</th>
                                <th>Usia Kehamilan</th>
                                <th>Hamil Anak Ke</th>
                                <th>Total Data</th>
                                <th>Data Terakhir</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($dataUsers) > 0)
                                @foreach ($dataUsers as $index => $user)
                                    <tr data-id="{{ $user['id'] }}">
                                        <td class="ps-4">{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $user['nama_lengkap'] }}</td>
                                        <td>{{ $user['umur'] }} tahun</td>
                                        <td>{{ $user['usia_kehamilan'] }}</td>
                                        <td>{{ $user['hamil_anak_ke'] }}</td>
                                        <td>
                                            <span class="badge-custom bg-primary text-white">
                                                <i class="fas fa-bed me-1"></i>
                                                {{ $user['total_sleep_records'] }} data
                                            </span>
                                        </td>
                                        <td>
                                            @if ($user['latest_sleep'])
                                                <div class="small">
                                                    <div><strong>{{ $user['latest_sleep']['tanggal'] }}</strong></div>
                                                    <div class="text-muted">
                                                        {{ $user['latest_sleep']['waktu_tidur'] }} - {{ $user['latest_sleep']['waktu_bangun'] }}
                                                    </div>
                                                    <div class="text-primary">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $user['latest_sleep']['durasi'] }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        onclick="showDetail({{ $user['id'] }})" 
                                                        title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-bed fa-2x mb-3"></i>
                                            <p class="mb-0">Belum ada data sleep tracking</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if (count($dataUsers) > 0)
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan <strong>{{ count($dataUsers) }}</strong> pengguna dengan data sleep tracking
                        </div>
                        <div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail -->
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

        #searchInput {
            border-radius: 10px 0 0 10px;
            border: 2px solid var(--border-color);
        }

        #searchBtn {
            border-radius: 0 10px 10px 0;
            border: 2px solid var(--border-color);
            border-left: none;
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

        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                margin: 2px 0;
                width: 100%;
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
                        document.getElementById('todayRecords').textContent = data.data.today_records;
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
                }
            });
        }

        // Perform search
        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#sleepTable tbody tr');

            rows.forEach(row => {
                const nama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (nama.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
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

            // Statistics
            document.getElementById('statAvgDuration').textContent = data.statistics.avg_duration_formatted;
            document.getElementById('statMinDuration').textContent = data.statistics.min_duration_formatted;
            document.getElementById('statMaxDuration').textContent = data.statistics.max_duration_formatted;
            document.getElementById('statEarlySleep').textContent = data.statistics.sleep_by_time.early;
            document.getElementById('statNormalSleep').textContent = data.statistics.sleep_by_time.normal;
            document.getElementById('statLateSleep').textContent = data.statistics.sleep_by_time.late;

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
                row.innerHTML = `
                    <td class="ps-4">${index + 1}</td>
                    <td>${item.tanggal_full}</td>
                    <td>${item.waktu_tidur}</td>
                    <td>${item.waktu_bangun}</td>
                    <td>
                        <span class="badge bg-primary">${item.durasi_formatted}</span>
                    </td>
                    <td>
                        ${item.jumlah_kebangunan > 0 ? 
                            `<span class="badge bg-warning">${item.jumlah_kebangunan}x</span>` : 
                            `<span class="badge bg-success">Tidak Ada</span>`}
                    </td>
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
    </script>
@endsection