<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'category_name' => 'General Consultation',
                'image' => 'category/general_consultation.jpg',
            ],
            [
                'category_name' => 'Specialist Consultation',
                'image' => 'category/specialist_consultation.jpg',
            ],
            [
                'category_name' => 'Medical Checkup',
                'image' => 'category/medical_checkup.jpg',
            ],
            [
                'category_name' => 'Laboratory Tests',
                'image' => 'category/laboratory_tests.jpg',
            ],
            [
                'category_name' => 'Telemedicine',
                'image' => 'category/telemedicine.jpg',
            ],
        ]);
    }
}