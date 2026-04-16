<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => "dr. " . $this->faker->name(),
            'spesialisasi' => $this->faker->randomElement(['Gigi', 'Kandungan', 'Anak', 'Umum', 'Mata', 'THT', 'Kulit', "Penyakit Dalam"]),
            'nomor_telepon' => $this->faker->phoneNumber(),
            'lama_kerja' => $this->faker->numberBetween(1, 30),
        ];
    }
}
