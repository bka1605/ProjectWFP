<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->call([
            CategoriesSeeder::class,
        ]);
        Doctor::factory(10)->create();
        Article::factory(10)->create();
        Service::factory(10)->create();
        Transaction::factory(10)->create();
        

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
