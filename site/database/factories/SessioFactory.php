<?php

namespace Database\Factories;

use App\Models\Sessio;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessioFactory extends Factory
{
    protected $model = Sessio::class;

    public function definition()
    {
        return [
            'data' => $this->faker->dateTime,
            'tancament' => $this->faker->dateTime,
            'aforament' => $this->faker->randomNumber(3),
            'estado' => $this->faker->boolean(true),
        ];
    }
}
