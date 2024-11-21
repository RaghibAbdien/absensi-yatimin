<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna; // Model Pengguna
use App\Models\TanggalPresensi; // Model TanggalPresensi
use App\Models\Presensi; // Model Presensi

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $penggunas = Pengguna::all();

        $tanggalPresensis = TanggalPresensi::all();

        foreach ($penggunas as $pengguna) {
            foreach ($tanggalPresensis as $tanggal) {
                Presensi::updateOrCreate(
                    [
                        'pengguna_id' => $pengguna->id,
                        'tanggal_id' => $tanggal->id,
                    ],
                    [
                        'foto' => null,
                    ]
                );
            }
        }

        $this->command->info('Data presensi berhasil di-generate dengan foto null.');
    }
}
