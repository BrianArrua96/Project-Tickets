<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrada>
 */
class EntradaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->name,
            'preu' => $this->faker->randomFloat(2, 10, 1000),
            'quantitat' => $this->faker->randomNumber(3),
            'nominal' => $this->faker->boolean(),
        ];
    }
}
