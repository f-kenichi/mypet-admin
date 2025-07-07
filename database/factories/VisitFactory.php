<?php

namespace Database\Factories;

use App\Models\Visit;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition()
    {
        return [
            'pet_id' => Pet::factory(),
            'clinic' => $this->faker->company,
            'reason' => $this->faker->sentence,
            'date' => $this->faker->date,
        ];
    }
}