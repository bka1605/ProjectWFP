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
                'nama' => 'dr. Andi Pratama, Sp.PD',
                'spesialisasi' => 'Penyakit Dalam',
                'nomor_telepon' => '081234567899',
                'lama_kerja' => 10,
            ],
            [
                'nama' => 'dr. Sarah Wijaya, Sp.A',
                'spesialisasi' => 'Anak',
                'nomor_telepon' => '081298765432',
                'lama_kerja' => 8,
            ],
            [
                'nama' => 'dr. Budi Santoso, Sp.JP',
                'spesialisasi' => 'Jantung',
                'nomor_telepon' => '085678901234',
                'lama_kerja' => 15,
            ],
            [
                'nama' => 'dr. Rina Amelia, Sp.KK',
                'spesialisasi' => 'Kulit',
                'nomor_telepon' => '081122334455',
                'lama_kerja' => 5,
            ],
            [
                'nama' => 'dr. Michael Gunawan, Sp.THT',
                'spesialisasi' => 'THT',
                'nomor_telepon' => '081355667788',
                'lama_kerja' => 12,
            ],
            [
                'nama' => 'dr. Claudia Hartono, Sp.M',
                'spesialisasi' => 'Mata',
                'nomor_telepon' => '082211334455',
                'lama_kerja' => 7,
            ],
            [
                'nama' => 'dr. Kevin Setiawan, Sp.OT',
                'spesialisasi' => 'Ortopedi',
                'nomor_telepon' => '081377889900',
                'lama_kerja' => 14,
            ],
            [
                'nama' => 'dr. Natalia Kusuma, Sp.OG',
                'spesialisasi' => 'Kandungan',
                'nomor_telepon' => '085211223344',
                'lama_kerja' => 11,
            ],
            [
                'nama' => 'dr. Dimas Saputra, Sp.B',
                'spesialisasi' => 'Bedah Umum',
                'nomor_telepon' => '081566778899',
                'lama_kerja' => 9,
            ],
            [
                'nama' => 'dr. Felicia Tan, Sp.N',
                'spesialisasi' => 'Saraf',
                'nomor_telepon' => '082299887766',
                'lama_kerja' => 13,
            ],
        ]);
    }
}
