<?php

// File: database/migrations/2023_01_06_000000_create_user_incentives_table.php

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
        Schema::create('user_incentives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key ke tabel users
            $table->foreignId('incentive_id')->constrained('incentives')->onDelete('cascade'); // Foreign key ke tabel incentives
            $table->string('status')->default('requested'); // Status permintaan (requested, redeemed, rejected)
            $table->timestamp('redeemed_at')->nullable(); // Waktu insentif ditebus
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_incentives');
    }
};

?>