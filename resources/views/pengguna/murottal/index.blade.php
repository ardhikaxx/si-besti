@extends('layouts.app')

@section('title', 'Murottal Ar-Rahman - SI Besti')

@section('content')
    <div class="murottal-container py-3">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card surah-card border-0 h-100">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-start mb-4">
                            <div class="surah-number me-4 shrink-0">
                                <div class="number-circle">
                                    55
                                </div>
                            </div>
                            <div class="grow min-width-0">
                                <h2 class="card-title fw-bold mb-2 text-primary">
                                    {{ $surah['nama_latin'] }}
                                </h2>
                                <div class="mb-3">
                                    <h4 class="arabic-title mb-2 text-end"
                                        style="font-family: 'Amiri', serif; font-size: 2.5rem; direction: rtl;">
                                        {{ $surah['nama'] }}
                                    </h4>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-language me-2"></i>
                                        {{ $surah['arti'] }}
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-primary-light text-primary">
                                            <i class="fas fa-book-open me-1"></i>
                                            {{ $surah['jumlah_ayat'] }} Ayat
                                        </span>
                                        <span class="badge bg-primary text-white">
                                            <i class="fas fa-location-dot me-1"></i>
                                            {{ ucfirst($surah['tempat_turun']) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="description-wrapper mb-4">
                            <h5 class="h6 text-primary mb-2">
                                <i class="fas fa-info-circle me-2"></i>Deskripsi
                            </h5>
                            <div class="surah-description" style="max-height: 200px; overflow-y: auto;">
                                {!! $surah['deskripsi'] !!}
                            </div>
                        </div>

                        <div class="audio-preview mb-4">
                            <h5 class="h6 text-primary mb-2">
                                <i class="fas fa-headphones me-2"></i>Pratinjau Audio
                            </h5>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('pengguna.murottal.show') }}" class="btn btn-primary btn-lg px-5 py-3">
                                <i class="fas fa-play-circle me-2 me-md-3"></i>
                                <span class="d-none d-md-inline">Dengarkan Murottal Lengkap</span>
                                <span class="d-inline d-md-none">Putar Murottal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-star me-2"></i>Keutamaan Surah Ar-Rahman
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="benefit-item text-center p-3">
                                    <div class="benefit-icon mb-3">
                                        <i class="fas fa-heart fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Menenteramkan Hati</h6>
                                    <p class="text-muted small mb-0">Membaca Ar-Rahman dapat menenangkan hati dan pikiran
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="benefit-item text-center p-3">
                                    <div class="benefit-icon mb-3">
                                        <i class="fas fa-bed fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Membantu Tidur</h6>
                                    <p class="text-muted small mb-0">Mendengarkannya sebelum tidur membantu kualitas tidur
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="benefit-item text-center p-3">
                                    <div class="benefit-icon mb-3">
                                        <i class="fas fa-brain fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Relaksasi Pikiran</h6>
                                    <p class="text-muted small mb-0">Melodi ayat-ayatnya membantu relaksasi mental</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="benefit-item text-center p-3">
                                    <div class="benefit-icon mb-3">
                                        <i class="fas fa-pray fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Pahala Berlipat</h6>
                                    <p class="text-muted small mb-0">Mendapat pahala membaca dan mendengarkan Al-Qur'an</p>
                                </div>
                            </div>
                        </div>
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
            --gradient-primary: linear-gradient(135deg, var(--blue-900), var(--blue-700));
            --gradient-light: linear-gradient(135deg, var(--blue-700), var(--blue-500));
            --primary: var(--blue-900);
            --primary-light: var(--blue-100);
            --warning-light: #FFF3CD;
        }

        .murottal-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-bottom: 80px;
            overflow-x: hidden;
        }

        /* Responsive typography */
        .fa-3x-md {
            font-size: 3rem;
        }

        .h2-md {
            font-size: 2rem;
        }

        .h3-md {
            font-size: 1.75rem;
        }

        .h4-md {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .fa-3x-md {
                font-size: 2rem;
            }

            .h2-md {
                font-size: 1.5rem;
            }

            .h3-md {
                font-size: 1.5rem;
            }

            .h4-md {
                font-size: 1.25rem;
            }
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .icon-wrapper {
                width: 70px;
                height: 70px;
            }
        }

        .stat-card {
            text-align: center;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            min-width: 100px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        @media (min-width: 768px) {
            .stat-card {
                padding: 15px 25px;
                min-width: 120px;
            }

            .stat-number {
                font-size: 1.75rem;
            }

            .stat-label {
                font-size: 0.9rem;
            }
        }

        .surah-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .surah-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: var(--gradient-primary);
        }

        .number-circle {
            width: 70px;
            height: 70px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(8, 86, 200, 0.3);
        }

        @media (max-width: 768px) {
            .number-circle {
                width: 60px;
                height: 60px;
                font-size: 1.25rem;
            }
        }

        .min-width-0 {
            min-width: 0;
        }

        .arabic-title {
            line-height: 1.3;
            font-family: 'Amiri', 'Traditional Arabic', 'Scheherazade', serif;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .bg-primary-light {
            background-color: var(--primary-light) !important;
        }

        .bg-warning-light {
            background-color: var(--warning-light) !important;
        }

        .surah-description {
            line-height: 1.6;
            text-align: justify;
            font-size: 0.95rem;
        }

        .surah-description::-webkit-scrollbar {
            width: 6px;
        }

        .surah-description::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .surah-description::-webkit-scrollbar-thumb {
            background: var(--blue-500);
            border-radius: 3px;
        }

        .audio-preview-wrapper {
            border: 1px solid var(--blue-200);
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background: var(--gradient-light);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.4);
        }

        .btn-lg {
            font-size: 1.1rem;
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .btn-primary {
                padding: 10px 20px;
                font-size: 1rem;
            }

            .btn-lg {
                font-size: 1rem;
            }
        }

        .benefit-item {
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .benefit-item:hover {
            background: var(--blue-50);
            transform: translateY(-5px);
        }

        .benefit-icon {
            width: 70px;
            height: 70px;
            background: var(--blue-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .benefit-icon {
                width: 60px;
                height: 60px;
            }

            .benefit-icon i {
                font-size: 1.5rem;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .murottal-container {
                padding-left: 12px;
                padding-right: 12px;
                padding-bottom: 100px;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .surah-description {
                max-height: 150px;
            }

            .arabic-title {
                font-size: 1.75rem !important;
            }
        }

        @media (max-width: 360px) {
            .icon-wrapper {
                width: 50px;
                height: 50px;
            }

            .icon-wrapper i {
                font-size: 1.5rem;
            }

            .stat-card {
                min-width: 80px;
                padding: 8px 12px;
            }

            .stat-number {
                font-size: 1.25rem;
            }
        }

        /* Ensure content doesn't overflow */
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Gap utilities */
        .gap-2 {
            gap: 0.5rem !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }
    </style>
@endsection
