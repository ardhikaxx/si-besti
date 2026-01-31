<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\SleepTest;
use App\Models\DailyTest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SleepTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy untuk beberapa skenario - SEMUA skenario sekarang punya test pertama dan terakhir
        $scenarios = [
            [
                'status' => 'completed',
                'has_first_test' => true,
                'has_last_test' => true,
                'first_test_confirmed' => true,
                'last_test_confirmed' => true,
                'description' => 'Test selesai dengan perbaikan kualitas tidur',
                'days_ago_start' => 14, // Mulai 14 hari lalu
                'days_ago_end' => 7,    // Selesai 7 hari lalu
            ],
            [
                'status' => 'completed',
                'has_first_test' => true,
                'has_last_test' => true,
                'first_test_confirmed' => true,
                'last_test_confirmed' => true,
                'description' => 'Test selesai dengan kualitas tidur stabil',
                'days_ago_start' => 21, // Mulai 21 hari lalu
                'days_ago_end' => 14,   // Selesai 14 hari lalu
            ],
            [
                'status' => 'completed',
                'has_first_test' => true,
                'has_last_test' => true,
                'first_test_confirmed' => true,
                'last_test_confirmed' => true,
                'description' => 'Test selesai dengan sedikit penurunan kualitas',
                'days_ago_start' => 28, // Mulai 28 hari lalu
                'days_ago_end' => 21,   // Selesai 21 hari lalu
            ],
        ];

        // Cari semua pengguna
        $penggunaList = Pengguna::all();

        if ($penggunaList->isEmpty()) {
            $this->command->error('Tidak ada pengguna. Jalankan PenggunaSeeder terlebih dahulu.');
            return;
        }

        foreach ($penggunaList as $index => $pengguna) {
            // Hapus data test lama untuk pengguna ini
            SleepTest::where('pengguna_id', $pengguna->id)->delete();

            $scenario = $scenarios[$index % count($scenarios)];
            
            $this->command->info('');
            $this->command->info('Membuat Sleep Test untuk: ' . $pengguna->nama_lengkap);
            $this->command->info('Skenario: ' . $scenario['description']);

            // Tentukan tanggal berdasarkan skenario
            $startDate = Carbon::now()->subDays($scenario['days_ago_start']);
            $endDate = Carbon::now()->subDays($scenario['days_ago_end']);
            $firstTestDate = $startDate;
            $lastTestDate = $endDate;

            // Buat SleepTest
            $sleepTest = SleepTest::create([
                'pengguna_id' => $pengguna->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_score_before' => null,
                'total_score_after' => null,
                'status' => $scenario['status'],
                'current_test' => 'first',
                'created_at' => $firstTestDate,
                'updated_at' => $lastTestDate,
            ]);

            $this->command->info('   - Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'));
            $this->command->info('   - Hari ke-1: ' . $firstTestDate->format('d M Y'));
            $this->command->info('   - Hari ke-7: ' . $lastTestDate->format('d M Y'));

            // Buat test pertama
            $firstTestData = $this->generateFirstTestData($sleepTest->id, $firstTestDate, $scenario['first_test_confirmed']);
            $firstTest = DailyTest::create($firstTestData);
            $firstTest->calculateScores()->save();
            
            $this->command->info('   - Test pertama: ' . $firstTest->total_score . ' poin (' . $firstTest->getQualityLevel() . ')');
            $this->command->info('   - Status: ' . ($firstTest->is_confirmed ? 'Dikonfirmasi' : 'Belum dikonfirmasi'));

            // Buat test terakhir
            $lastTestData = $this->generateLastTestData($sleepTest->id, $lastTestDate, $scenario['last_test_confirmed'], $firstTest);
            $lastTest = DailyTest::create($lastTestData);
            $lastTest->calculateScores()->save();
            
            $this->command->info('   - Test terakhir: ' . $lastTest->total_score . ' poin (' . $lastTest->getQualityLevel() . ')');
            $this->command->info('   - Status: ' . ($lastTest->is_confirmed ? 'Dikonfirmasi' : 'Belum dikonfirmasi'));

            // Update total score di SleepTest
            if ($firstTest->is_confirmed && $lastTest->is_confirmed) {
                $sleepTest->update([
                    'total_score_before' => $firstTest->total_score,
                    'total_score_after' => $lastTest->total_score,
                    'status' => 'completed',
                    'updated_at' => Carbon::now(),
                ]);
                
                $improvement = $firstTest->total_score - $lastTest->total_score;
                $improvementText = '';
                if ($improvement > 0) {
                    $improvementText = 'Membaik (' . abs($improvement) . ' poin)';
                } elseif ($improvement < 0) {
                    $improvementText = 'Memburuk (' . abs($improvement) . ' poin)';
                } else {
                    $improvementText = 'Stabil (tidak ada perubahan)';
                }
                
                $this->command->info('   - Perubahan kualitas: ' . $improvementText);
                
                // Tampilkan perbandingan detail
                $this->command->info('   - Detail perbandingan:');
                $this->command->info('     * Kualitas: ' . $firstTest->getQualityLevel() . ' → ' . $lastTest->getQualityLevel());
                $this->command->info('     * Durasi tidur: ' . $firstTest->sleep_duration . ' jam → ' . $lastTest->sleep_duration . ' jam');
                $this->command->info('     * Waktu untuk tidur: ' . $firstTest->time_to_sleep . ' menit → ' . $lastTest->time_to_sleep . ' menit');
            }
        }

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('Seeder SleepTest berhasil dijalankan!');
        $this->command->info('Total SleepTest: ' . SleepTest::count());
        $this->command->info('Total DailyTest: ' . DailyTest::count());
        
        // Tampilkan statistik
        $completedTests = SleepTest::where('status', 'completed')->count();
        $ongoingTests = SleepTest::where('status', 'ongoing')->count();
        $this->command->info('Test Completed: ' . $completedTests);
        $this->command->info('Test Ongoing: ' . $ongoingTests);
        
        // Hitung rata-rata skor
        $averageFirstScore = DailyTest::where('day_type', 'first')->avg('total_score');
        $averageLastScore = DailyTest::where('day_type', 'last')->avg('total_score');
        $this->command->info('Rata-rata skor test pertama: ' . number_format($averageFirstScore, 1));
        $this->command->info('Rata-rata skor test terakhir: ' . number_format($averageLastScore, 1));
        
        if ($averageFirstScore && $averageLastScore) {
            $averageImprovement = $averageFirstScore - $averageLastScore;
            $this->command->info('Rata-rata perbaikan: ' . number_format(abs($averageImprovement), 1) . ' poin');
        }
        
        $this->command->info('========================================');
    }

    /**
     * Generate data untuk test pertama
     */
    private function generateFirstTestData($sleepTestId, $testDate, $isConfirmed = true)
    {
        // Data yang lebih realistis untuk ibu hamil
        $sleepDuration = rand(5, 7) + (rand(0, 3) * 0.25); // 5-7.75 jam
        $timeToSleep = rand(15, 45); // 15-45 menit
        
        // Gangguan tidur yang umum untuk ibu hamil
        $disturbances = [
            'a' => rand(1, 3), // Tidak mampu tertidur: sering
            'b' => rand(2, 3), // Terbangun ditengah malam: sangat sering
            'c' => rand(2, 3), // Terbangun untuk ke kamar mandi: sangat sering
            'd' => rand(0, 1), // Sulit bernafas: jarang
            'e' => rand(0, 2), // Batuk atau mengorok: kadang
            'f' => rand(0, 1), // Kedinginan: jarang
            'g' => rand(1, 3), // Kepanasan: sering
            'h' => rand(1, 2), // Mimpi buruk: kadang
            'i' => rand(1, 3), // Terasa nyeri: sering
            'j' => 0,
        ];

        return [
            'sleep_test_id' => $sleepTestId,
            'day_type' => 'first',
            'test_date' => $testDate,
            
            'bedtime' => '22:' . str_pad(rand(0, 45), 2, '0', STR_PAD_LEFT),
            'time_to_sleep' => $timeToSleep,
            'wakeup_time' => '0' . rand(5, 6) . ':' . str_pad(rand(0, 45), 2, '0', STR_PAD_LEFT),
            'sleep_duration' => $sleepDuration,
            
            'sleep_disturbances' => json_encode($disturbances),
            
            'medication_use' => rand(0, 1),
            'daytime_sleepiness' => rand(2, 3), // Ibu hamil sering mengantuk
            'enthusiasm' => rand(1, 2), // Antusiasme rendah
            'sleep_satisfaction' => rand(2, 3), // Kepuasan rendah
            
            'is_confirmed' => $isConfirmed,
            'confirmed_at' => $isConfirmed ? $testDate->copy()->addHours(2) : null,
            
            'created_at' => $testDate,
            'updated_at' => $testDate,
        ];
    }

    /**
     * Generate data untuk test terakhir (biasanya membaik)
     */
    private function generateLastTestData($sleepTestId, $testDate, $isConfirmed = true, $firstTest = null)
    {
        // Jika ada data test pertama, buat perbandingan yang realistis
        if ($firstTest) {
            // Biasanya membaik 1-4 poin dari test pertama
            $improvementRange = rand(1, 4);
            
            // Durasi tidur biasanya bertambah 0.5-1.5 jam
            $sleepDuration = max(6, min(9, $firstTest->sleep_duration + (rand(5, 15) / 10)));
            
            // Waktu untuk tidur biasanya berkurang 5-20 menit
            $timeToSleep = max(5, $firstTest->time_to_sleep - rand(5, 20));
            
            // Gangguan tidur berkurang
            $disturbances = json_decode($firstTest->sleep_disturbances, true);
            foreach ($disturbances as $key => $value) {
                if ($key !== 'j') {
                    $disturbances[$key] = max(0, $value - rand(0, 2));
                }
            }
            
            // Kantuk siang hari berkurang
            $daytimeSleepiness = max(0, $firstTest->daytime_sleepiness - rand(0, 2));
            
            // Antusiasme meningkat
            $enthusiasm = min(3, $firstTest->enthusiasm + rand(0, 2));
            
            // Kepuasan tidur meningkat
            $sleepSatisfaction = max(0, $firstTest->sleep_satisfaction - rand(0, 2));
            
        } else {
            // Data default jika tidak ada test pertama
            $sleepDuration = rand(6, 8) + (rand(0, 3) * 0.25); // 6-8.75 jam
            $timeToSleep = rand(5, 25); // 5-25 menit
            
            $disturbances = [
                'a' => rand(0, 1), // Tidak mampu tertidur: jarang
                'b' => rand(0, 2), // Terbangun ditengah malam: kadang
                'c' => rand(1, 2), // Terbangun untuk ke kamar mandi: kadang
                'd' => 0,
                'e' => rand(0, 1),
                'f' => 0,
                'g' => rand(0, 1), // Kepanasan: jarang
                'h' => rand(0, 1),
                'i' => rand(0, 1), // Terasa nyeri: jarang
                'j' => 0,
            ];
            
            $daytimeSleepiness = rand(0, 1);
            $enthusiasm = rand(2, 3);
            $sleepSatisfaction = rand(0, 1);
        }

        return [
            'sleep_test_id' => $sleepTestId,
            'day_type' => 'last',
            'test_date' => $testDate,
            
            'bedtime' => '21:' . str_pad(rand(30, 59), 2, '0', STR_PAD_LEFT), // Tidur lebih awal
            'time_to_sleep' => $timeToSleep,
            'wakeup_time' => '0' . rand(6, 7) . ':' . str_pad(rand(0, 30), 2, '0', STR_PAD_LEFT),
            'sleep_duration' => $sleepDuration,
            
            'sleep_disturbances' => json_encode($disturbances),
            
            'medication_use' => 0, // Biasanya berhenti menggunakan obat
            'daytime_sleepiness' => $daytimeSleepiness,
            'enthusiasm' => $enthusiasm,
            'sleep_satisfaction' => $sleepSatisfaction,
            
            'is_confirmed' => $isConfirmed,
            'confirmed_at' => $isConfirmed ? $testDate->copy()->addHours(2) : null,
            
            'created_at' => $testDate,
            'updated_at' => $testDate,
        ];
    }

    /**
     * Versi alternatif: Buat juga test yang masih ongoing untuk hari terakhir
     */
    private function createOngoingTestWithBothTests($pengguna)
    {
        $this->command->info('');
        $this->command->info('Membuat Sleep Test Ongoing untuk: ' . $pengguna->nama_lengkap);
        $this->command->info('Skenario: Test ongoing, hari pertama sudah dikonfirmasi, hari terakhir sudah diisi tapi belum dikonfirmasi');

        // Test yang dimulai 3 hari lalu, berakhir 4 hari lagi
        $startDate = Carbon::now()->subDays(3);
        $endDate = Carbon::now()->addDays(4);
        $firstTestDate = $startDate;
        $lastTestDate = Carbon::now(); // Hari terakhir diisi hari ini

        // Buat SleepTest
        $sleepTest = SleepTest::create([
            'pengguna_id' => $pengguna->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_score_before' => null,
            'total_score_after' => null,
            'status' => 'ongoing',
            'current_test' => 'last',
            'created_at' => $firstTestDate,
            'updated_at' => Carbon::now(),
        ]);

        $this->command->info('   - Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'));
        $this->command->info('   - Hari ini: ' . Carbon::now()->format('d M Y'));

        // Buat test pertama (sudah dikonfirmasi)
        $firstTestData = $this->generateFirstTestData($sleepTest->id, $firstTestDate, true);
        $firstTest = DailyTest::create($firstTestData);
        $firstTest->calculateScores()->save();
        
        $this->command->info('   - Test pertama: ' . $firstTest->total_score . ' poin (' . $firstTest->getQualityLevel() . ') - DIKONFIRMASI');

        // Buat test terakhir (sudah diisi tapi BELUM dikonfirmasi)
        $lastTestData = $this->generateLastTestData($sleepTest->id, $lastTestDate, false, $firstTest);
        $lastTest = DailyTest::create($lastTestData);
        $lastTest->calculateScores()->save();
        
        $this->command->info('   - Test terakhir: ' . $lastTest->total_score . ' poin (' . $lastTest->getQualityLevel() . ') - BELUM DIKONFIRMASI');
        
        // Update SleepTest dengan skor sebelum (karena test pertama sudah dikonfirmasi)
        $sleepTest->update([
            'total_score_before' => $firstTest->total_score,
            'updated_at' => Carbon::now(),
        ]);
        
        $improvement = $firstTest->total_score - $lastTest->total_score;
        $this->command->info('   - Perkiraan perbaikan jika dikonfirmasi: ' . ($improvement > 0 ? 'Membaik' : ($improvement < 0 ? 'Memburuk' : 'Stabil')) . ' (' . abs($improvement) . ' poin)');
        
        return $sleepTest;
    }

    /**
     * Versi alternatif: Buat test yang belum ada test terakhir
     */
    private function createTestWaitingForLastDay($pengguna)
    {
        $this->command->info('');
        $this->command->info('Membuat Sleep Test untuk: ' . $pengguna->nama_lengkap);
        $this->command->info('Skenario: Test ongoing, hari pertama sudah dikonfirmasi, menunggu hari ke-7');

        // Test yang dimulai 2 hari lalu, berakhir 5 hari lagi
        $startDate = Carbon::now()->subDays(2);
        $endDate = Carbon::now()->addDays(5);
        $firstTestDate = $startDate;

        // Buat SleepTest
        $sleepTest = SleepTest::create([
            'pengguna_id' => $pengguna->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_score_before' => null,
            'total_score_after' => null,
            'status' => 'ongoing',
            'current_test' => 'first',
            'created_at' => $firstTestDate,
            'updated_at' => Carbon::now(),
        ]);

        $this->command->info('   - Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'));
        $this->command->info('   - Hari ke-7 akan jatuh pada: ' . $endDate->format('d M Y'));

        // Buat test pertama (sudah dikonfirmasi)
        $firstTestData = $this->generateFirstTestData($sleepTest->id, $firstTestDate, true);
        $firstTest = DailyTest::create($firstTestData);
        $firstTest->calculateScores()->save();
        
        $this->command->info('   - Test pertama: ' . $firstTest->total_score . ' poin (' . $firstTest->getQualityLevel() . ') - DIKONFIRMASI');
        $this->command->info('   - Test terakhir: BELUM DIBUAT (menunggu hari ke-7)');
        
        // Update SleepTest dengan skor sebelum
        $sleepTest->update([
            'total_score_before' => $firstTest->total_score,
            'updated_at' => Carbon::now(),
        ]);
        
        return $sleepTest;
    }
}