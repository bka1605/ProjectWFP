<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('articles')->insert([
            [
                'judul' => 'Langkah - Langkah Menjaga Kesehatan Liver',
                'kategori' => 'Kesehatan',
                'tanggal_publish' => '2024-01-02',
            ]
        ]);
    }
}
