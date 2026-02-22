<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\SleepTracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SleepTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari pengguna ibu hamil yang sudah ada (dari seeder sebelumnya)
        $pengguna = Pengguna::where('nomor_telepon', '081234567890')->first();

        if (!$pengguna) {
            $this->command->error('Pengguna ibu hamil tidak ditemukan. Jalankan PenggunaSeeder terlebih dahulu.');
            return;
        }

        // Hapus data tracking yang sudah ada untuk pengguna ini (jika ada)
        SleepTracking::where('pengguna_id', $pengguna->id)->delete();

        $this->command->info('Membuat 20 data sleep tracking untuk: ' . $pengguna->nama_lengkap);
        $this->command->info('===========================================');

        // Data alasan kebangun yang umum untuk ibu hamil
        $alasanKebangunOptions = [
            null,
            'Perut terasa tidak nyaman',
            'Harus ke kamar mandi',
            'Posisi tidur tidak nyaman',
            'Mimpi buruk',
            'Kepanasan',
            'Kedinginan',
            'Gerakan bayi',
            'Pusing atau mual',
            'Lapar atau haus',
            'Stres atau cemas',
            'Kaki kram',
            'Punggung sakit',
            'Napas terasa berat',
            'Bunyi dari luar',
        ];

        // Data catatan lain
        $catatanLainOptions = [
            null,
            'Tidur cukup nyenyak malam ini',
            'Bangun dengan badan segar',
            'Sedikit pusing saat bangun',
            'Mimpi aneh tapi tidak mengganggu',
            'Banyak bergerak saat tidur',
            'Perlu bantal tambahan untuk kenyamanan',
            'Lebih sering berganti posisi',
            'Mendengkur sedikit',
            'Tidur dengan perasaan cemas',
            'Lebih mudah lelah dari biasanya',
            'Perut terasa penuh',
            'Sering minum air saat malam',
            'Membutuhkan waktu lama untuk bisa tidur',
            'Tidur lebih awal dari biasanya',
        ];

        // Data waktu tidur kembali yang umum (dalam menit)
        $waktuTidurKembaliOptions = [
            5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60
        ];

        // Data durasi di tempat tidur sebelum tidur (dalam menit)
        $durasiDiTempatTidurOptions = [
            5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 60
        ];

        $sleepTrackingData = [];

        // Buat data untuk 20 hari terakhir
        for ($i = 0; $i < 20; $i++) {
            $tanggalTidur = Carbon::now()->subDays($i);
            $sleepDate = $tanggalTidur->copy()->setTime(0, 0, 0);

            // Generate waktu tidur antara 21:00 - 23:30
            $waktuTidurHour = rand(21, 23);
            $waktuTidurMinute = rand(0, 59);
            if ($waktuTidurHour == 23 && $waktuTidurMinute > 30) {
                $waktuTidurMinute = rand(0, 30);
            }
            $waktuTidur = sprintf('%02d:%02d', $waktuTidurHour, $waktuTidurMinute);

            // Generate waktu bangun antara 05:00 - 08:30
            $waktuBangunHour = rand(5, 8);
            $waktuBangunMinute = rand(0, 59);
            if ($waktuBangunHour == 8 && $waktuBangunMinute > 30) {
                $waktuBangunMinute = rand(0, 30);
            }
            $waktuBangun = sprintf('%02d:%02d', $waktuBangunHour, $waktuBangunMinute);

            // Generate jumlah kebangunan (ibu hamil cenderung lebih sering terbangun)
            // Distribusi: 30% tidak terbangun, 40% 1-2x, 20% 3-4x, 10% 5x
            $random = rand(1, 100);
            if ($random <= 30) {
                $jumlahKebangunan = 0;
            } elseif ($random <= 70) {
                $jumlahKebangunan = rand(1, 2);
            } elseif ($random <= 90) {
                $jumlahKebangunan = rand(3, 4);
            } else {
                $jumlahKebangunan = 5;
            }
            
            // Alasan kebangun - WAJIB DIISI
            $alasanIndex = rand(1, count($alasanKebangunOptions) - 1); // Selalu ambil dari index 1 ke atas (skip null)
            $alasanKebangun = $alasanKebangunOptions[$alasanIndex];
            
            // Durasi di tempat tidur sebelum tidur (dalam menit)
            $durasiDiTempatTidur = $durasiDiTempatTidurOptions[array_rand($durasiDiTempatTidurOptions)];
            
            // Waktu tidur kembali - hanya diisi jika jumlah kebangunan > 0
            $waktuTidurKembali = null;
            if ($jumlahKebangunan > 0) {
                // 70% kemungkinan memiliki waktu tidur kembali
                if (rand(1, 100) <= 70) {
                    $waktuTidurKembali = $waktuTidurKembaliOptions[array_rand($waktuTidurKembaliOptions)];
                    
                    // Jika jumlah kebangunan banyak, waktu tidur kembali cenderung lebih lama
                    if ($jumlahKebangunan >= 4) {
                        // Tambah 10-30 menit untuk kebangunan yang lebih sering
                        $waktuTidurKembali += rand(10, 30);
                    }
                    
                    // Batasi maksimal 90 menit
                    $waktuTidurKembali = min($waktuTidurKembali, 90);
                }
            }
            
            // Catatan lain
            $catatanIndex = rand(0, count($catatanLainOptions) - 1);
            $catatanLain = $catatanLainOptions[$catatanIndex];

            // Hitung durasi tidur
            $sleepTime = Carbon::createFromTimeString($waktuTidur);
            $wakeTime = Carbon::createFromTimeString($waktuBangun);
            
            // Jika waktu bangun lebih kecil dari waktu tidur, tambah 1 hari
            if ($wakeTime->lessThan($sleepTime)) {
                $wakeTime->addDay();
            }
            
            $durationInHours = $wakeTime->diffInMinutes($sleepTime) / 60;
            
            // Tambahkan variasi untuk durasi (antara 5-9 jam, dengan fokus 7-8 jam untuk kualitas baik)
            $baseDuration = rand(7, 8); // Durasi dasar 7-8 jam
            $variation = (rand(-20, 20) / 60); // Variasi ±20 menit
            $durationInHours = max(4.5, min(9.5, $baseDuration + $variation)); // Batasi 4.5-9.5 jam
            
            // Kurangi durasi berdasarkan waktu tidur kembali (jika ada)
            // Asumsi: setiap kebangunan mengurangi waktu tidur efektif
            if ($waktuTidurKembali && $jumlahKebangunan > 0) {
                // Total waktu yang hilang = waktu tidur kembali * jumlah kebangunan
                $totalWakeBackTime = $waktuTidurKembali * $jumlahKebangunan;
                $durationInHours -= ($totalWakeBackTime / 60);
                
                // Pastikan durasi tidak negatif
                $durationInHours = max(4.0, $durationInHours);
            }

            // Buat sleep tracking data
            $sleepTrackingData[] = [
                'pengguna_id' => $pengguna->id,
                'tanggal_tidur' => $sleepDate,
                'durasi_di_tempat_tidur' => $durasiDiTempatTidur,
                'waktu_tidur' => $waktuTidur,
                'waktu_bangun' => $waktuBangun,
                'jumlah_kebangunan' => $jumlahKebangunan,
                'waktu_tidur_kembali' => $waktuTidurKembali,
                'alasan_kebangun' => $alasanKebangun,
                'catatan_lain' => $catatanLain,
                'durasi_tidur' => round($durationInHours, 2),
                'created_at' => $sleepDate->copy()->addHours(rand(6, 9)), // Dibuat pagi hari setelah bangun
                'updated_at' => $sleepDate->copy()->addHours(rand(6, 9)),
            ];

            // Tampilkan informasi dengan waktu tidur kembali
            $infoLine = sprintf(
                'Hari ke-%2d: %s | Tidur: %s | Bangun: %s | Durasi: %.2f jam | Kebangunan: %dx',
                $i + 1,
                $sleepDate->format('d M Y'),
                $waktuTidur,
                $waktuBangun,
                $durationInHours,
                $jumlahKebangunan
            );
            
            if ($waktuTidurKembali) {
                $infoLine .= sprintf(' | Waktu tidur kembali: %d menit', $waktuTidurKembali);
            }
            
            $this->command->info($infoLine);
        }

        // Urutkan berdasarkan tanggal tidur (terbaru ke terlama)
        usort($sleepTrackingData, function($a, $b) {
            return strtotime($b['tanggal_tidur']) - strtotime($a['tanggal_tidur']);
        });

        // Simpan ke database
        foreach ($sleepTrackingData as $data) {
            SleepTracking::create($data);
        }

        // Hitung statistik
        $this->calculateAndDisplayStatistics($pengguna->id);
    }

    /**
     * Calculate and display statistics for sleep tracking
     */
    private function calculateAndDisplayStatistics($penggunaId)
    {
        $sleepTrackings = SleepTracking::where('pengguna_id', $penggunaId)->get();

        if ($sleepTrackings->count() == 0) {
            return;
        }

        $totalRecords = $sleepTrackings->count();
        $averageDuration = $sleepTrackings->avg('durasi_tidur');
        $averageWakeups = $sleepTrackings->avg('jumlah_kebangunan');
        $minDuration = $sleepTrackings->min('durasi_tidur');
        $maxDuration = $sleepTrackings->max('durasi_tidur');
        
        // Statistik waktu tidur kembali
        $recordsWithWakeBack = $sleepTrackings->filter(function($tracking) {
            return $tracking->waktu_tidur_kembali !== null && $tracking->waktu_tidur_kembali > 0;
        });
        
        $averageWakeBackTime = $recordsWithWakeBack->avg('waktu_tidur_kembali');
        $totalWithWakeBack = $recordsWithWakeBack->count();
        
        // Format durasi untuk display
        $formatDuration = function($hours) {
            $h = floor($hours);
            $m = round(($hours - $h) * 60);
            return "{$h} jam {$m} menit";
        };

        // Tampilkan statistik
        $this->command->info('');
        $this->command->info('===========================================');
        $this->command->info('STATISTIK TIDUR SELAMA 20 HARI TERAKHIR');
        $this->command->info('===========================================');
        $this->command->info('Total Pencatatan          : ' . $totalRecords . ' hari');
        $this->command->info('Rata-rata Durasi          : ' . $formatDuration($averageDuration) . ' (' . number_format($averageDuration, 2) . ' jam)');
        $this->command->info('Rata-rata Kebangunan      : ' . number_format($averageWakeups, 1) . 'x per malam');
        $this->command->info('Durasi Terpendek          : ' . $formatDuration($minDuration));
        $this->command->info('Durasi Terpanjang         : ' . $formatDuration($maxDuration));
        
        if ($totalWithWakeBack > 0) {
            $this->command->info('Data dengan tidur kembali : ' . $totalWithWakeBack . ' hari (' . round(($totalWithWakeBack/$totalRecords)*100) . '%)');
            $this->command->info('Rata-rata waktu kembali   : ' . number_format($averageWakeBackTime, 1) . ' menit');
        } else {
            $this->command->info('Data dengan tidur kembali : 0 hari (0%)');
        }
        
        // Analisis kualitas tidur
        $goodSleep = $sleepTrackings->filter(function($tracking) {
            return $tracking->durasi_tidur >= 7;
        })->count();
        
        $fairSleep = $sleepTrackings->filter(function($tracking) {
            return $tracking->durasi_tidur >= 5 && $tracking->durasi_tidur < 7;
        })->count();
        
        $poorSleep = $sleepTrackings->filter(function($tracking) {
            return $tracking->durasi_tidur < 5;
        })->count();
        
        $this->command->info('');
        $this->command->info('ANALISIS KUALITAS TIDUR:');
        $this->command->info('Tidur Baik (≥7 jam)      : ' . $goodSleep . ' hari (' . round(($goodSleep/$totalRecords)*100) . '%)');
        $this->command->info('Tidur Cukup (5-7 jam)    : ' . $fairSleep . ' hari (' . round(($fairSleep/$totalRecords)*100) . '%)');
        $this->command->info('Tidur Kurang (<5 jam)    : ' . $poorSleep . ' hari (' . round(($poorSleep/$totalRecords)*100) . '%)');
        
        // Analisis berdasarkan waktu tidur kembali
        if ($totalWithWakeBack > 0) {
            $this->command->info('');
            $this->command->info('ANALISIS WAKTU TIDUR KEMBALI:');
            
            $quickReturn = $recordsWithWakeBack->filter(function($tracking) {
                return $tracking->waktu_tidur_kembali <= 15;
            })->count();
            
            $moderateReturn = $recordsWithWakeBack->filter(function($tracking) {
                return $tracking->waktu_tidur_kembali > 15 && $tracking->waktu_tidur_kembali <= 30;
            })->count();
            
            $longReturn = $recordsWithWakeBack->filter(function($tracking) {
                return $tracking->waktu_tidur_kembali > 30;
            })->count();
            
            $this->command->info('Kembali cepat (≤15 menit) : ' . $quickReturn . ' hari (' . round(($quickReturn/$totalWithWakeBack)*100) . '%)');
            $this->command->info('Kembali sedang (16-30 mnt): ' . $moderateReturn . ' hari (' . round(($moderateReturn/$totalWithWakeBack)*100) . '%)');
            $this->command->info('Kembali lama (>30 menit)  : ' . $longReturn . ' hari (' . round(($longReturn/$totalWithWakeBack)*100) . '%)');
        }
        
        // Rekomendasi berdasarkan data
        $this->command->info('');
        $this->command->info('REKOMENDASI:');
        if ($averageDuration >= 7) {
            $this->command->info('✓ Durasi tidur Anda sudah cukup baik untuk ibu hamil');
        } elseif ($averageDuration >= 6) {
            $this->command->info('✓ Durasi tidur cukup, tetapi bisa ditingkatkan menjadi 7-8 jam');
        } else {
            $this->command->info('✗ Perlu meningkatkan durasi tidur minimal 7 jam per malam');
        }
        
        if ($averageWakeups <= 2) {
            $this->command->info('✓ Frekuensi kebangunan masih dalam batas wajar');
        } elseif ($averageWakeups <= 4) {
            $this->command->info('✓ Kebangunan cukup sering, normal untuk ibu hamil');
        } else {
            $this->command->info('✗ Kebangunan terlalu sering, pertimbangkan posisi tidur yang lebih nyaman');
        }
        
        if ($totalWithWakeBack > 0 && $averageWakeBackTime > 0) {
            if ($averageWakeBackTime <= 15) {
                $this->command->info('✓ Waktu untuk kembali tidur cukup cepat, menunjukkan kualitas tidur baik');
            } elseif ($averageWakeBackTime <= 30) {
                $this->command->info('✓ Waktu kembali tidur normal, cobalah teknik relaksasi jika perlu');
            } else {
                $this->command->info('✗ Waktu kembali tidur cenderung lama, coba teknik pernapasan atau meditasi sebelum tidur');
            }
        }

        $this->command->info('');
        $this->command->info('Seeder berhasil membuat ' . $totalRecords . ' data sleep tracking!');
        if ($totalWithWakeBack > 0) {
            $this->command->info('Dengan ' . $totalWithWakeBack . ' data memiliki informasi waktu tidur kembali.');
        }
    }
}