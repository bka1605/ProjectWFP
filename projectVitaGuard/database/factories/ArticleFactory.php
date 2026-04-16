<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "judul" => $this->faker->sentence(),
            "kategori" => $this->faker->randomElement(['Kesehatan', 'Gaya Hidup', 'Teknologi', 'Olahraga', 'Pendidikan']),
            "konten" => $this->faker->paragraphs(3, true),
            "tanggal_publish" => $this->faker->date(),
        ];
    }
}
