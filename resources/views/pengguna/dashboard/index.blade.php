@extends('layouts.app')

@section('title', 'Dashboard - SI Besti')

@section('content')
    <div class="dashboard-container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-baby text-primary me-2"></i>
                    <span class="fw-bold text-primary">SI Besti</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>
                                {{ $pengguna->nama_lengkap }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, var(--blue-100), var(--blue-200));">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h1 class="h3 fw-bold mb-2" style="color: var(--blue-900);">
                                    <i class="fas fa-hand-wave me-2"></i>Selamat Datang, {{ $pengguna->nama_lengkap }}!
                                </h1>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    {{ now()->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                            <div class="text-end">
                                <div class="avatar-circle bg-primary text-white">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-id-card me-2"></i>Informasi Pribadi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%" class="text-muted"><i class="fas fa-user me-2"></i>Nama Lengkap
                                        </td>
                                        <td class="fw-bold">{{ $pengguna->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="fas fa-phone me-2"></i>Nomor Telepon</td>
                                        <td class="fw-bold">{{ $pengguna->nomor_telepon }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="fas fa-birthday-cake me-2"></i>Umur</td>
                                        <td class="fw-bold">{{ $pengguna->umur }} tahun</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><i class="fas fa-venus-mars me-2"></i>Jenis Kelamin</td>
                                        <td class="fw-bold">
                                            @if ($pengguna->jenis_kelamin == 'L')
                                                Laki-laki
                                            @else
                                                Perempuan
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="40%" class="text-muted"><i class="fas fa-home me-2"></i>Alamat</td>
                                        <td class="fw-bold">{{ $pengguna->alamat }}</td>
                                    </tr>
                                    @if ($pengguna->usia_kehamilan)
                                        <tr>
                                            <td class="text-muted"><i class="fas fa-baby me-2"></i>Usia Kehamilan</td>
                                            <td class="fw-bold">{{ $pengguna->usia_kehamilan }} minggu</td>
                                        </tr>
                                    @endif
                                    @if ($pengguna->hamil_anak_ke)
                                        <tr>
                                            <td class="text-muted"><i class="fas fa-baby-carriage me-2"></i>Hamil Anak Ke
                                            </td>
                                            <td class="fw-bold">{{ $pengguna->hamil_anak_ke }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-muted"><i class="fas fa-child me-2"></i>Jumlah Anak</td>
                                        <td class="fw-bold">{{ $pengguna->jumlah_anak }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Statistik Singkat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="stat-circle bg-primary text-white mb-3">
                                <i class="fas fa-baby fa-2x"></i>
                            </div>
                            <h4 class="fw-bold">Trimester
                                {{ $pengguna->usia_kehamilan ? ceil($pengguna->usia_kehamilan / 13) : '-' }}</h4>
                            <p class="text-muted">Kehamilan Saat Ini</p>
                        </div>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="fas fa-calendar-check me-2"></i>Minggu Ini
                                </span>
                                <span class="badge bg-primary rounded-pill">{{ $pengguna->usia_kehamilan ?? '0' }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="fas fa-history me-2"></i>Kehamilan Ke
                                </span>
                                <span class="badge bg-success rounded-pill">{{ $pengguna->hamil_anak_ke ?? '0' }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="fas fa-child me-2"></i>Total Anak
                                </span>
                                <span class="badge bg-warning rounded-pill">{{ $pengguna->jumlah_anak }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-calendar-check text-primary fa-3x"></i>
                        </div>
                        <h5 class="card-title fw-bold">Jadwal Periksa</h5>
                        <p class="card-text text-muted">Lihat dan atur jadwal pemeriksaan kehamilan Anda.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Jadwal
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-stethoscope text-success fa-3x"></i>
                        </div>
                        <h5 class="card-title fw-bold">Konsultasi</h5>
                        <p class="card-text text-muted">Konsultasi dengan dokter atau bidan secara online.</p>
                        <a href="#" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-comments me-2"></i>Mulai Konsultasi
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-book-medical text-info fa-3x"></i>
                        </div>
                        <h5 class="card-title fw-bold">Artikel & Tips</h5>
                        <p class="card-text text-muted">Baca artikel dan tips tentang kehamilan sehat.</p>
                        <a href="#" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-book-open me-2"></i>Baca Artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-5 pt-4 border-top">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted">
                        <i class="fas fa-heart text-danger me-1"></i>
                        SI Besti - Sistem Informasi Kehamilan & Persalinan
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="text-muted">
                        &copy; {{ date('Y') }} SI Besti. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <style>
        :root {
            /* Menggunakan variable yang sama dengan auth layout */
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
            --primary: var(--blue-900);
        }

        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .avatar-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--blue-700), var(--blue-900));
        }

        .feature-icon {
            transition: transform 0.3s ease;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.15) !important;
        }

        .hover-lift:hover .feature-icon {
            transform: scale(1.1);
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        .table-borderless td {
            padding: 10px 0;
        }

        .badge {
            padding: 5px 12px;
            font-size: 0.9rem;
        }

        .list-group-item {
            border: none;
            padding: 12px 0;
        }

        .btn-outline-primary {
            border-width: 2px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .avatar-circle {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }

            h1.h3 {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection
