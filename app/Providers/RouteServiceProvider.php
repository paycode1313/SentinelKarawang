<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Jalur ke "home" untuk aplikasi Anda.
     * Biasanya digunakan oleh fitur autentikasi Laravel.
     *
     * @var string
     */
    // UBAH BARIS INI UNTUK MENGARAHKAN KE DASHBOARD KUSTOM ANDA
    public const HOME = '/sentinel-dashboard'; 

    /**
     * Daftarkan layanan aplikasi apa pun.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrapping layanan aplikasi apa pun.
     */
    public function boot(): void
    {
        // Konfigurasi Rate Limiting API (bawaan Laravel)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Definisikan bagaimana rute-rute aplikasi Anda dimuat
        $this->routes(function () {
            // Rute API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Rute Web (termasuk dashboard kustom dan otentikasi Breeze)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
