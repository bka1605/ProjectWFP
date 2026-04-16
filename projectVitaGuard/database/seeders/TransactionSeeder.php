<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('transaction')->insert([
            [
                'nama_pembeli'=>'Chellyne',
                'tanggal_transaksi'=>now(),
                'status'=>'completed',
            ]
        ]);
    }
}
