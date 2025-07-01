<?php

// File: app/Models/SensorReading.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sensor_id',
        'value',
        'unit',
        'recorded_at',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data asli.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'array', // Mengonversi kolom 'value' dari JSON ke array PHP
        'recorded_at' => 'datetime',
    ];

    /**
     * Dapatkan sensor yang terkait dengan pembacaan ini.
     */
    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}

?>