<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TanggalPresensi;
use Carbon\Carbon;

class TanggalPresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startDate = Carbon::create(2024, 11, 1); // Awal November
        $endDate = Carbon::create(2025, 1, 31); // Akhir Januari

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            TanggalPresensi::updateOrCreate([
                'tanggal' => $date->format('Y-m-d'),
            ]);
        }

        $this->command->info('Semua tanggal dari bulan November hingga Januari berhasil dimasukkan.');
    }
}
