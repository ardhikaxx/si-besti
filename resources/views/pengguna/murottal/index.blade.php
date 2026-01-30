@extends('layouts.app')

@section('title', 'Murottal Ar-Rahman - SI Besti')

@push('styles')
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
            --gradient-primary: linear-gradient(135deg, #0856C8 0%, #2674E6 100%);
            --gradient-light: linear-gradient(135deg, #E8F0FE 0%, #C6DAFC 100%);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e8f0fe 100%);
            font-family: 'Poppins', sans-serif;
        }

        .murottal-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            padding-bottom: 80px;
        }

        .info-card {
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(8, 86, 200, 0.15);
            margin-bottom: 30px; /* Jarak dengan surah card */
            overflow: hidden;
            border: none;
            transition: all 0.3s ease;
        }

        .info-header {
            background: white;
            padding: 20px 30px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--blue-200);
            transition: background 0.3s;
        }

        .info-header:hover {
            background: var(--blue-100);
        }

        .info-title {
            color: var(--blue-900);
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle-icon {
            color: var(--blue-700);
            transition: transform 0.3s ease;
        }

        .toggle-icon.rotate {
            transform: rotate(180deg);
        }

        .info-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
            background: #fff;
        }

        .info-body {
            padding: 30px;
            color: var(--blue-800);
            line-height: 1.8;
        }

        .info-list {
            list-style: none;
            padding-left: 0;
        }

        .info-list li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 10px;
        }

        .info-list li::before {
            content: '\f00c'; /* FontAwesome Check */
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            color: var(--blue-600);
        }

        /* --- END INFO CARD STYLES --- */

        /* Surah Card */
        .surah-card {
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(8, 86, 200, 0.15);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
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

        .surah-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(8, 86, 200, 0.25);
        }

        /* Surah Number Circle */
        .surah-number {
            flex-shrink: 0;
        }

        .number-circle {
            width: 90px;
            height: 90px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 2rem;
            box-shadow: 0 10px 25px rgba(8, 86, 200, 0.4);
            position: relative;
            animation: float 3s ease-in-out infinite;
        }

        .number-circle::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid rgba(8, 86, 200, 0.3);
            animation: pulse-ring 2s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }

        /* Title Section */
        .card-title {
            color: var(--blue-900);
            font-size: 2rem;
            font-weight: 700;
        }

        .arabic-title {
            font-family: 'Amiri', 'Traditional Arabic', 'Scheherazade', serif;
            font-size: 3rem;
            line-height: 1.4;
            direction: rtl;
            color: var(--blue-800);
            text-shadow: 0 2px 4px rgba(8, 86, 200, 0.1);
        }

        .text-muted {
            color: var(--blue-600) !important;
        }

        /* Badges */
        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .bg-primary-light {
            background: var(--gradient-light);
            color: var(--blue-900);
            border: 2px solid var(--blue-300);
        }

        .bg-primary {
            background: var(--gradient-primary);
            border: none;
        }

        /* Description Section */
        .description-wrapper {
            background: var(--gradient-light);
            padding: 20px;
            border-radius: 15px;
            border-left: 5px solid var(--blue-600);
        }

        .description-wrapper h5 {
            color: var(--blue-900);
            font-weight: 700;
        }

        .surah-description {
            max-height: 250px;
            overflow-y: auto;
            line-height: 1.8;
            text-align: justify;
            font-size: 0.95rem;
            color: var(--blue-800);
            padding-right: 10px;
        }

        .surah-description::-webkit-scrollbar {
            width: 8px;
        }

        .surah-description::-webkit-scrollbar-track {
            background: rgba(8, 86, 200, 0.1);
            border-radius: 10px;
        }

        .surah-description::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: 10px;
        }

        .surah-description::-webkit-scrollbar-thumb:hover {
            background: var(--blue-950);
        }

        /* Audio Preview Section */
        .audio-preview {
            background: var(--gradient-light);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid var(--blue-300);
        }

        .audio-preview h5 {
            color: var(--blue-900);
            font-weight: 700;
        }

        /* Play Button */
        .btn-play {
            background: var(--gradient-primary);
            border: none;
            border-radius: 30px;
            padding: 18px 40px;
            font-weight: 700;
            color: #ffffff;
            font-size: 1.2rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(8, 86, 200, 0.3);
        }

        .btn-play::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-play:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-play:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(8, 86, 200, 0.5);
            color: #ffffff;
        }

        .btn-play i {
            font-size: 1.3rem;
            margin-right: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .murottal-container {
                padding: 15px;
            }

            .number-circle {
                width: 70px;
                height: 70px;
                font-size: 1.5rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .arabic-title {
                font-size: 2rem;
            }

            .btn-play {
                padding: 15px 30px;
                font-size: 1rem;
            }

            .surah-description {
                max-height: 180px;
            }
        }

        @media (max-width: 576px) {
            .surah-card .card-body {
                padding: 25px !important;
            }

            .number-circle {
                width: 60px;
                height: 60px;
                font-size: 1.25rem;
            }

            .arabic-title {
                font-size: 1.75rem;
            }

            .badge {
                padding: 6px 12px;
                font-size: 0.8rem;
            }

            .description-wrapper,
            .audio-preview {
                padding: 15px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .surah-card, .info-card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Utility Classes */
        .shrink-0 { flex-shrink: 0; }
        .grow { flex-grow: 1; }
        .min-width-0 { min-width: 0; }
    </style>
@endpush

@section('content')
    <div class="murottal-container py-3">
        
        <div class="row">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                <div class="card info-card">
                    <div class="info-header" onclick="toggleInfo()">
                        <h5 class="info-title">
                            <i class="fas fa-info-circle text-primary"></i>
                            Informasi & Manfaat Murottal
                        </h5>
                        <i class="fas fa-chevron-down toggle-icon" id="toggleIcon"></i>
                    </div>

                    <div class="info-content" id="infoContent">
                        <div class="info-body">
                            <p class="mb-4">
                                <strong>Murottal</strong> adalah lantunan ayat-ayat Al-Qur’an yang dibaca dengan tartil dan sesuai kaidah tajwid. Surah Ar-Rahman ini dikenal sebagai <em>“pengantin Al-Qur’an”</em> karena keindahan lafaz serta kandungan maknanya tentang berbagai nikmat Allah.
                            </p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-bold mb-3" style="color: var(--blue-900);">
                                        <i class="fas fa-star me-2" style="color: var(--blue-400);"></i>Manfaat Mendengarkan:
                                    </h6>
                                    <ul class="info-list">
                                        <li>Menenangkan hati dan meningkatkan hormon endorphin (hormon kebahagiaan)</li>
                                        <li>Membantu refleksi dan rasa syukur atas nikmat Allah</li>
                                        <li>Mendukung kesehatan mental dengan mengurangi stres, kecemasan, dan ketegangan</li>
                                        <li>Membantu tubuh lebih rileks sehingga berpengaruh positif pada kualitas istirahat</li>
                                    </ul>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-bold mb-3" style="color: var(--blue-900);">
                                        <i class="fas fa-lightbulb me-2" style="color: var(--blue-400);"></i>Tips Mendengarkan:
                                    </h6>
                                    <ul class="info-list">
                                        <li>Posisikan tubuh senyaman mungkin (berbaring, duduk, atau bersandar)</li>
                                        <li>Buka murottal dan hayati bacaan sambil memegang perut atau mengelus dada</li>
                                        <li>Dengarkan dalam suasana tenang dan nyaman</li>
                                        <li>Atur volume suara agar tidak terlalu keras</li>
                                        <li>Lakukan di malam hari rutin selama 7 hari berturut-turut untuk relaksasi maksimal</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card surah-card border-0">
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex align-items-start mb-4">
                            <div class="surah-number me-4 shrink-0">
                                <div class="number-circle">
                                    55
                                </div>
                            </div>
                            <div class="grow min-width-0">
                                <h2 class="card-title mb-3">
                                    <i class="fas fa-book-quran me-2"></i>{{ $surah['nama_latin'] }}
                                </h2>
                                <div class="mb-3">
                                    <h4 class="arabic-title mb-3 text-end">
                                        {{ $surah['nama'] }}
                                    </h4>
                                    <p class="text-muted mb-3">
                                        <i class="fas fa-language me-2"></i>
                                        <strong>{{ $surah['arti'] }}</strong>
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-primary-light">
                                            <i class="fas fa-book-open"></i>
                                            {{ $surah['jumlah_ayat'] }} Ayat
                                        </span>
                                        <span class="badge bg-primary text-white">
                                            <i class="fas fa-location-dot"></i>
                                            {{ ucfirst($surah['tempat_turun']) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="description-wrapper mb-4">
                            <h5 class="h6 mb-3">
                                <i class="fas fa-info-circle me-2"></i>Deskripsi Surah
                            </h5>
                            <div class="surah-description">
                                {!! $surah['deskripsi'] !!}
                            </div>
                        </div>

                        <div class="audio-preview mb-4">
                            <h5 class="h6 mb-3">
                                <i class="fas fa-headphones me-2"></i>Pratinjau Audio
                            </h5>
                            <div class="text-center py-3">
                                <i class="fas fa-music fa-3x" style="color: var(--blue-600); opacity: 0.5;"></i>
                                <p class="text-muted mt-3 mb-0">
                                    <i class="fas fa-volume-up me-2"></i>Klik tombol di bawah untuk mendengarkan murottal lengkap
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('pengguna.murottal.show') }}" class="btn btn-play">
                                <i class="fas fa-play-circle"></i>
                                <span class="d-none d-md-inline">Dengarkan Murottal Lengkap</span>
                                <span class="d-inline d-md-none">Putar Murottal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleInfo() {
            var content = document.getElementById("infoContent");
            var icon = document.getElementById("toggleIcon");
            
            if (content.style.maxHeight) {
                // Jika sedang terbuka, tutup (set height ke null)
                content.style.maxHeight = null;
                icon.classList.remove("rotate");
            } else {
                // Jika tertutup, buka (set height sesuai scrollHeight)
                content.style.maxHeight = content.scrollHeight + "px";
                icon.classList.add("rotate");
            }
        }
    </script>
@endsection