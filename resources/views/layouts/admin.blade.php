<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SI-BESTI - {{ $title ?? 'Dashboard Admin' }}</title>

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
            --light-bg: #F9FAFB;
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
        }

        .admin-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            transition: var(--transition);
            padding-top: 70px;
            padding-bottom: 30px;
        }

        .page-content {
            padding: 25px;
        }

        .card-custom {
            background: var(--white);
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow);
            transition: var(--transition);
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
        }

        .btn-primary-custom {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary-custom:hover {
            background: var(--gradient-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

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
        }

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

        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-admin {
            background: var(--gradient-primary);
            color: white;
        }

        .badge-success {
            background: var(--success);
            color: white;
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }

            .sidebar-toggler {
                display: flex;
            }

            .page-content {
                padding: 20px 15px;
            }
        }

        @media (max-width: 576px) {
            .page-content {
                padding: 15px 10px;
            }

            .card-header-custom {
                padding: 15px 20px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <!-- Header -->
            @include('partials.header')

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
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

            if (window.innerWidth <= 992) {
                if (!sidebar.contains(event.target) && !sidebarToggler.contains(event.target)) {
                    sidebar.classList.remove('active');
                    document.getElementById('main-content').classList.remove('sidebar-active');
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

            if (window.innerWidth > 992) {
                sidebar.classList.remove('active');
                mainContent.classList.remove('sidebar-active');
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
                    // Submit the logout form
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Handle SweetAlert notifications from session
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('swal'))
                Swal.fire({
                    icon: '{{ session("swal.icon") }}',
                    title: '{{ session("swal.title") }}',
                    text: '{{ session("swal.text") }}',
                    timer: 3000,
                    showConfirmButton: true,
                    confirmButtonColor: '#0856C8'
                });
            @endif

            // Auto close Bootstrap alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>

</html>