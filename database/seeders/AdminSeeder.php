<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nama_lengkap' => 'Admin Puput',
            'nomor_telepon' => '081234567890',
            'email' => 'adminpuput@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}