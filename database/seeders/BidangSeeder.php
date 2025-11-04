<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        $bidangs = [
            'Akuntansi',
            'Sekretariat',
            'Anggaran',
            'Keuangan',
            'Perbendaharaan',
        ];

        // Hapus data lama dengan delete (bukan truncate)
        DB::table('bidangs')->delete();

        // Insert bidang baru
        foreach ($bidangs as $bidang) {
            DB::table('bidangs')->insert([
                'nama_bidang' => $bidang,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}