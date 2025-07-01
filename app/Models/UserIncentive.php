<?php

// File: app/Models/UserIncentive.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIncentive extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'incentive_id',
        'status',
        'redeemed_at',
    ];

    /**
     * Atribut yang harus dikonversi ke tipe data asli.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'redeemed_at' => 'datetime',
    ];

    /**
     * Dapatkan pengguna yang terkait dengan insentif ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dapatkan insentif yang terkait.
     */
    public function incentive()
    {
        return $this->belongsTo(Incentive::class);
    }
}

?>
