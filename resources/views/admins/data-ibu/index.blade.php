@extends('layouts.admin')

@section('title', 'Data Ibu Hamil')
@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div
            class="d-flex flex-column flex-lg-row justify-content-start justify-content-lg-between align-items-start align-items-lg-center mb-4 gap-2 gap-lg-0">
            <div>
                <h1 class="h3 mb-0 fw-bold" style="color: var(--primary);">Data Ibu Hamil</h1>
                <p class="text-muted mb-0">Kelola data ibu hamil yang terdaftar dalam sistem</p>
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
                                <h6 class="mb-0 text-muted">Total Ibu Hamil</h6>
                                <h3 class="mb-0 fw-bold" id="totalCount">0</h3>
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
                                <i class="fas fa-wifi fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Online</h6>
                                <h3 class="mb-0 fw-bold" id="onlineCount">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-secondary bg-opacity-10 text-secondary rounded-3 p-2 me-3">
                                <i class="fas fa-ban fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Offline</h6>
                                <h3 class="mb-0 fw-bold" id="offlineCount">0</h3>
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
                                <i class="fas fa-chart-pie fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-muted">Usia Kehamilan</h6>
                                <h3 class="mb-0 fw-bold" id="trimesterInfo">-</h3>
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
                        <h5 class="mb-0 text-white"><i class="fas fa-table me-2"></i> Daftar Ibu Hamil</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group input-group-sm me-2" style="width: 250px;">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari nama ibu...">
                            <button class="btn btn-outline-light" type="button" id="searchBtn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="ibuTable">
                        <thead>
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Nama Lengkap</th>
                                <th>Status</th>
                                <th>Umur</th>
                                <th>Usia Kehamilan</th>
                                <th>Hamil Anak Ke</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($dataIbu) > 0)
                                @foreach ($dataIbu as $index => $ibu)
                                    <tr data-id="{{ $ibu['id'] }}">
                                        <td class="ps-4">{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $ibu['nama_lengkap'] }}</td>
                                        <td>
                                            <span
                                                class="badge-custom badge-{{ $ibu['status'] == 'online' ? 'success' : 'secondary' }}">
                                                <i
                                                    class="fas fa-{{ $ibu['status'] == 'online' ? 'wifi' : 'ban' }} me-1"></i>
                                                {{ ucfirst($ibu['status']) }}
                                            </span>
                                        </td>
                                        <td>{{ $ibu['umur'] }} tahun</td>
                                        <td>{{ $ibu['usia_kehamilan'] }}</td>
                                        <td>{{ $ibu['hamil_anak_ke'] }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    onclick="showDetail({{ $ibu['id'] }})" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-3"></i>
                                            <p class="mb-0">Tidak ada data ibu hamil</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if (count($dataIbu) > 0)
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan <strong>{{ count($dataIbu) }}</strong> data ibu hamil
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary text-white border-0">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="fas fa-user-circle me-2"></i> Detail Data Ibu Hamil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="modalLoading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Memuat data...</p>
                    </div>
                    <div id="modalContent" class="d-none">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <h4 id="detailNama" class="fw-bold mb-1"></h4>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-id-card me-1"></i> ID: <span id="detailId"></span>
                                    </p>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Nomor Telepon</label>
                                        <div class="form-control-modern bg-light">
                                            <i class="fas fa-phone me-2 text-primary"></i>
                                            <span id="detailTelepon"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Umur</label>
                                        <div class="form-control-modern bg-light">
                                            <i class="fas fa-birthday-cake me-2 text-primary"></i>
                                            <span id="detailUmur"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Jenis Kelamin</label>
                                        <div class="form-control-modern bg-light">
                                            <i class="fas fa-venus-mars me-2 text-primary"></i>
                                            <span id="detailJenisKelamin"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Hamil Anak Ke</label>
                                        <div class="form-control-modern bg-light">
                                            <i class="fas fa-baby me-2 text-primary"></i>
                                            <span id="detailHamilAnakKe"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Jumlah Anak</label>
                                        <div class="form-control-modern bg-light">
                                            <i class="fas fa-child me-2 text-primary"></i>
                                            <span id="detailJumlahAnak"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-muted">Usia Kehamilan</label>
                                        <div class="form-control-modern bg-light">
                                            <i class="fas fa-clock me-2 text-primary"></i>
                                            <span id="detailUsiaKehamilan"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="form-label fw-semibold text-muted">Alamat</label>
                                    <div class="form-control-modern bg-light">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                        <span id="detailAlamat"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-4">
                                <div class="card card-custom mb-4">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <div class="avatar-wrapper d-inline-block">
                                                <img id="detailAvatar" src="" alt="Avatar"
                                                    class="avatar-lg border-4 border-white shadow-sm">
                                            </div>
                                        </div>
                                        <div id="detailStatusBadge" class="mb-3"></div>
                                        <div class="text-muted small">
                                            <div class="mb-2">
                                                <i class="fas fa-calendar-plus me-1"></i>
                                                Bergabung: <span id="detailCreatedAt"></span>
                                            </div>
                                            <div>
                                                <i class="fas fa-calendar-edit me-1"></i>
                                                Terakhir update: <span id="detailUpdatedAt"></span>
                                            </div>
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

    <!-- Print Styles -->
    <style>
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
        }
    </style>

    <!-- Additional Styles -->
    <style>
        .badge-success {
            background: var(--success) !important;
            color: white !important;
        }

        .badge-secondary {
            background: var(--secondary) !important;
            color: white !important;
        }

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

        .form-control-modern {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 14px;
            background-color: #f8f9fa;
            min-height: 44px;
            display: flex;
            align-items: center;
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
        let currentIbuId = null;
        let currentIbuStatus = null;
        let currentIbuNama = null;

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadStatistics();
            initSearch();
        });

        // Load statistics data
        function loadStatistics() {
            fetch('{{ route('admin.data-ibu.statistics') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalCount').textContent = data.total;
                    document.getElementById('onlineCount').textContent = data.online;
                    document.getElementById('offlineCount').textContent = data.offline;

                    // Trimester info
                    const trimesterInfo = `TM1: ${data.trimester1} | TM2: ${data.trimester2} | TM3: ${data.trimester3}`;
                    document.getElementById('trimesterInfo').textContent = trimesterInfo;
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
            const rows = document.querySelectorAll('#ibuTable tbody tr');

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
            currentIbuId = id;
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const modalContent = document.getElementById('modalContent');
            const modalLoading = document.getElementById('modalLoading');

            // Reset modal state
            modalContent.classList.add('d-none');
            modalLoading.classList.remove('d-none');

            // Fetch data
            fetch(`/admin/data-ibu/${id}/detail`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentIbuStatus = data.data.status;
                        currentIbuNama = data.data.nama_lengkap;

                        // Populate modal data
                        populateModalData(data.data);

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
            // Basic info
            document.getElementById('detailId').textContent = data.id;
            document.getElementById('detailNama').textContent = data.nama_lengkap;
            document.getElementById('detailTelepon').textContent = data.nomor_telepon;
            document.getElementById('detailUmur').textContent = data.umur;
            document.getElementById('detailJenisKelamin').textContent = data.jenis_kelamin;
            document.getElementById('detailHamilAnakKe').textContent = data.hamil_anak_ke;
            document.getElementById('detailJumlahAnak').textContent = data.jumlah_anak;
            document.getElementById('detailUsiaKehamilan').textContent = data.usia_kehamilan;
            document.getElementById('detailAlamat').textContent = data.alamat;
            document.getElementById('detailCreatedAt').textContent = data.created_at;
            document.getElementById('detailUpdatedAt').textContent = data.updated_at;

            // Avatar
            const avatar = document.getElementById('detailAvatar');
            avatar.src =
                `https://ui-avatars.com/api/?name=${encodeURIComponent(data.nama_lengkap)}&background=0856C8&color=fff&size=256&font-size=0.4&bold=true`;

            // Status badge
            const statusBadge = document.getElementById('detailStatusBadge');
            statusBadge.innerHTML = `
            <span class="badge-custom badge-${data.status_badge}">
                <i class="fas fa-${data.status === 'Online' ? 'wifi' : 'ban'} me-1"></i>
                ${data.status}
            </span>
        `;
        }
    </script>
@endsection
