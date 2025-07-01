<?php

// File: database/migrations/2023_01_03_000000_create_sensor_readings_table.php

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
        Schema::create('sensor_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained('sensors')->onDelete('cascade'); // Foreign key ke tabel sensors
            $table->json('value'); // Nilai bacaan sensor dalam format JSON (misal: {'pm2_5': 25, 'co2': 400})
            $table->string('unit')->nullable(); // Satuan nilai (e.g., 'µg/m³', 'ppm', 'cm')
            $table->timestamp('recorded_at'); // Waktu bacaan dicatat
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_readings');
    }
};

?>