<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sensor;
use App\Models\SensorReading;
use Illuminate\Support\Carbon;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === SENSOR LAMA ===
        $sensor1 = Sensor::create([
            'name' => 'Sensor Kualitas Udara - Karawang Kota',
            'type' => 'air_quality',
            'location_lat' => -6.3283,
            'location_lon' => 107.3023,
            'status' => 'active',
        ]);
        // Data bacaan (dibuat jadi KONDISI BURUK untuk tes)
        SensorReading::create([
            'sensor_id' => $sensor1->id,
            'value' => json_encode(['pm2_5' => 65, 'co2' => 800]),
            'unit' => 'µg/m³, ppm',
            'recorded_at' => Carbon::now()->subMinutes(5),
        ]);


        $sensor2 = Sensor::create([
            'name' => 'Sensor Ketinggian Air - Citarum (Tanjungpura)',
            'type' => 'water_level',
            'location_lat' => -6.2847,
            'location_lon' => 107.2952,
            'status' => 'active',
        ]);
        SensorReading::create([
            'sensor_id' => $sensor2->id,
            'value' => json_encode(['level' => 150]),
            'unit' => 'cm',
            'recorded_at' => Carbon::now()->subMinutes(10),
        ]);

        // === SENSOR BARU ===

        // 3. Rengasdengklok
        $sensor3 = Sensor::create([
            'name' => 'Sensor Pencemaran Sungai - Rengasdengklok',
            'type' => 'river_pollution',
            'location_lat' => -6.1642,
            'location_lon' => 107.2944,
            'status' => 'active',
        ]);
        // Data bacaan (dibuat jadi KONDISI BURUK untuk tes)
        SensorReading::create([
            'sensor_id' => $sensor3->id,
            'value' => json_encode(['ph' => 5.5, 'turbidity' => 45]),
            'unit' => 'pH, NTU',
            'recorded_at' => Carbon::now()->subMinutes(15),
        ]);

        // 4. Pinayungan (Telukjambe Timur)
        $sensor4 = Sensor::create([
            'name' => 'Sensor Kualitas Udara - Pinayungan',
            'type' => 'air_quality',
            'location_lat' => -6.3475,
            'location_lon' => 107.3170,
            'status' => 'active',
        ]);
        SensorReading::create([
            'sensor_id' => $sensor4->id,
            'value' => json_encode(['pm2_5' => 25, 'co2' => 410]),
            'unit' => 'µg/m³, ppm',
            'recorded_at' => Carbon::now()->subMinutes(20),
        ]);

        // 5. Cikampek
        $sensor5 = Sensor::create([
            'name' => 'Sensor Ketinggian Air - Cikampek',
            'type' => 'water_level',
            'location_lat' => -6.4065,
            'location_lon' => 107.4550,
            'status' => 'active',
        ]);
        SensorReading::create([
            'sensor_id' => $sensor5->id,
            'value' => json_encode(['level' => 210]), // Dibuat tinggi untuk tes
            'unit' => 'cm',
            'recorded_at' => Carbon::now()->subMinutes(25),
        ]);
        
        // 6. Klari
        $sensor6 = Sensor::create([
            'name' => 'Sensor Kualitas Udara - Klari',
            'type' => 'air_quality',
            'location_lat' => -6.3530,
            'location_lon' => 107.3550,
            'status' => 'inactive', // Contoh sensor tidak aktif
        ]);
        // Tidak ada data bacaan karena sensor tidak aktif

        // 7. Cilamaya
        $sensor7 = Sensor::create([
            'name' => 'Sensor Pencemaran Sungai - Cilamaya Wetan',
            'type' => 'river_pollution',
            'location_lat' => -6.2167,
            'location_lon' => 107.5500,
            'status' => 'active',
        ]);
        SensorReading::create([
            'sensor_id' => $sensor7->id,
            'value' => json_encode(['ph' => 7.1, 'turbidity' => 12]),
            'unit' => 'pH, NTU',
            'recorded_at' => Carbon::now()->subMinutes(30),
        ]);
    }
}