<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // <-- INI ADALAH PERBAIKANNYA
        'email',
        'password',
        'role', // Juga menambahkan 'role' sesuai migrasi Anda
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Penting untuk hashing otomatis
        ];
    }

    /**
     * Relasi ke tabel Activity
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Relasi ke tabel UserIncentive
     */
    public function userIncentives()
    {
        return $this->hasMany(UserIncentive::class);
    }
}