<?php

// File: app/Models/Incentive.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'points_required',
        'stock',
        'is_active',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data asli.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Dapatkan semua permintaan insentif yang terkait.
     */
    public function userIncentives()
    {
        return $this->hasMany(UserIncentive::class);
    }
}

?>