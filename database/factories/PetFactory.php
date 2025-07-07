<?php

namespace Database\Factories;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    protected $model = Pet::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'species' => $this->faker->word,
            'breed' => $this->faker->word,
            'birth_date' => $this->faker->date,
            'gender' => $this->faker->randomElement(['male', 'female', 'unknown']),
            'weight' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}