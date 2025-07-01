<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\SensorReading;
use Illuminate\Support\Facades\Log; // Untuk logging

class SensorDataController extends Controller
{
    /**
     * Menerima data sensor dari perangkat IoT.
     * Metode ini akan menyimpan data ke tabel sensor_readings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'sensor_id' => 'required|exists:sensors,id', // Pastikan sensor_id ada di tabel 'sensors'
            'value' => 'required|json', // Nilai sensor diharapkan dalam format JSON string
            'unit' => 'nullable|string', // Satuan nilai sensor (opsional)
            'recorded_at' => 'required|date', // Waktu bacaan sensor dicatat
            // Anda bisa menambahkan validasi lain seperti 'api_key' atau token untuk keamanan
        ]);

        try {
            // Temukan sensor berdasarkan ID
            $sensor = Sensor::find($validatedData['sensor_id']);

            if (!$sensor) {
                return response()->json(['message' => 'Sensor tidak ditemukan.'], 404);
            }

            // Buat entri baru di tabel sensor_readings
            $reading = SensorReading::create([
                'sensor_id' => $sensor->id,
                'value' => json_decode($validatedData['value']), // Simpan sebagai JSON
                'unit' => $validatedData['unit'] ?? null,
                'recorded_at' => $validatedData['recorded_at'],
            ]);

            // Opsional: Perbarui 'last_reading_at' di tabel sensors
            $sensor->last_reading_at = $validatedData['recorded_at'];
            $sensor->save();

            Log::info('Data sensor berhasil disimpan.', ['sensor_id' => $sensor->id, 'reading_id' => $reading->id]);

            return response()->json(['message' => 'Data sensor berhasil diterima dan disimpan.', 'data' => $reading], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi
            Log::error('Error validasi data sensor:', ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Tangani error lainnya
            Log::error('Gagal menyimpan data sensor:', ['error' => $e->getMessage(), 'request' => $request->all()]);
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data sensor.', 'error' => $e->getMessage()], 500);
        }
    }
}
