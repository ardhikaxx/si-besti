<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SleepTracking extends Model
{
    use HasFactory;

    protected $table = 'sleep_trackings';

    protected $fillable = [
        'pengguna_id',
        'tanggal_tidur',
        'waktu_tidur',
        'waktu_bangun',
        'jumlah_kebangunan',
        'waktu_tidur_kembali', // Ditambahkan
        'alasan_kebangunan',
        'catatan_lain',
        'durasi_tidur'
    ];

    protected $casts = [
        'tanggal_tidur' => 'date',
        'waktu_tidur' => 'datetime:H:i',
        'waktu_bangun' => 'datetime:H:i',
        'durasi_tidur' => 'decimal:2',
        'waktu_tidur_kembali' => 'integer'
    ];

    /**
     * Relasi ke model Pengguna
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    /**
     * Hitung durasi tidur otomatis dalam jam (desimal)
     */
    public function calculateDuration()
    {
        $sleepTime = strtotime($this->waktu_tidur);
        $wakeTime = strtotime($this->waktu_bangun);
        
        // Jika waktu bangun lebih kecil dari waktu tidur (melewati tengah malam)
        if ($wakeTime < $sleepTime) {
            $wakeTime += 24 * 3600; // Tambah 24 jam
        }
        
        $durationInSeconds = $wakeTime - $sleepTime;
        $durationInHours = $durationInSeconds / 3600; // Konversi ke jam
        
        $this->durasi_tidur = round($durationInHours, 2); // Simpan dengan 2 desimal
        return $this->durasi_tidur;
    }

    /**
     * Format durasi tidur dalam jam dan menit
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->durasi_tidur) {
            return '-';
        }
        
        $hours = floor((float)$this->durasi_tidur);
        $minutes = round(((float)$this->durasi_tidur - $hours) * 60);
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours} jam {$minutes} menit";
        } elseif ($hours > 0) {
            return "{$hours} jam";
        } else {
            return "{$minutes} menit";
        }
    }

    /**
     * Format waktu tidur kembali dalam menit
     */
    public function getFormattedWakeBackTimeAttribute()
    {
        if (!$this->waktu_tidur_kembali) {
            return '-';
        }
        
        return "{$this->waktu_tidur_kembali} menit";
    }

    /**
     * Format durasi tidur dalam jam desimal
     */
    public function getDurationDecimalAttribute()
    {
        if (!$this->durasi_tidur) {
            return '0.00';
        }
        
        return number_format((float)$this->durasi_tidur, 2);
    }

    /**
     * Format waktu tidur
     */
    public function getFormattedSleepTimeAttribute()
    {
        return date('H:i', strtotime($this->waktu_tidur));
    }

    /**
     * Format waktu bangun
     */
    public function getFormattedWakeTimeAttribute()
    {
        return date('H:i', strtotime($this->waktu_bangun));
    }

    /**
     * Format tanggal tidur
     */
    public function getFormattedDateAttribute()
    {
        return date('d F Y', strtotime($this->tanggal_tidur));
    }

    /**
     * Format durasi untuk statistik
     */
    public function getDurationForStatsAttribute()
    {
        if (!$this->durasi_tidur) {
            return '0 jam';
        }
        
        $hours = floor((float)$this->durasi_tidur);
        $minutes = round(((float)$this->durasi_tidur - $hours) * 60);
        
        return "{$hours} jam {$minutes} menit";
    }

    /**
     * Cek apakah memiliki waktu tidur kembali
     */
    public function hasWakeBackTime()
    {
        return $this->waktu_tidur_kembali !== null && $this->waktu_tidur_kembali > 0;
    }
}