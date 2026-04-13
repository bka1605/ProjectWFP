<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         DB::table('doctors')->insert([
            [
                'nama' => 'dr. Andi',
                'spepsialisasi' => 'penyakit dalam',
                'nomor_telepon' => '081234567899',
                'lama_kerja' => 10, 
            ]
        ]);
    }
}
