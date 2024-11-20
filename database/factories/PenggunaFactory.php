<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_induk' => $this->faker->unique()->numerify('####'),
            'nama_yatimin' => $this->faker->name,
            'kelahiran' => $this->faker->year,
            'alamat' => $this->faker->address,
            'foto' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
