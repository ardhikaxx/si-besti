<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'penggunas';

    protected $fillable = [
        'nama_lengkap',
        'nomor_telepon',
        'pin',
        'umur',
        'jenis_kelamin',
        'alamat',
        'usia_kehamilan',
        'hamil_anak_ke',
        'jumlah_anak'
    ];

    protected $hidden = [
        'pin',
        'remember_token',
    ];

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Validate the PIN for authentication.
     *
     * @param  string  $pin
     * @return bool
     */
    public function validatePin($pin)
    {
        return Hash::check($pin, $this->pin);
    }

    /**
     * Relasi ke model SleepTest
     */
    public function sleepTest() {
        return $this->hasMany(SleepTest::class);
    }

    /**
     * Relasi ke model SleepTracking
     */
    public function sleepTrackings()
    {
        return $this->hasMany(SleepTracking::class);
    }
}
