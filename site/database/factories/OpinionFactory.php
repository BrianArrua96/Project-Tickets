<?php

namespace Database\Factories;

use App\Models\Opinion;
use App\Models\User;
use App\Models\Esdeveniment;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpinionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Opinion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->name,
            'emocio' => $this->faker->numberBetween(1, 3),
            'puntuacio' => $this->faker->numberBetween(1, 5),
            'titol' => $this->faker->sentence,
            'comentari' => $this->faker->paragraph,
        ];
    }
}