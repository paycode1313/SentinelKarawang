<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Sensor; // Impor model Sensor

class SearchController extends Controller
{
    /**
     * Menangani permintaan pencarian dari pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search(Request $request)
    {
        $query = Str::lower($request->input('query'));

        if (!$query) {
            return back();
        }

        // --- FITUR BARU: Pencarian Berdasarkan Lokasi Sensor ---
        // Mencari sensor yang namanya mengandung query
        $sensor = Sensor::where('name', 'LIKE', "%{$query}%")->first();

        if ($sensor) {
            // Jika sensor ditemukan, arahkan ke peta dengan koordinat sensor tersebut
            return redirect()->route('map.index', [
                'lat' => $sensor->location_lat,
                'lon' => $sensor->location_lon,
                'zoom' => 15 // Berikan level zoom yang lebih dekat
            ]);
        }
        
        // --- Logika Lama: Pencarian Berdasarkan Kata Kunci Halaman ---
        if (Str::contains($query, ['peta', 'lokasi', 'monitoring'])) {
            return redirect()->route('map.index');
        }

        if (Str::contains($query, ['insentif', 'poin', 'program', 'klaim'])) {
            return redirect()->route('incentives.index');
        }
        
        if (Str::contains($query, ['riwayat', 'histori', 'aktivitas'])) {
            return redirect()->route('incentives.history');
        }

        if (Str::contains($query, ['profil', 'akun', 'password', 'edit'])) {
            return redirect()->route('profile.edit');
        }

        if (Str::contains($query, ['lapor', 'buat', 'baru'])) {
            return redirect()->route('incentives.create-activity');
        }

        // Jika tidak ada yang cocok, kembali ke halaman sebelumnya dengan pesan
        return back()->with('info', 'Tidak ditemukan halaman atau lokasi yang cocok dengan pencarian Anda.');
    }
}