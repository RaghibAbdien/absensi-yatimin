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
        $startDate = Carbon::create(2025, 2, 1); // Awal Februari
        $endDate = Carbon::create(2025, 3, 31); // Akhir Maret

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            TanggalPresensi::updateOrCreate([
                'tanggal' => $date->format('Y-m-d'),
            ]);
        }

        $this->command->info('Semua tanggal dari bulan Februari hingga Maret berhasil dimasukkan.');
    }
}
