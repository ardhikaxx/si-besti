<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SI Besti')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(135deg, #f5f7ff 0%, #eef1ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Add padding bottom to accommodate floating nav */
        main.container-fluid {
            padding-bottom: 100px;
        }

        @media (max-width: 768px) {
            main.container-fluid {
                padding-bottom: 90px;
            }
        }

        @media (max-width: 480px) {
            main.container-fluid {
                padding-bottom: 80px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <main class="container-fluid">
        <!-- Display Success/Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Include Floating Navigation Bottom -->
    @include('partials.navbottom')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
