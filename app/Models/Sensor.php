<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'location_lat', 'location_lon', 'status', 'last_reading_at',
    ];

    protected $appends = ['suggestion'];

    public function readings()
    {
        return $this->hasMany(SensorReading::class);
    }

    public function latestReading()
    {
        return $this->hasOne(SensorReading::class)->latestOfMany('recorded_at');
    }

    public function getSuggestionAttribute()
    {
        $latestReading = $this->readings()->latest('recorded_at')->first();

        if ($latestReading) {
            // PERBAIKAN: Pastikan $value adalah array. Jika masih string, decode dulu.
            $value = is_string($latestReading->value) 
                ? json_decode($latestReading->value, true) 
                : $latestReading->value;

            if (is_array($value)) {
                // Aturan 1: Kualitas Udara Buruk
                if ($this->type === 'air_quality' && isset($value['pm2_5']) && $value['pm2_5'] > 55) {
                    return ['message' => 'Kualitas udara di area ini kurang baik. Penanaman pohon sangat disarankan.', 'activity_type' => 'tree_planting'];
                }

                // Aturan 2: Level Air Tinggi
                if ($this->type === 'water_level' && isset($value['level']) && $value['level'] > 200) {
                     return ['message' => 'Level air di atas batas normal. Normalisasi atau pembersihan sungai diperlukan.', 'activity_type' => 'river_cleaning'];
                }
                
                // Aturan 3: pH Air Tidak Normal
                if ($this->type === 'river_pollution' && isset($value['ph']) && ($value['ph'] < 6 || $value['ph'] > 8.5)) {
                     return ['message' => 'Tingkat keasaman (pH) air tidak normal. Segera laporkan potensi pencemaran.', 'activity_type' => 'pollution_report'];
                }
            }
        }

        return null; 
    }
}