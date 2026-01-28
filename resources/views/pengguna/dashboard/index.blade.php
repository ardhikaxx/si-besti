@extends('layouts.app')

@section('title', 'Dashboard - SI Besti')

@section('content')
    <div class="dashboard-container py-3" style="margin-bottom: 20px;">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, var(--blue-100), var(--blue-200));">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column align-items-start">
                                <h3 class="fw-bold mb-2" style="color: var(--blue-900);">
                                    <i class="fas fa-person-breastfeeding me-2"></i>Hi, {{ $pengguna->nama_lengkap }}!
                                </h3>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    {{ now()->translatedFormat('l, d F Y') }}
                                </p>
                            </div>

                            <div class="text-end">
                                <div class="avatar-circle bg-primary text-white">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="row mb-4">
            <div class="col-md-6">
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
                                        <td class="text-muted"><i class="fas fa-children me-2"></i>Jumlah Anak</td>
                                        <td class="fw-bold">{{ $pengguna->jumlah_anak }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Grafik Kualitas Tidur
                        </h5>
                    </div>
                    <div class="card-body">

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
                            <i class="fas fa-bed text-primary fa-3x"></i>
                        </div>
                        <h5 class="card-title fw-bold">Sleep Tracking</h5>
                        <p class="card-text text-muted">Input dan tracking jam tidur sampai jam bangun Anda.</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-gear me-2"></i>Atur Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-file-signature text-primary fa-3x"></i>
                        </div>
                        <h5 class="card-title fw-bold">Test Kualitas Tidur</h5>
                        <p class="card-text text-muted">Segera test kualitas tidur untuk mengetahui kualitas tidur Anda.
                        </p>
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-comments me-2"></i>Mulai Test
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-hands-praying text-primary fa-3x"></i>
                        </div>
                        <h5 class="card-title fw-bold">Murottal Al-Qur'an</h5>
                        <p class="card-text text-muted">Putar Murottal Al-Qur'an untuk menemani waktu tidur Anda.</p>
                        <a href="{{ route('pengguna.murottal') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-play me-2"></i>Putar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        
        /* Ensure content doesn't overlap with floating nav */
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
@endsection
