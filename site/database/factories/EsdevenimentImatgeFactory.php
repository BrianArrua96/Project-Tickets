<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EsdevenimentImatge;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EsdevenimentImatge>
 */
class EsdevenimentImatgeFactory extends Factory
{
    protected $model = EsdevenimentImatge::class;

    public function definition()
    {
        return [
            'imatge' => $this->faker->imageUrl(),
        ];
    }
}
