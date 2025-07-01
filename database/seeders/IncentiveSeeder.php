<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incentive;

class IncentiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incentive::create([
            'name' => 'Voucher Belanja Hijau',
            'description' => 'Tukarkan poin Anda dengan voucher belanja di toko ramah lingkungan.',
            'points_required' => 500,
            'stock' => 100,
            'is_active' => true,
        ]);

        Incentive::create([
            'name' => 'Diskon Pajak Daerah',
            'description' => 'Dapatkan potongan pajak daerah untuk kontribusi lingkungan Anda.',
            'points_required' => 1000,
            'stock' => null, // Tidak terbatas
            'is_active' => true,
        ]);

        Incentive::create([
            'name' => 'Pengakuan Pahlawan Lingkungan',
            'description' => 'Nama Anda akan diabadikan di daftar pahlawan lingkungan Karawang!',
            'points_required' => 2000,
            'stock' => null,
            'is_active' => true,
        ]);

        Incentive::create([
            'name' => 'Bibit Pohon Gratis',
            'description' => 'Dapatkan bibit pohon gratis untuk penghijauan di sekitar Anda.',
            'points_required' => 200,
            'stock' => 200,
            'is_active' => true,
        ]);
    }
}