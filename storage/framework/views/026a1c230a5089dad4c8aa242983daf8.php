<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>SI-BESTI - <?php echo e($title ?? 'Dashboard Admin'); ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            /* Palette Biru dari Gambar */
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

            /* Warna Primer (menggunakan dari palette) */
            --primary: var(--blue-900);
            --primary-dark: var(--blue-950);
            --primary-light: var(--blue-700);
            --primary-lighter: var(--blue-100);
            --gradient-primary: linear-gradient(135deg, var(--blue-900), var(--blue-700));
            --gradient-light: linear-gradient(135deg, var(--blue-700), var(--blue-500));

            /* Warna Netral */
            --secondary: #5A5C69;
            --secondary-light: #F8F9FC;
            --light-bg: #F8F9FC;
            --white: #FFFFFF;
            --border-color: #E3E6F0;

            /* Warna Status */
            --success: #1CC88A;
            --success-dark: #17A673;
            --warning: #F6C23E;
            --danger: #E74A3B;
            --info: #36B9CC;

            /* Shadow dan Border */
            --shadow: 0 0.15rem 1.75rem 0 rgba(8, 86, 200, 0.15);
            --shadow-sm: 0 0.125rem 0.25rem rgba(8, 86, 200, 0.1);
            --shadow-lg: 0 0.5rem 2rem 0 rgba(8, 86, 200, 0.25);
            --border-radius: 18px;
            --border-radius-sm: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--secondary);
            overflow-x: hidden;
            font-size: 15px;
            line-height: 1.6;
        }

        .admin-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            transition: var(--transition);
            padding-top: 70px;
            padding-bottom: 30px;
            min-height: 100vh;
            width: calc(100% - 250px);
        }

        .page-content {
            padding: 30px 25px;
            max-width: 100%;
        }

        /* Card Styles */
        .card-custom {
            background: var(--white);
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow);
            transition: var(--transition);
            margin-bottom: 20px;
        }

        .card-custom:hover {
            box-shadow: var(--shadow-lg);
        }

        .card-header-custom {
            background: var(--gradient-primary);
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            padding: 20px 25px;
            border-bottom: none;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Button Styles */
        .btn-primary-custom {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            background: var(--gradient-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            color: white;
        }

        .btn-primary-custom:active {
            transform: translateY(0);
        }

        /* Sidebar Toggler */
        .sidebar-toggler {
            display: none;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--border-radius-sm);
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            cursor: pointer;
            transition: var(--transition);
        }

        .sidebar-toggler:hover {
            background: var(--gradient-light);
            transform: scale(1.05);
        }

        /* Avatar Styles */
        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-lighter);
        }

        .avatar-lg {
            width: 120px;
            height: 120px;
            border: 5px solid var(--white);
            box-shadow: var(--shadow);
        }

        /* Badge Styles */
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8125rem;
        }

        .badge-admin {
            background: var(--gradient-primary);
            color: white;
        }

        .badge-success {
            background: var(--success);
            color: white;
        }

        /* Alert Customization */
        .alert {
            border-radius: var(--border-radius-sm);
            border: none;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background: rgba(28, 200, 138, 0.1);
            color: var(--success-dark);
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: rgba(231, 74, 59, 0.1);
            color: #c62d1f;
            border-left: 4px solid var(--danger);
        }

        .alert-warning {
            background: rgba(246, 194, 62, 0.1);
            color: #c49a29;
            border-left: 4px solid var(--warning);
        }

        .alert-info {
            background: rgba(54, 185, 204, 0.1);
            color: #2995a8;
            border-left: 4px solid var(--info);
        }

        /* Container Fluid Padding */
        .container-fluid {
            padding-right: 0;
            padding-left: 0;
        }

        /* Smooth Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Loading State */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Form Elements */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(8, 86, 200, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 0.5rem;
        }

        /* Table Improvements */
        .table {
            margin-bottom: 0;
        }

        .table > :not(caption) > * > * {
            padding: 0.75rem;
        }

        /* Modal Improvements */
        .modal-content {
            border: none;
            border-radius: var(--border-radius);
        }

        .modal-header {
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
        }

        .modal-footer {
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
        }

        /* Utilities */
        .text-primary-custom {
            color: var(--primary) !important;
        }

        .bg-primary-custom {
            background-color: var(--primary) !important;
        }

        .bg-gradient-primary {
            background: var(--gradient-primary) !important;
        }

        /* Responsive styles */
        @media (max-width: 1399.98px) {
            .page-content {
                padding: 25px 20px;
            }
        }

        @media (max-width: 1199.98px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar-toggler {
                display: flex;
            }
        }

        @media (max-width: 991.98px) {
            .page-content {
                padding: 25px 20px;
            }

            .card-header-custom {
                padding: 18px 20px;
            }

            .card-body {
                padding: 1.25rem;
            }
        }

        @media (max-width: 767.98px) {
            .page-content {
                padding: 20px 15px;
            }

            .main-content {
                padding-top: 65px;
            }

            .card-header-custom {
                padding: 15px 18px;
            }

            .card-body {
                padding: 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .page-content {
                padding: 20px 15px;
            }

            .btn-primary-custom {
                padding: 8px 20px;
                font-size: 0.875rem;
            }

            .card-custom {
                margin-bottom: 15px;
            }

            body {
                font-size: 14px;
            }
        }

        /* Print Styles */
        @media print {
            .sidebar-toggler,
            .navbar,
            #sidebar,
            .btn,
            .no-print {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0 !important;
            }

            .page-content {
                padding: 0 !important;
            }

            .card-custom {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <!-- Header -->
            <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page Content -->
            <div class="page-content">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS -->
    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            if (sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                mainContent.classList.remove('sidebar-active');
            } else {
                sidebar.classList.add('active');
                mainContent.classList.add('sidebar-active');
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggler = document.querySelector('.sidebar-toggler');

            if (window.innerWidth <= 1199) {
                if (!sidebar.contains(event.target) && sidebarToggler && !sidebarToggler.contains(event.target)) {
                    sidebar.classList.remove('active');
                    const mainContent = document.getElementById('main-content');
                    if (mainContent) {
                        mainContent.classList.remove('sidebar-active');
                    }
                }
            }
        });

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            if (window.innerWidth > 1199) {
                if (sidebar) sidebar.classList.remove('active');
                if (mainContent) mainContent.classList.remove('sidebar-active');
            }
        });

        // Global logout function with SweetAlert confirmation
        function logoutAdmin(event) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0856C8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    showLoading();
                    // Submit the logout form
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Loading functions
        function showLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) overlay.classList.add('active');
        }

        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) overlay.classList.remove('active');
        }

        // Handle SweetAlert notifications from session
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading on page load
            hideLoading();

            <?php if(session('swal')): ?>
                Swal.fire({
                    icon: '<?php echo e(session("swal.icon")); ?>',
                    title: '<?php echo e(session("swal.title")); ?>',
                    text: '<?php echo e(session("swal.text")); ?>',
                    timer: 3000,
                    showConfirmButton: true,
                    confirmButtonColor: '#0856C8'
                });
            <?php endif; ?>

            <?php if(session('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?php echo e(session("success")); ?>',
                    timer: 3000,
                    showConfirmButton: true,
                    confirmButtonColor: '#0856C8'
                });
            <?php endif; ?>

            <?php if(session('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '<?php echo e(session("error")); ?>',
                    timer: 3000,
                    showConfirmButton: true,
                    confirmButtonColor: '#0856C8'
                });
            <?php endif; ?>

            // Auto close Bootstrap alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '#!') {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\si-besti\resources\views/layouts/admin.blade.php ENDPATH**/ ?>