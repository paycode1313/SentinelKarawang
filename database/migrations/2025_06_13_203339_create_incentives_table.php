<?php

// File: database/migrations/2023_01_05_000000_create_incentives_table.php

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
        Schema::create('incentives', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama insentif (e.g., Voucher Belanja, Diskon Pajak)
            $table->text('description')->nullable(); // Deskripsi insentif
            $table->integer('points_required'); // Jumlah poin yang dibutuhkan untuk mendapatkan insentif
            $table->integer('stock')->nullable(); // Stok insentif (jika terbatas)
            $table->boolean('is_active')->default(true); // Status aktif insentif
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('incentives');
    }
};

?>