<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\SleepTracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenggunaSleepTrackingSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Membuat 20 data pengguna dan sleep tracking...');
        $this->command->info('===========================================');

        $penggunaData = [
            [
                'nama_lengkap' => 'Siti Aminah',
                'nomor_telepon' => '081234567891',
                'umur' => 26,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Mangga Raya No. 45, Jakarta Pusat',
                'usia_kehamilan' => 20,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Dewi Lestari',
                'nomor_telepon' => '081234567892',
                'umur' => 29,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Melati Putih No. 12, Bandung',
                'usia_kehamilan' => 28,
                'hamil_anak_ke' => 2,
                'jumlah_anak' => 1,
            ],
            [
                'nama_lengkap' => 'Rina Susilowati',
                'nomor_telepon' => '081234567893',
                'umur' => 32,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Kenanga No. 78, Surabaya',
                'usia_kehamilan' => 24,
                'hamil_anak_ke' => 3,
                'jumlah_anak' => 2,
            ],
            [
                'nama_lengkap' => 'Maya Kartika',
                'nomor_telepon' => '081234567894',
                'umur' => 24,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Daisy No. 33, Yogyakarta',
                'usia_kehamilan' => 16,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Fatma Azizah',
                'nomor_telepon' => '081234567895',
                'umur' => 31,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sakura No. 56, Semarang',
                'usia_kehamilan' => 32,
                'hamil_anak_ke' => 2,
                'jumlah_anak' => 1,
            ],
            [
                'nama_lengkap' => 'Lina Marlina',
                'nomor_telepon' => '081234567896',
                'umur' => 27,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Apel No. 22, Medan',
                'usia_kehamilan' => 22,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Nurul Hidayah',
                'nomor_telepon' => '081234567897',
                'umur' => 30,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Bougenville No. 89, Makassar',
                'usia_kehamilan' => 26,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Putri Amanda',
                'nomor_telepon' => '081234567898',
                'umur' => 25,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Mawar Merah No. 15, Palembang',
                'usia_kehamilan' => 18,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Sri Wahyuni',
                'nomor_telepon' => '081234567899',
                'umur' => 33,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Tulip No. 67, Tangerang',
                'usia_kehamilan' => 30,
                'hamil_anak_ke' => 4,
                'jumlah_anak' => 3,
            ],
            [
                'nama_lengkap' => 'Annisa Rahmawati',
                'nomor_telepon' => '081234567801',
                'umur' => 28,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Lavender No. 44, Bekasi',
                'usia_kehamilan' => 25,
                'hamil_anak_ke' => 2,
                'jumlah_anak' => 1,
            ],
            [
                'nama_lengkap' => 'Hidayati',
                'nomor_telepon' => '081234567802',
                'umur' => 35,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Edelweis No. 91, Bogor',
                'usia_kehamilan' => 34,
                'hamil_anak_ke' => 3,
                'jumlah_anak' => 2,
            ],
            [
                'nama_lengkap' => 'Yuni Astuti',
                'nomor_telepon' => '081234567803',
                'umur' => 26,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Jasmine No. 28, Depok',
                'usia_kehamilan' => 19,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Sari Dewi',
                'nomor_telepon' => '081234567804',
                'umur' => 29,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Teratai No. 53, Solo',
                'usia_kehamilan' => 27,
                'hamil_anak_ke' => 2,
                'jumlah_anak' => 1,
            ],
            [
                'nama_lengkap' => 'Ratna Sari',
                'nomor_telepon' => '081234567805',
                'umur' => 31,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Orchid No. 36, Malang',
                'usia_kehamilan' => 23,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Diah Ayu',
                'nomor_telepon' => '081234567806',
                'umur' => 27,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Flamboyan No. 72, Denpasar',
                'usia_kehamilan' => 21,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Wati Susilowati',
                'nomor_telepon' => '081234567807',
                'umur' => 30,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Kemuning No. 19, Lombok',
                'usia_kehamilan' => 29,
                'hamil_anak_ke' => 2,
                'jumlah_anak' => 1,
            ],
            [
                'nama_lengkap' => 'Eka Prasetyowati',
                'nomor_telepon' => '081234567808',
                'umur' => 24,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Alamanda No. 62, Bali',
                'usia_kehamilan' => 17,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Ira Marliani',
                'nomor_telepon' => '081234567809',
                'umur' => 32,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Kamboja No. 84, Bandung',
                'usia_kehamilan' => 31,
                'hamil_anak_ke' => 3,
                'jumlah_anak' => 2,
            ],
            [
                'nama_lengkap' => 'Novi Lestari',
                'nomor_telepon' => '081234567810',
                'umur' => 28,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Matahari No. 27, Jakarta Barat',
                'usia_kehamilan' => 24,
                'hamil_anak_ke' => 1,
                'jumlah_anak' => 0,
            ],
            [
                'nama_lengkap' => 'Susilowati',
                'nomor_telepon' => '081234567811',
                'umur' => 33,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Bulan No. 41, Jakarta Timur',
                'usia_kehamilan' => 35,
                'hamil_anak_ke' => 2,
                'jumlah_anak' => 1,
            ],
        ];

        $alasanKebangunanOptions = [
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

        $waktuTidurKembaliOptions = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60];

        foreach ($penggunaData as $index => $data) {
            $existingPengguna = Pengguna::where('nomor_telepon', $data['nomor_telepon'])->first();
            
            if ($existingPengguna) {
                $pengguna = $existingPengguna;
                $this->command->info('Pengguna sudah ada: ' . $pengguna->nama_lengkap);
            } else {
                $pengguna = Pengguna::create([
                    'nama_lengkap' => $data['nama_lengkap'],
                    'nomor_telepon' => $data['nomor_telepon'],
                    'pin' => Hash::make('2222'),
                    'umur' => $data['umur'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'alamat' => $data['alamat'],
                    'usia_kehamilan' => $data['usia_kehamilan'],
                    'hamil_anak_ke' => $data['hamil_anak_ke'],
                    'jumlah_anak' => $data['jumlah_anak'],
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            SleepTracking::where('pengguna_id', $pengguna->id)->delete();

            $this->command->info('Membuat 20 data sleep tracking untuk: ' . $pengguna->nama_lengkap);

            for ($i = 0; $i < 20; $i++) {
                $tanggalTidur = Carbon::now()->subDays($i);
                $sleepDate = $tanggalTidur->copy()->setTime(0, 0, 0);

                $waktuTidurHour = rand(21, 23);
                $waktuTidurMinute = rand(0, 59);
                if ($waktuTidurHour == 23 && $waktuTidurMinute > 30) {
                    $waktuTidurMinute = rand(0, 30);
                }
                $waktuTidur = sprintf('%02d:%02d', $waktuTidurHour, $waktuTidurMinute);

                $waktuBangunHour = rand(5, 8);
                $waktuBangunMinute = rand(0, 59);
                if ($waktuBangunHour == 8 && $waktuBangunMinute > 30) {
                    $waktuBangunMinute = rand(0, 30);
                }
                $waktuBangun = sprintf('%02d:%02d', $waktuBangunHour, $waktuBangunMinute);

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
                
                $alasanIndex = $jumlahKebangunan > 0 ? rand(1, count($alasanKebangunanOptions) - 1) : 0;
                $alasanKebangunan = $alasanKebangunanOptions[$alasanIndex] ?? null;
                
                $waktuTidurKembali = null;
                if ($jumlahKebangunan > 0) {
                    if (rand(1, 100) <= 70) {
                        $waktuTidurKembali = $waktuTidurKembaliOptions[array_rand($waktuTidurKembaliOptions)];
                        
                        if ($jumlahKebangunan >= 4) {
                            $waktuTidurKembali += rand(10, 30);
                        }
                        
                        $waktuTidurKembali = min($waktuTidurKembali, 90);
                    }
                }
                
                $catatanIndex = rand(0, count($catatanLainOptions) - 1);
                $catatanLain = $catatanLainOptions[$catatanIndex];

                $sleepTime = Carbon::createFromTimeString($waktuTidur);
                $wakeTime = Carbon::createFromTimeString($waktuBangun);
                
                if ($wakeTime->lessThan($sleepTime)) {
                    $wakeTime->addDay();
                }
                
                $durationInHours = $wakeTime->diffInMinutes($sleepTime) / 60;
                
                $baseDuration = rand(7, 8);
                $variation = (rand(-20, 20) / 60);
                $durationInHours = max(4.5, min(9.5, $baseDuration + $variation));
                
                if ($waktuTidurKembali && $jumlahKebangunan > 0) {
                    $totalWakeBackTime = $waktuTidurKembali * $jumlahKebangunan;
                    $durationInHours -= ($totalWakeBackTime / 60);
                    $durationInHours = max(4.0, $durationInHours);
                }

                SleepTracking::create([
                    'pengguna_id' => $pengguna->id,
                    'tanggal_tidur' => $sleepDate,
                    'waktu_tidur' => $waktuTidur,
                    'waktu_bangun' => $waktuBangun,
                    'jumlah_kebangunan' => $jumlahKebangunan,
                    'waktu_tidur_kembali' => $waktuTidurKembali,
                    'alasan_kebangunan' => $alasanKebangunan,
                    'catatan_lain' => $catatanLain,
                    'durasi_tidur' => round($durationInHours, 2),
                    'created_at' => $sleepDate->copy()->addHours(rand(6, 9)),
                    'updated_at' => $sleepDate->copy()->addHours(rand(6, 9)),
                ]);
            }

            $this->command->info('-> 20 data sleep tracking dibuat untuk ' . $pengguna->nama_lengkap);
            $this->command->info('');
        }

        $totalPengguna = Pengguna::count();
        $totalSleepTracking = SleepTracking::count();
        
        $this->command->info('===========================================');
        $this->command->info('SEEDER SELESAI!');
        $this->command->info('Total Pengguna: ' . $totalPengguna);
        $this->command->info('Total Sleep Tracking: ' . $totalSleepTracking);
        $this->command->info('===========================================');
    }
}
