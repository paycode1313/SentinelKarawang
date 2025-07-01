<?php

// File: database/migrations/2023_01_04_000000_create_activities_table.php

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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key ke tabel users
            $table->string('type'); // Tipe aktivitas (e.g., 'tree_planting', 'river_cleaning', 'pollution_report')
            $table->text('description')->nullable(); // Deskripsi aktivitas
            $table->decimal('location_lat', 10, 8)->nullable(); // Latitude lokasi aktivitas
            $table->decimal('location_lon', 11, 8)->nullable(); // Longitude lokasi aktivitas
            $table->string('image_url')->nullable(); // URL gambar bukti (jika ada)
            $table->string('status')->default('pending'); // Status aktivitas (pending, approved, rejected)
            $table->integer('points_earned')->default(0); // Poin yang didapatkan dari aktivitas
            $table->date('activity_date'); // Tanggal aktivitas dilakukan
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};

?>