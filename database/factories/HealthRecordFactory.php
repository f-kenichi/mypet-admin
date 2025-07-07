<?php

namespace Database\Factories;

use App\Models\HealthRecord;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

class HealthRecordFactory extends Factory
{
    protected $model = HealthRecord::class;

    public function definition(): array
    {
        return [
            'pet_id' => Pet::factory(), // ペットに関連付け
            'weight' => $this->faker->randomFloat(2, 1, 50), // 1kg〜50kgのランダムな体重
            'temperature' => $this->faker->randomFloat(1, 35, 40), // 35℃〜40℃のランダムな体温
            'mood' => $this->faker->randomElement(['Happy', 'Neutral', 'Sad']), // ランダムな気分
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}