<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'availability' => $this->faker->randomElement(['08:00 - 10:00', '10:00 - 12:00', '13:00 - 15:00', '16:00 - 18:00', '19:00 - 21:00']),
            'price' => $this->faker->randomFloat(2, 50, 500),
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
