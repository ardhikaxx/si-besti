@extends('layouts.app')

@section('title', $surah['nama_latin'] . ' - Murottal Al-Qur\'an - SI Besti')

@section('content')
    <div class="surah-detail-container">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background: var(--gradient-primary);">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-8 mb-3 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('pengguna.murottal') }}"
                                        class="btn btn-light btn-sm me-2 me-md-3 shrink-0">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                    <div class="text-truncate">
                                        <h1 class="h4 h3-md mb-1 text-white fw-bold">
                                            <span class="d-block d-md-inline">{{ $surah['nama_latin'] }}</span>
                                            <small class="h6 h5-md opacity-75">({{ $surah['nama'] }})</small>
                                        </h1>
                                        <p class="text-white mb-0 opacity-75 small text-truncate">
                                            {{ $surah['arti'] }} • {{ $surah['jumlah_ayat'] }} Ayat •
                                            {{ ucfirst($surah['tempat_turun']) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audio Player -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 p-md-4">
                        <h5 class="card-title mb-3 text-primary">
                            <i class="fas fa-play-circle me-2"></i>Murottal Surah Ar-Rahman
                        </h5>
                        <div class="audio-player-wrapper">
                            <div class="audio-container">
                                <audio id="quranAudio" controls class="w-100">
                                    <source src="{{ $surah['audio'] }}" type="audio/mpeg">
                                    Browser Anda tidak mendukung pemutar audio.
                                </audio>
                            </div>
                            <div class="audio-info mt-2 mt-md-3">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                                        <small class="text-muted d-flex align-items-center">
                                            <i class="fas fa-headphones me-2 shrink-0"></i>
                                            <span class="text-truncate">Sedang diputar: {{ $surah['nama_latin'] }}</span>
                                        </small>
                                    </div>
                                    <div class="col-12 col-md-6 text-start text-md-end">
                                        <small class="text-muted d-flex align-items-center justify-content-md-end">
                                            <i class="fas fa-volume-up me-2 shrink-0"></i>
                                            <span>Dengarkan dengan khusyuk</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listening Guide -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-music me-2"></i>Panduan Mendengarkan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="guide-item text-center p-2">
                                    <div class="guide-icon mb-2">
                                        <i class="fas fa-volume-up fa-2x text-primary"></i>
                                    </div>
                                    <p class="mb-0 small">Atur volume yang nyaman</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="guide-item text-center p-2">
                                    <div class="guide-icon mb-2">
                                        <i class="fas fa-bed fa-2x text-primary"></i>
                                    </div>
                                    <p class="mb-0 small">Dengarkan sebelum tidur</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="guide-item text-center p-2">
                                    <div class="guide-icon mb-2">
                                        <i class="fas fa-heart fa-2x text-primary"></i>
                                    </div>
                                    <p class="mb-0 small">Dengarkan dengan hati tenang</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="guide-item text-center p-2">
                                    <div class="guide-icon mb-2">
                                        <i class="fas fa-clock fa-2x text-primary"></i>
                                    </div>
                                    <p class="mb-0 small">Lakukan rutin setiap hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ayat List -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div
                        class="card-header bg-light border-0 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h5 class="mb-2 mb-md-0 text-primary">
                            <i class="fas fa-list me-2"></i>Daftar Ayat
                        </h5>
                        <span class="badge bg-primary">
                            {{ $surah['jumlah_ayat'] }} Ayat
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="ayat-list-container">
                            @foreach ($surah['ayat'] as $ayat)
                                <div class="ayat-item p-3 p-md-4 border-bottom">
                                    <div class="d-flex align-items-start">
                                        <div class="ayat-number me-3 shrink-0">
                                            <div class="ayat-circle">
                                                {{ $ayat['nomor'] }}
                                            </div>
                                        </div>
                                        <div class="grow min-width-0">
                                            <div class="arabic-text mb-2 mb-md-3 text-end overflow-auto"
                                                style="direction: rtl;">
                                                <span
                                                    style="font-size: clamp(1.5rem, 4vw, 2rem); font-family: 'Amiri', serif;">
                                                    {{ $ayat['ar'] }}
                                                </span>
                                            </div>
                                            <div class="transliteration mb-2 text-muted small">
                                                <i class="fas fa-language me-2"></i>
                                                <span class="text-break">{{ $ayat['tr'] }}</span>
                                            </div>
                                            <div class="translation text-primary">
                                                <i class="fas fa-book me-2"></i>
                                                <span class="text-break">{{ $ayat['idn'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('pengguna.murottal') }}" class="btn btn-outline-primary btn-lg px-5">
                        <i class="fas fa-chevron-left me-2"></i>
                        Kembali
                    </a>
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
        }

        .surah-detail-container {
            max-width: 1000px;
            margin: 0 auto;
            padding-bottom: 80px;
            overflow-x: hidden;
        }

        /* Responsive typography */
        .h3-md {
            font-size: 1.75rem;
        }

        .h5-md {
            font-size: 1.25rem;
        }

        .fa-xl-md {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .h3-md {
                font-size: 1.5rem;
            }

            .h5-md {
                font-size: 1.1rem;
            }

            .fa-xl-md {
                font-size: 1.25rem;
            }
        }

        .surah-number-large {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        @media (min-width: 768px) {
            .surah-number-large {
                width: 80px;
                height: 80px;
                font-size: 2rem;
                border-width: 3px;
            }
        }

        .audio-player-wrapper {
            background: var(--blue-100);
            border-radius: 12px;
            padding: 15px;
        }

        @media (min-width: 768px) {
            .audio-player-wrapper {
                padding: 20px;
                border-radius: 15px;
            }
        }

        .audio-container {
            width: 100%;
            overflow: hidden;
        }

        audio {
            width: 100%;
            border-radius: 8px;
            min-height: 40px;
        }

        audio::-webkit-media-controls-panel {
            background: white;
            border-radius: 8px;
        }

        .guide-item {
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .guide-item:hover {
            background: var(--blue-100);
            transform: translateY(-3px);
        }

        .guide-icon {
            width: 60px;
            height: 60px;
            background: var(--blue-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .guide-icon {
                width: 50px;
                height: 50px;
            }

            .guide-icon i {
                font-size: 1.5rem;
            }
        }

        .ayat-list-container {
            max-height: 600px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .ayat-list-container {
                max-height: 500px;
            }
        }

        .ayat-item {
            transition: background-color 0.2s ease;
        }

        .ayat-item:hover {
            background-color: rgba(8, 86, 200, 0.05);
        }

        .ayat-item:last-child {
            border-bottom: none !important;
        }

        .ayat-circle {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .ayat-circle {
                width: 35px;
                height: 35px;
                font-size: 0.85rem;
            }
        }

        .arabic-text {
            line-height: 1.6;
            font-family: 'Amiri', 'Traditional Arabic', 'Scheherazade', serif;
        }

        .min-width-0 {
            min-width: 0;
        }

        .btn-outline-primary {
            border-color: var(--blue-700);
            color: var(--blue-700);
            border-width: 2px;
            border-radius: 12px;
            padding: 10px 30px;
            font-weight: 600;
        }

        .btn-outline-primary:hover {
            background-color: var(--blue-700);
            border-color: var(--blue-700);
        }

        @media (max-width: 768px) {
            .btn-outline-primary {
                padding: 8px 20px;
                border-radius: 10px;
            }
        }

        .text-break {
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .surah-detail-container {
                padding-left: 12px;
                padding-right: 12px;
                padding-bottom: 100px;
            }

            .card-body {
                padding: 1rem !important;
            }

            .ayat-item {
                padding: 1rem !important;
            }

            audio {
                min-height: 35px;
            }

            .arabic-text span {
                font-size: 1.25rem !important;
            }
        }

        @media (max-width: 360px) {
            .surah-number-large {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .ayat-circle {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }

        /* Custom scrollbar for ayat list */
        .ayat-list-container::-webkit-scrollbar {
            width: 8px;
        }

        .ayat-list-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .ayat-list-container::-webkit-scrollbar-thumb {
            background: var(--blue-500);
            border-radius: 4px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const audio = document.getElementById('quranAudio');

            // Auto-play with user interaction
            document.addEventListener('click', function initAudio() {
                audio.play().catch(e => console.log("Autoplay requires user interaction"));
                document.removeEventListener('click', initAudio);
            }, {
                once: true
            });

            // Store playback position
            audio.addEventListener('pause', function() {
                localStorage.setItem('arRahmanAudioPosition', audio.currentTime);
            });

            // Restore playback position
            const savedPosition = localStorage.getItem('arRahmanAudioPosition');
            if (savedPosition) {
                audio.currentTime = savedPosition;
            }
        });
    </script>
@endsection
