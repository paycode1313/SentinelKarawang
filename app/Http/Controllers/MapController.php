<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor; // Impor model Sensor

class MapController extends Controller
{
    /**
     * Menampilkan halaman peta monitoring.
     *
     * @return \Illuminate\View\View
     */
   // ... di dalam MapController.php ...
// Ganti seluruh method index() Anda dengan ini:
// Ganti seluruh method index() Anda dengan ini:
public function index()
{
    // Cukup ambil data sensor dengan bacaan terakhirnya.
    // Logika untuk 'suggestion' akan otomatis dijalankan oleh Model.
    $sensors = Sensor::with('latestReading')->get();

    return view('map.index', compact('sensors'));
}
}