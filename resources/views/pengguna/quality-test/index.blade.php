@extends('layouts.app')

@section('title', 'Test Kualitas Tidur - PSQI')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="card border-0 shadow-lg mb-4" style="border-radius: var(--border-radius);">
            <div class="card-body p-4">
                <div
                    class="d-flex flex-column flex-lg-row align-items-start justify-content-start align-items-lg-center justify-content-lg-between mb-4 gap-3">
                    <div>
                        <h2 class="mb-1 fw-bold" style="color: var(--primary);">
                            <i class="fas fa-file-signature me-2"></i>Test Kualitas Tidur
                        </h2>
                        <p class="text-muted mb-0">Pittsburgh Sleep Quality Index (PSQI) - 2 Hari Test dalam 7 Hari</p>
                    </div>
                    <div class="d-flex align-items-center">
                        @if ($currentTest->status == 'completed')
                            <a href="{{ route('pengguna.quality-test.result', $currentTest->id) }}"
                                class="btn btn-success me-2">
                                <i class="fas fa-chart-bar me-1"></i>Lihat Hasil
                            </a>
                            <button class="btn btn-primary" onclick="startNewTest()">
                                <i class="fas fa-plus me-1"></i>Test Baru
                            </button>
                        @else
                            @php
                                $progress = $currentTest->getProgressPercentage();
                            @endphp
                            <div class="d-flex flex-column flex-lg-row gap-2">
                                <span class="badge bg-secondary px-3 py-2 w-auto">
                                    <i class="fas fa-clock me-1"></i>{{ $testInfo['message'] }}
                                </span>
                                <span class="badge bg-primary px-3 py-2 w-auto">
                                    <i class="fas fa-chart-line me-1"></i>{{ $progress }}% Selesai
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="progress-container mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Progress Test</span>
                        <span class="text-primary fw-bold">
                            @php
                                $firstTest = $currentTest->firstTest;
                                $lastTest = $currentTest->lastTest;
                                $completed = 0;
                                if ($firstTest && $firstTest->is_confirmed) {
                                    $completed++;
                                }
                                if ($lastTest && $lastTest->is_confirmed) {
                                    $completed++;
                                }
                            @endphp
                            {{ $completed }}/2 test selesai
                        </span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%;"
                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="text-center mt-2 text-muted small">
                        Periode: {{ \Carbon\Carbon::parse($currentTest->start_date)->format('d M Y') }} (Hari 1) -
                        {{ \Carbon\Carbon::parse($currentTest->end_date)->format('d M Y') }} (Hari 7)
                    </div>
                </div>

                <!-- Status Info -->
                @if ($currentTest->status == 'ongoing')
                    @if ($testInfo['status'] == 'first_pending')
                        <div class="alert alert-primary border-0 shadow-sm mb-4"
                            style="border-radius: var(--border-radius-sm);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle fa-2x me-3" style="color: var(--primary);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Test Pertama Tersedia!</h6>
                                    <p class="mb-0">Silakan isi test pertama hari ini. Test terakhir akan terkunci sampai
                                        hari ke-7.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($testInfo['status'] == 'first_unconfirmed')
                        <div class="alert alert-primary border-2 shadow-sm mb-4"
                            style="border-radius: var(--border-radius-sm);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Test Pertama Belum Dikonfirmasi!</h6>
                                    <p class="mb-0">Anda sudah mengisi test pertama. Silakan konfirmasi sebelum menunggu
                                        test terakhir.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($testInfo['status'] == 'waiting_for_last')
                        <div class="alert alert-info border-0 shadow-sm mb-4"
                            style="border-radius: var(--border-radius-sm);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-check fa-2x me-3" style="color: var(--info);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Menunggu Test Terakhir</h6>
                                    <p class="mb-0">Test pertama sudah selesai. Test terakhir akan tersedia pada
                                        <strong>{{ \Carbon\Carbon::parse($currentTest->end_date)->format('d M Y') }}</strong>
                                        ({{ $testInfo['days_left'] ?? 0 }} hari lagi).
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($testInfo['status'] == 'last_available')
                        <div class="alert alert-success border-0 shadow-sm mb-4"
                            style="border-radius: var(--border-radius-sm);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x me-3" style="color: var(--success);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Test Terakhir Tersedia!</h6>
                                    <p class="mb-0">Silakan isi test terakhir hari ini untuk melihat hasil perbandingan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Test Cards -->
        <div class="row g-3">
            @foreach ($weekDays as $day)
                @if ($day['is_test_day'])
                    <div class="col-12 col-md-6">
                        <div class="card h-100 border-0 shadow-sm hover-lift"
                            style="border-radius: var(--border-radius-sm); transition: all 0.3s ease; 
                                @if ($day['can_take_test']) border: 2px solid var(--primary); @endif">
                            <div class="card-body p-4">
                                <!-- Day Header -->
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h5 class="mb-0 fw-bold" style="color: var(--primary);">
                                            {{ $day['day_type'] == 'first' ? 'Test Pertama' : 'Test Terakhir' }}
                                        </h5>
                                        <p class="text-muted small mb-0">{{ $day['day_name'] }},
                                            {{ $day['date_formatted'] }}</p>
                                        <p class="text-muted small mb-0">Hari ke-{{ $day['day_number'] }} dari 7</p>
                                    </div>
                                    <div>
                                        @if ($day['is_confirmed'])
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i>Selesai
                                            </span>
                                        @elseif($day['can_take_test'])
                                            <span class="badge bg-primary px-3 py-2">
                                                <i class="fas fa-star me-1"></i>Tersedia
                                            </span>
                                        @elseif($day['is_future'] || !$day['is_available'])
                                            <span class="badge bg-secondary px-3 py-2">
                                                <i class="fas fa-lock me-1"></i>Terkunci
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark px-3 py-2">
                                                <i class="fas fa-clock me-1"></i>Menunggu
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    @if ($day['day_type'] == 'first')
                                        <p class="mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>
                                            Test awal untuk menilai kualitas tidur Anda sebelum intervensi.
                                        </p>
                                        <p class="mb-0 small text-muted"><strong>Batas waktu:</strong> Dapat diisi mulai
                                            hari ini</p>
                                    @else
                                        <p class="mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>
                                            Test akhir untuk menilai perubahan kualitas tidur setelah 7 hari.
                                        </p>
                                        <p class="mb-0 small text-muted"><strong>Batas waktu:</strong> Hanya dapat diisi
                                            pada hari ke-7</p>
                                    @endif
                                </div>

                                <!-- Status & Actions -->
                                <div class="text-center">
                                    @if ($day['has_test'])
                                        @if ($day['is_confirmed'])
                                            <div class="d-flex flex-column align-items-center justify-content-center text-success mb-2 gap-2">
                                                <i class="fas fa-check-circle fa-3x"></i>
                                                <span class="fw-bold">Test Sudah Terkonfirmasi</span>
                                            </div>
                                            @if ($day['test']->total_score !== null)
                                                <div class="score-display mb-3">
                                                    <span
                                                        class="badge bg-{{ $day['test']->getQualityColor() }} px-3 py-2 fs-6">
                                                        Skor: {{ $day['test']->total_score }}
                                                    </span>
                                                    <div class="small text-muted mt-1">
                                                        Kualitas Tidur Anda: <span class="text-{{ $day['test']->getQualityColor() }}">
                                                            {{ $day['test']->getQualityLevel() }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="d-flex flex-column align-items-center justify-content-center text-primary mb-2 gap-2">
                                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                                                <span class="fw-bold">Belum Dikonfirmasi</span>
                                            </div>
                                            <a href="{{ route('pengguna.quality-test.edit', $day['day_type']) }}"
                                                class="btn btn-primary btn-sm w-100 mb-2">
                                                <i class="fas fa-edit me-1"></i>Edit Test
                                            </a>
                                            <form action="{{ route('pengguna.quality-test.confirm', $day['day_type']) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm w-100">
                                                    <i class="fas fa-check me-1"></i>Konfirmasi
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        @if ($day['can_take_test'])
                                            <a href="{{ route('pengguna.quality-test.show', $day['day_type']) }}"
                                                class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                                <i class="fas fa-file-signature me-2"></i>
                                                Isi Test {{ $day['day_type'] == 'first' ? 'Pertama' : 'Terakhir' }}
                                            </a>
                                        @elseif($day['is_future'] || !$day['is_available'])
                                            <div class="text-center py-4">
                                                <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-0">
                                                    @if ($day['day_type'] == 'last')
                                                        @if ($day['lock_reason'])
                                                            {{ $day['lock_reason'] }}
                                                        @else
                                                            Test akan tersedia pada hari ke-7<br>
                                                            ({{ $day['date_formatted'] }})
                                                        @endif
                                                    @else
                                                        Test telah lewat batas waktu
                                                    @endif
                                                </p>
                                            </div>
                                        @else
                                            <button class="btn btn-outline-secondary btn-lg w-100 py-3" disabled>
                                                <i class="fas fa-ban me-2"></i>Tidak Tersedia
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Info Card -->
            <div class="col-12">
                <div class="card border-0 shadow-sm mt-3"
                    style="border-radius: var(--border-radius-sm); background: var(--primary-lighter);">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color: var(--primary);">
                            <i class="fas fa-info-circle me-2"></i>Informasi Test PSQI
                        </h6>
                        <p class="mb-3">Test Pittsburgh Sleep Quality Index (PSQI) mengukur kualitas tidur Anda selama
                            sebulan terakhir melalui 7 komponen:</p>

                        <div class="row">
                            <div class="col-md-6">
                                <ul class="mb-0">
                                    <li>Kualitas tidur subyektif</li>
                                    <li>Latensi tidur</li>
                                    <li>Durasi tidur</li>
                                    <li>Efisiensi tidur</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="mb-0">
                                    <li>Gangguan tidur</li>
                                    <li>Penggunaan obat tidur</li>
                                    <li>Disfungsi siang hari</li>
                                </ul>
                            </div>
                        </div>

                        <div class="alert alert-primary border-0 mt-3" style="background: white;">
                            <i class="fas fa-lightbulb me-2 text-primary"></i>
                            <strong>Interpretasi Skor:</strong>
                            <ul class="mb-0 mt-2">
                                <li><strong>Skor ≤ 5:</strong> Kualitas tidur Baik</li>
                                <li><strong>Skor > 5:</strong> Kualitas tidur Buruk</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function startNewTest() {
            if (confirm('Apakah Anda yakin ingin memulai test baru? Test yang sedang berjalan akan dihentikan.')) {
                fetch('{{ route('pengguna.quality-test.start-new') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Terjadi kesalahan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan.');
                    });
            }
        }

        // Hover effect for cards
        document.querySelectorAll('.hover-lift').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = 'var(--shadow-lg)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--shadow-sm)';
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            transition: all 0.3s ease;
        }

        .progress-bar {
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light);
                    border: none;
                    transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow);
            }

            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: var(--shadow-lg);
            }

            .score-display .badge {
                font-size: 1rem;
                padding: 0.5rem 1rem;
            }

            /* Timeline Styles */
            .timeline-container {
                position: relative;
                padding-left: 20px;
            }

            .timeline-container::before {
                content: '';
                position: absolute;
                left: 35px;
                top: 0;
                bottom: 0;
                width: 2px;
                background-color: var(--primary-lighter);
            }

            .timeline-item {
                position: relative;
            }

            .timeline-marker {
                position: relative;
                z-index: 1;
            }

            .marker-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
            }

            .marker-icon.confirmed {
                background-color: var(--success);
                color: white;
            }

            .marker-icon.available {
                background-color: var(--primary);
                color: white;
            }

            .marker-icon.locked {
                background-color: var(--secondary);
                color: white;
            }

            .marker-day {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: var(--light-bg);
                color: var(--secondary);
                font-weight: 600;
                border: 2px solid var(--border-color);
            }

            .timeline-content {
                background: white;
                padding: 15px;
                border-radius: 10px;
                border: 1px solid var(--border-color);
            }
    </style>
@endpush
