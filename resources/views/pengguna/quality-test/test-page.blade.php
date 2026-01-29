@extends('layouts.app')

@section('title', 'Test PSQI - ' . ($type == 'first' ? 'Hari Pertama' : 'Hari Terakhir'))

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="card border-0 shadow-lg mb-4" style="border-radius: var(--border-radius);">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center  justify-content-start justify-content-lg-between mb-4 gap-3">
                    <div>
                        <h2 class="mb-1 fw-bold" style="color: var(--primary);">
                            <i class="fas fa-file-signature me-2"></i>Test Kualitas Tidur
                        </h2>
                        <p class="text-muted mb-0">
                            {{ $type == 'first' ? 'Test Pertama (Sebelum)' : 'Test Terakhir (Sesudah)' }} - Pittsburgh Sleep
                            Quality Index (PSQI)
                        </p>
                        <p class="text-muted small mb-0">
                            Hari ke-{{ $type == 'first' ? '1' : '7' }} dari 7
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('pengguna.quality-test.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Progress -->
                <div class="progress-container mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Progress Test</span>
                        <span class="text-primary fw-bold">{{ $type == 'first' ? 'Test 1 dari 2' : 'Test 2 dari 2' }}</span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 10px;">
                        <div class="progress-bar bg-primary" role="progressbar"
                            style="width: {{ $type == 'first' ? 50 : 100 }}%;"
                            aria-valuenow="{{ $type == 'first' ? 50 : 100 }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>

                <!-- Date Info -->
                <div class="alert alert-info border-0"
                    style="border-radius: var(--border-radius-sm); background: var(--primary-lighter);">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-alt fa-2x me-3" style="color: var(--primary);"></i>
                        <div>
                            <h6 class="mb-1 fw-bold">Test untuk {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                            </h6>
                            <p class="mb-0">
                                @if ($type == 'first')
                                    Test awal untuk menilai kualitas tidur Anda sebelum intervensi.
                                @else
                                    Test akhir untuk menilai perubahan kualitas tidur setelah 7 hari.
                                @endif
                            </p>
                            <p class="mb-0"><strong>Petunjuk:</strong> Jawab semua pertanyaan dengan jujur berdasarkan
                                pengalaman tidur Anda selama sebulan terakhir.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form id="psqiForm" action="{{ route('pengguna.quality-test.store', $type) }}" method="POST">
            @csrf

            <!-- Bagian 1: Informasi Waktu Tidur -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--border-radius-sm);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"
                        style="color: var(--primary); border-left: 4px solid var(--primary); padding-left: 1rem;">
                        Bagian 1: Informasi Waktu Tidur
                    </h5>

                    <div class="row g-3">
                        <!-- Q1: Waktu mulai tidur -->
                        <div class="col-md-6">
                            <label for="bedtime" class="form-label fw-bold">
                                <i class="fas fa-clock me-1"></i>1. Pukul berapa biasanya Anda mulai tidur malam?
                            </label>
                            <input type="time" class="form-control" id="bedtime" name="bedtime"
                                value="{{ old('bedtime', $existingTest->bedtime ?? '22:00') }}" required>
                            <div class="form-text">Jam ketika Anda mulai mencoba tidur</div>
                        </div>

                        <!-- Q2: Waktu untuk tertidur -->
                        <div class="col-md-6">
                            <label for="time_to_sleep" class="form-label fw-bold">
                                <i class="fas fa-hourglass-half me-1"></i>2. Berapa lama Anda biasanya baru bisa tertidur
                                tiap malam?
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="time_to_sleep" name="time_to_sleep"
                                    min="0" max="300" step="1"
                                    value="{{ old('time_to_sleep', $existingTest->time_to_sleep ?? 15) }}" required>
                                <span class="input-group-text">menit</span>
                            </div>
                            <div class="form-text">Waktu dari berbaring sampai benar-benar tertidur</div>
                        </div>

                        <!-- Q3: Waktu bangun -->
                        <div class="col-md-6">
                            <label for="wakeup_time" class="form-label fw-bold">
                                <i class="fas fa-sun me-1"></i>3. Pukul berapa Anda biasanya bangun pagi?
                            </label>
                            <input type="time" class="form-control" id="wakeup_time" name="wakeup_time"
                                value="{{ old('wakeup_time', $existingTest->wakeup_time ?? '06:00') }}" required>
                            <div class="form-text">Jam bangun utama di pagi hari</div>
                        </div>

                        <!-- Q4: Durasi tidur -->
                        <div class="col-md-6">
                            <label for="sleep_duration" class="form-label fw-bold">
                                <i class="fas fa-bed me-1"></i>4. Berapa lama Anda tidur di malam hari? (Jam)
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="sleep_duration" name="sleep_duration"
                                    min="0" max="24" step="0.1"
                                    value="{{ old('sleep_duration', $existingTest->sleep_duration ?? 8) }}" required>
                                <span class="input-group-text">jam</span>
                            </div>
                            <div class="form-text">Total waktu tidur aktual dalam jam (contoh: 7.5 untuk 7 jam 30 menit)
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Q5: Gangguan Tidur -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--border-radius-sm);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"
                        style="color: var(--primary); border-left: 4px solid var(--primary); padding-left: 1rem;">
                        Bagian 2: Gangguan Tidur
                    </h5>
                    <p class="text-muted mb-4">5. Seberapa sering masalah di bawah ini mengganggu tidur Anda dalam sebulan
                        terakhir?</p>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50%;">Masalah</th>
                                    <th class="text-center">Tidak pernah (0)</th>
                                    <th class="text-center">1x seminggu (1)</th>
                                    <th class="text-center">2x seminggu (2)</th>
                                    <th class="text-center">≥3x seminggu (3)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $disturbances = [
                                        'a' => 'a. Tidak mampu tertidur selama 30 menit sejak berbaring',
                                        'b' => 'b. Terbangun ditengah malam atau dini hari',
                                        'c' => 'c. Terbangun untuk kekamar mandi',
                                        'd' => 'd. Sulit bernafas dengan baik',
                                        'e' => 'e. Batuk atau mengorok',
                                        'f' => 'f. Kedinginan dimalam hari',
                                        'g' => 'g. Kepanasan di malam hari',
                                        'h' => 'h. Mimpi buruk',
                                        'i' => 'i. Terasa nyeri',
                                        'j' => 'j. Alasan lain...',
                                    ];

                                    $oldDisturbances = old(
                                        'sleep_disturbances',
                                        $existingTest->sleep_disturbances ?? [],
                                    );
                                @endphp

                                @foreach ($disturbances as $key => $label)
                                    <tr>
                                        <td class="fw-bold">{{ $label }}</td>
                                        @for ($i = 0; $i <= 3; $i++)
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input class="form-check-input disturbance-radio" type="radio"
                                                        name="sleep_disturbances[{{ $key }}]"
                                                        id="dist{{ $key }}_{{ $i }}"
                                                        value="{{ $i }}"
                                                        {{ ($oldDisturbances[$key] ?? 0) == $i ? 'checked' : '' }}
                                                        required>
                                                </div>
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Q6: Penggunaan obat -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--border-radius-sm);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"
                        style="color: var(--primary); border-left: 4px solid var(--primary); padding-left: 1rem;">
                        Bagian 3: Penggunaan Obat Tidur
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-pills me-1"></i>6. Selama sebulan terakhir, berapa sering Anda menggunakan
                            obat tidur?
                        </label>

                        <div class="row mt-3">
                            @php
                                $medicationOptions = [
                                    0 => 'Tidak pernah',
                                    1 => '1x seminggu',
                                    2 => '2x seminggu',
                                    3 => '≥3x seminggu',
                                ];
                            @endphp

                            @foreach ($medicationOptions as $value => $label)
                                <div class="col-md-6 mb-3">
                                    <div class="form-check card-option">
                                        <input class="form-check-input" type="radio" name="medication_use"
                                            id="medication{{ $value }}" value="{{ $value }}"
                                            {{ old('medication_use', $existingTest->medication_use ?? 0) == $value ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label w-100" for="medication{{ $value }}">
                                            <div class="card border p-3 text-center option-card">
                                                <div class="fw-bold">{{ $label }}</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Q7: Kantuk siang hari -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--border-radius-sm);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"
                        style="color: var(--primary); border-left: 4px solid var(--primary); padding-left: 1rem;">
                        Bagian 4: Kantuk Siang Hari
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-tired me-1"></i>7. Selama sebulan terakhir, seberapa sering Anda mengantuk
                            ketika melakukan aktivitas disiang hari?
                        </label>

                        <div class="row mt-3">
                            @php
                                $sleepinessOptions = [
                                    0 => 'Tidak pernah',
                                    1 => '1x seminggu',
                                    2 => '2x seminggu',
                                    3 => '≥3x seminggu',
                                ];
                            @endphp

                            @foreach ($sleepinessOptions as $value => $label)
                                <div class="col-md-6 mb-3">
                                    <div class="form-check card-option">
                                        <input class="form-check-input" type="radio" name="daytime_sleepiness"
                                            id="sleepiness{{ $value }}" value="{{ $value }}"
                                            {{ old('daytime_sleepiness', $existingTest->daytime_sleepiness ?? 0) == $value ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label w-100" for="sleepiness{{ $value }}">
                                            <div class="card border p-3 text-center option-card">
                                                <div class="fw-bold">{{ $label }}</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Q8: Antusiasme -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--border-radius-sm);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"
                        style="color: var(--primary); border-left: 4px solid var(--primary); padding-left: 1rem;">
                        Bagian 5: Antusiasme Menyelesaikan Masalah
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-brain me-1"></i>8. Selama satu bulan terakhir, berapa banyak masalah yang Anda
                            dapatkan dan seberapa antusias Anda selesaikan permasalahan tersebut?
                        </label>

                        <div class="row mt-3">
                            @php
                                $enthusiasmOptions = [
                                    0 => 'Tidak antusias',
                                    1 => 'Kecil',
                                    2 => 'Sedang',
                                    3 => 'Besar',
                                ];
                            @endphp

                            @foreach ($enthusiasmOptions as $value => $label)
                                <div class="col-md-6 mb-3">
                                    <div class="form-check card-option">
                                        <input class="form-check-input" type="radio" name="enthusiasm"
                                            id="enthusiasm{{ $value }}" value="{{ $value }}"
                                            {{ old('enthusiasm', $existingTest->enthusiasm ?? 2) == $value ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label w-100" for="enthusiasm{{ $value }}">
                                            <div class="card border p-3 text-center option-card">
                                                <div class="fw-bold">{{ $label }}</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Q9: Kepuasan tidur -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: var(--border-radius-sm);">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"
                        style="color: var(--primary); border-left: 4px solid var(--primary); padding-left: 1rem;">
                        Bagian 6: Kepuasan Tidur
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-smile me-1"></i>9. Selama bulan terakhir, bagaimana Anda menilai kepuasan
                            tidur Anda?
                        </label>

                        <div class="row mt-3">
                            @php
                                $satisfactionOptions = [
                                    0 => 'Sangat Baik',
                                    1 => 'Cukup Baik',
                                    2 => 'Cukup Buruk',
                                    3 => 'Sangat Buruk',
                                ];
                            @endphp

                            @foreach ($satisfactionOptions as $value => $label)
                                <div class="col-md-6 mb-3">
                                    <div class="form-check card-option">
                                        <input class="form-check-input" type="radio" name="sleep_satisfaction"
                                            id="satisfaction{{ $value }}" value="{{ $value }}"
                                            {{ old('sleep_satisfaction', $existingTest->sleep_satisfaction ?? 1) == $value ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label w-100" for="satisfaction{{ $value }}">
                                            <div class="card border p-3 text-center option-card">
                                                <div class="fw-bold">{{ $label }}</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-action"
                style="padding: 20px 0 40px; margin-top: 20px;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('pengguna.quality-test.index') }}"
                            class="btn btn-secondary w-100 py-3">
                            <i class="fas fa-times me-2"></i>Batalkan
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="fas fa-save me-2"></i>Simpan Test {{ $type == 'first' ? 'Pertama' : 'Terakhir' }}
                        </button>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted small">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Setelah disimpan, Anda masih bisa mengubah sampai dikonfirmasi
                </div>
            </div>
        </form>
    </div>

    @push('styles')
        <style>
            .card-option .option-card {
                transition: all 0.3s ease;
                cursor: pointer;
                border: 2px solid transparent;
            }

            .card-option .form-check-input:checked+label .option-card {
                border-color: var(--primary);
                background-color: var(--primary-lighter);
                transform: translateY(-2px);
                box-shadow: var(--shadow-sm);
            }

            .card-option .form-check-input {
                display: none;
            }

            .table th {
                font-weight: 600;
                color: var(--primary);
                background-color: var(--primary-lighter);
                border-bottom: 2px solid var(--primary);
            }

            .table-hover tbody tr:hover {
                background-color: rgba(8, 86, 200, 0.05);
            }

            .disturbance-radio:checked {
                background-color: var(--primary);
                border-color: var(--primary);
            }

            .form-control:focus,
            .disturbance-radio:focus {
                border-color: var(--primary-light);
                box-shadow: 0 0 0 0.25rem rgba(8, 86, 200, 0.25);
            }

            .sticky-bottom {
                position: sticky;
                bottom: 100px;
                z-index: 10;
            }

            .form-check-input:checked {
                background-color: var(--primary);
                border-color: var(--primary);
            }

            .form-check-input:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 0.25rem rgba(8, 86, 200, 0.25);
            }

            .progress-bar {
                background: linear-gradient(135deg, var(--primary), var(--primary-light));
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary), var(--primary-light));
                border: none;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--primary-dark), var(--primary));
                transform: translateY(-2px);
                box-shadow: var(--shadow);
            }

            .option-card:hover {
                border-color: var(--primary-light) !important;
                transform: translateY(-2px);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-advance radio groups when clicking cards
                document.querySelectorAll('.card-option .option-card').forEach(card => {
                    card.addEventListener('click', function() {
                        const radio = this.closest('.card-option').querySelector('.form-check-input');
                        if (radio) {
                            radio.checked = true;
                            // Update all cards in the same group
                            const name = radio.getAttribute('name');
                            document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
                                const card = r.closest('.card-option')?.querySelector(
                                    '.option-card');
                                if (card) {
                                    card.style.borderColor = '';
                                    card.style.backgroundColor = '';
                                    card.style.transform = '';
                                    card.style.boxShadow = '';
                                }
                            });

                            // Style the clicked card
                            this.style.borderColor = 'var(--primary)';
                            this.style.backgroundColor = 'var(--primary-lighter)';
                            this.style.transform = 'translateY(-2px)';
                            this.style.boxShadow = 'var(--shadow-sm)';
                        }
                    });
                });

                // Initialize card styles for pre-checked radios
                document.querySelectorAll('.card-option .form-check-input:checked').forEach(radio => {
                    const card = radio.closest('.card-option')?.querySelector('.option-card');
                    if (card) {
                        card.style.borderColor = 'var(--primary)';
                        card.style.backgroundColor = 'var(--primary-lighter)';
                        card.style.transform = 'translateY(-2px)';
                        card.style.boxShadow = 'var(--shadow-sm)';
                    }
                });

                // Initialize disturbance radio styles
                document.querySelectorAll('.disturbance-radio:checked').forEach(radio => {
                    const cell = radio.closest('td');
                    if (cell) {
                        cell.style.backgroundColor = 'rgba(8, 86, 200, 0.1)';
                    }
                });

                // Form validation
                const form = document.getElementById('psqiForm');
                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    let firstError = null;

                    // Check all radio groups
                    const radioGroups = [
                        'medication_use',
                        'daytime_sleepiness',
                        'enthusiasm',
                        'sleep_satisfaction'
                    ];

                    radioGroups.forEach(group => {
                        const radios = document.querySelectorAll(`input[name="${group}"]:checked`);
                        if (radios.length === 0) {
                            isValid = false;
                            if (!firstError) {
                                firstError = document.querySelector(`input[name="${group}"]`).closest(
                                    '.card-option');
                            }
                            highlightError(document.querySelector(`input[name="${group}"]`));
                        }
                    });

                    // Check disturbance radios
                    for (let i = 'a'.charCodeAt(0); i <= 'j'.charCodeAt(0); i++) {
                        const key = String.fromCharCode(i);
                        const radios = document.querySelectorAll(
                            `input[name="sleep_disturbances[${key}]"]:checked`);
                        if (radios.length === 0) {
                            isValid = false;
                            if (!firstError) {
                                firstError = document.querySelector(`input[name="sleep_disturbances[${key}]"]`);
                            }
                            highlightError(document.querySelector(`input[name="sleep_disturbances[${key}]"]`));
                        }
                    }

                    // Check required inputs
                    const requiredInputs = ['bedtime', 'time_to_sleep', 'wakeup_time', 'sleep_duration'];
                    requiredInputs.forEach(id => {
                        const input = document.getElementById(id);
                        if (!input.value) {
                            isValid = false;
                            if (!firstError) {
                                firstError = input;
                            }
                            highlightError(input);
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Harap lengkapi semua pertanyaan sebelum menyimpan.');

                        // Scroll to first error
                        if (firstError) {
                            firstError.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }

                        return false;
                    }

                    return true;
                });

                function highlightError(element) {
                    if (!element) return;

                    // Find the card or input element to highlight
                    let target = element;
                    if (element.type === 'radio') {
                        target = element.closest('.card-option')?.querySelector('.option-card') ||
                            element.closest('td') || element;
                    } else if (element.tagName === 'INPUT') {
                        target = element;
                    }

                    // Add error styling
                    target.style.borderColor = 'var(--danger)';
                    target.style.boxShadow = '0 0 0 0.25rem rgba(231, 74, 59, 0.25)';

                    if (target.classList && target.classList.contains('option-card')) {
                        target.style.backgroundColor = 'rgba(231, 74, 59, 0.1)';
                    }

                    // Remove error styling after 3 seconds
                    setTimeout(() => {
                        target.style.borderColor = '';
                        target.style.boxShadow = '';
                        target.style.backgroundColor = '';

                        // Restore checked card styling if applicable
                        if (target.classList && target.classList.contains('option-card')) {
                            const radio = target.closest('.card-option')?.querySelector('.form-check-input');
                            if (radio && radio.checked) {
                                target.style.borderColor = 'var(--primary)';
                                target.style.backgroundColor = 'var(--primary-lighter)';
                                target.style.transform = 'translateY(-2px)';
                                target.style.boxShadow = 'var(--shadow-sm)';
                            }
                        }
                    }, 3000);
                }

                // Add visual feedback for disturbance radio clicks
                document.querySelectorAll('.disturbance-radio').forEach(radio => {
                    radio.addEventListener('click', function() {
                        const row = this.closest('tr');
                        if (row) {
                            // Remove highlight from all cells in row
                            row.querySelectorAll('td').forEach(td => {
                                td.style.backgroundColor = '';
                            });

                            // Highlight the selected cell
                            const cell = this.closest('td');
                            if (cell) {
                                cell.style.backgroundColor = 'rgba(8, 86, 200, 0.1)';
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
