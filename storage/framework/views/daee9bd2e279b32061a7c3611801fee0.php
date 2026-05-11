

<?php $__env->startSection('title', 'Data Ibu Hamil'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-section mb-4">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-8">
                    <div class="page-title-wrapper">
                        <h1 class="page-title mb-2 fw-bold" style="color: var(--primary);">
                            <i class="fas fa-users-cog me-2"></i>Data Ibu Hamil
                        </h1>
                        <p class="page-subtitle text-muted mb-0">Kelola data ibu hamil yang terdaftar dalam sistem</p>
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

        <!-- Alert Messages -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

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
                            <h6 class="stats-label">Total Ibu Hamil</h6>
                            <h2 class="stats-value" id="totalCount">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-success">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-wifi"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Online</h6>
                            <h2 class="stats-value" id="onlineCount">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-secondary">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-secondary bg-opacity-10 text-secondary">
                                <i class="fas fa-ban"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Offline</h6>
                            <h2 class="stats-value" id="offlineCount">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stats-card stats-card-info">
                    <div class="stats-card-body">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                        </div>
                        <div class="stats-content">
                            <h6 class="stats-label">Usia Kehamilan</h6>
                            <h2 class="stats-value stats-value-small" id="trimesterInfo">-</h2>
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
                            <i class="fas fa-table me-2"></i> Daftar Ibu Hamil
                        </h5>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="search-wrapper">
                            <div class="search-input-group">
                                <span class="search-icon">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="search-input" id="searchInput"
                                    placeholder="Cari nama ibu hamil...">
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
                    <table class="modern-table" id="ibuTable">
                        <thead>
                            <tr>
                                <th class="th-number">#</th>
                                <th class="th-name">Nama Lengkap</th>
                                <th class="th-status">Status</th>
                                <th class="th-age">Umur</th>
                                <th class="th-pregnancy">Usia Kehamilan</th>
                                <th class="th-child">Hamil Anak Ke</th>
                                <th class="th-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($dataIbu) > 0): ?>
                                <?php $__currentLoopData = $dataIbu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ibu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($ibu['id']); ?>" class="table-row">
                                        <td class="td-number">
                                            <span class="row-number"><?php echo e($index + 1); ?></span>
                                        </td>
                                        <td class="td-name">
                                            <div class="user-info">
                                                <div class="user-avatar-small text-capitalize">
                                                    <?php echo e(substr($ibu['nama_lengkap'], 0, 1)); ?>

                                                </div>
                                                <span class="user-name text-capitalize"><?php echo e($ibu['nama_lengkap']); ?></span>
                                            </div>
                                        </td>
                                        <td class="td-status">
                                            <span
                                                class="status-badge status-<?php echo e($ibu['status'] == 'online' ? 'online' : 'offline'); ?>">
                                                <i
                                                    class="fas fa-<?php echo e($ibu['status'] == 'online' ? 'wifi' : 'ban'); ?> me-1"></i>
                                                <?php echo e(ucfirst($ibu['status'])); ?>

                                            </span>
                                        </td>
                                        <td class="td-age">
                                            <span class="age-text"><?php echo e($ibu['umur']); ?> tahun</span>
                                        </td>
                                        <td class="td-pregnancy">
                                            <span class="pregnancy-text"><?php echo e($ibu['usia_kehamilan']); ?></span>
                                        </td>
                                        <td class="td-child">
                                            <span class="child-badge"><?php echo e($ibu['hamil_anak_ke']); ?></span>
                                        </td>
                                        <td class="td-action">
                                            <button type="button" class="action-btn action-btn-view"
                                                onclick="showDetail(<?php echo e($ibu['id']); ?>)" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                                <span class="action-text">Detail</span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <div class="empty-state-content">
                                            <i class="fas fa-inbox empty-icon"></i>
                                            <p class="empty-text">Tidak ada data ibu hamil</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if(count($dataIbu) > 0): ?>
                <div class="data-table-footer">
                    <div class="row align-items-center g-3">
                        <div class="col-12 col-md-6">
                            <div class="footer-info">
                                <span class="text-muted">
                                    Menampilkan <strong class="text-dark"><?php echo e(count($dataIbu)); ?></strong> data ibu hamil
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
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content modern-modal">
                <div class="modal-header-modern">
                    <h5 class="modal-title-modern" id="detailModalLabel">
                        <i class="fas fa-user-circle me-2"></i> Detail Data Ibu Hamil
                    </h5>
                    <button type="button" class="btn-close-modern" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body-modern" style="min-height: 70vh; overflow-y: auto;">
                    <div id="modalLoading" class="loading-state">
                        <div class="spinner-wrapper">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <p class="loading-text">Memuat data...</p>
                    </div>
                    <div id="modalContent" class="d-none">
                        <div class="row g-4">
                            <!-- Profile Section -->
                            <div class="col-12 col-md-4 order-md-2">
                                <div class="profile-card">
                                    <div class="profile-avatar-wrapper">
                                        <img id="detailAvatar" src="" alt="Avatar" class="profile-avatar">
                                    </div>
                                    <div id="detailStatusBadge" class="profile-status"></div>
                                </div>
                            </div>

                            <!-- Details Section -->
                            <div class="col-12 col-md-8 order-md-1">
                                <div class="detail-header">
                                    <h4 id="detailNama" class="detail-name"></h4>
                                    <p class="detail-id">
                                        <i class="fas fa-id-card me-2"></i> ID: <span id="detailId"></span>
                                    </p>
                                </div>

                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-phone text-primary me-2"></i>Nomor Telepon
                                        </label>
                                        <div class="detail-value" id="detailTelepon"></div>
                                    </div>
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-birthday-cake text-primary me-2"></i>Umur
                                        </label>
                                        <div class="detail-value" id="detailUmur"></div>
                                    </div>
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-venus-mars text-primary me-2"></i>Jenis Kelamin
                                        </label>
                                        <div class="detail-value" id="detailJenisKelamin"></div>
                                    </div>
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-baby text-primary me-2"></i>Hamil Anak Ke
                                        </label>
                                        <div class="detail-value" id="detailHamilAnakKe"></div>
                                    </div>
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-child text-primary me-2"></i>Jumlah Anak
                                        </label>
                                        <div class="detail-value" id="detailJumlahAnak"></div>
                                    </div>
                                    <div class="detail-item">
                                        <label class="detail-label">
                                            <i class="fas fa-clock text-primary me-2"></i>Usia Kehamilan
                                        </label>
                                        <div class="detail-value" id="detailUsiaKehamilan"></div>
                                    </div>
                                    <div class="detail-item detail-item-full">
                                        <label class="detail-label">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat
                                        </label>
                                        <div class="detail-value" id="detailAlamat"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
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

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-online {
            background: #d1f5e6;
            color: #0a7a4a;
        }

        .status-offline {
            background: #e9ecef;
            color: #6c757d;
        }

        .age-text,
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

        /* ===== Modal ===== */
        .modern-modal {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .modal-header-modern {
            background: linear-gradient(135deg, var(--primary) 0%, #064a9e 100%);
            padding: 1.5rem 2rem;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .loading-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .spinner-wrapper {
            margin-bottom: 1rem;
        }

        .loading-text {
            color: #6c757d;
            margin: 0;
        }

        /* Profile Card */
        .profile-card {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
        }

        .profile-avatar-wrapper {
            margin-bottom: 1.5rem;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-status {
            margin-bottom: 1.5rem;
        }

        /* Detail Section */
        .detail-header {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .detail-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }

        .detail-id {
            color: #6c757d;
            margin: 0;
            font-size: 0.9375rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .detail-item-full {
            grid-column: 1 / -1;
        }

        .detail-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .detail-value {
            background: #f8f9fa;
            padding: 0.875rem 1rem;
            border-radius: 10px;
            font-size: 0.9375rem;
            color: #212529;
            border: 1px solid #e9ecef;
        }

        .modal-footer-modern {
            padding: 1.25rem 2rem;
            background: #f8f9fa;
            border: none;
            display: flex;
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

            .detail-grid {
                grid-template-columns: 1fr;
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
            fetch('<?php echo e(route('admin.data-ibu.statistics')); ?>')
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
                } else {
                    performSearch(); // Live search
                }
            });
        }

        // Perform search
        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#ibuTable tbody tr:not(.empty-state)');

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
            const tbody = document.querySelector('#ibuTable tbody');
            const existingEmpty = tbody.querySelector('.empty-state');

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
            document.getElementById('detailUmur').textContent = data.umur + ' tahun';
            document.getElementById('detailJenisKelamin').textContent = data.jenis_kelamin;
            document.getElementById('detailHamilAnakKe').textContent = data.hamil_anak_ke;
            document.getElementById('detailJumlahAnak').textContent = data.jumlah_anak + ' anak';
            document.getElementById('detailUsiaKehamilan').textContent = data.usia_kehamilan;
            document.getElementById('detailAlamat').textContent = data.alamat;

            // Avatar
            const avatar = document.getElementById('detailAvatar');
            avatar.src =
                `https://ui-avatars.com/api/?name=${encodeURIComponent(data.nama_lengkap)}&background=0856C8&color=fff&size=256&font-size=0.4&bold=true`;

            // Status badge
            const statusBadge = document.getElementById('detailStatusBadge');
            const statusClass = data.status.toLowerCase() === 'online' ? 'status-online' : 'status-offline';
            const statusIcon = data.status.toLowerCase() === 'online' ? 'wifi' : 'ban';
            statusBadge.innerHTML = `
                <span class="status-badge ${statusClass}">
                    <i class="fas fa-${statusIcon} me-1"></i>
                    ${data.status}
                </span>
            `;
        }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\si-besti\resources\views/admins/data-ibu/index.blade.php ENDPATH**/ ?>