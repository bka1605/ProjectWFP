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
                'image' => 'img/category/general_consultation.jpg',
            ],
            [
                'category_name' => 'Specialist Consultation',
                'image' => 'img/category/specialist_consultation.jpg',
            ],
            [
                'category_name' => 'Medical Checkup',
                'image' => 'img/category/medical_checkup.jpg',
            ],
            [
                'category_name' => 'Laboratory Tests',
                'image' => 'img/category/laboratory_tests.jpg',
            ],
            [
                'category_name' => 'Telemedicine',
                'image' => 'img/category/telemedicine.jpg',
            ],
        ]);
    }
}