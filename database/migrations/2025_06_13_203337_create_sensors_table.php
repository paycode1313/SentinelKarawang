<?php

// File: database/migrations/2023_01_02_000000_create_sensors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama sensor (e.g., Sensor Kualitas Udara - Karawang Barat)
            $table->string('type'); // Tipe sensor (e.g., 'air_quality', 'water_level', 'river_pollution')
            $table->decimal('location_lat', 10, 8); // Latitude lokasi sensor
            $table->decimal('location_lon', 11, 8); // Longitude lokasi sensor
            $table->string('status')->default('active'); // Status sensor (active, inactive)
            $table->timestamp('last_reading_at')->nullable(); // Waktu terakhir sensor mengirim data
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};

?>