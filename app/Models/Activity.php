<?php

// File: app/Models/Activity.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'location_lat',
        'location_lon',
        'image_url',
        'status',
        'points_earned',
        'activity_date',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data asli.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activity_date' => 'date',
    ];

    /**
     * Dapatkan pengguna yang memiliki aktivitas ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

?>