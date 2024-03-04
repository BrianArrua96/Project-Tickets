<?php

// database/factories/RecinteFactory.php

namespace Database\Factories;

use App\Models\Recinte;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecinteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recinte::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->word,
            'provincia' => $this->faker->state,
            'lloc' => $this->faker->city,
            'codi_postal' => $this->faker->postcode,
            'capacitat' => $this->faker->randomNumber(3),
            'carrer' => $this->faker->streetName,
            'numero' => $this->faker->buildingNumber,
        ];
    }
}
