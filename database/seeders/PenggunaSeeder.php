<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data pengguna ibu hamil
        $pengguna = [
            [
                'nama_lengkap' => 'Pengguna Pertama',
                'nomor_telepon' => '081234567890',
                'pin' => Hash::make('2222'),
                'umur' => 28,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Melati No. 123, Jakarta Selatan',
                'usia_kehamilan' => 24,
                'hamil_anak_ke' => 2,
                'jumlah_anak' => 1,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Masukkan data ke database
        foreach ($pengguna as $data) {
            $existing = Pengguna::where('nomor_telepon', $data['nomor_telepon'])->first();
            
            if (!$existing) {
                Pengguna::create($data);
            }
        }
    }
}