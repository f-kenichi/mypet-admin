<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visit;
use App\Models\Pet;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        // 既存のペットに関連付けて訪問記録を作成
        $pets = Pet::all();

        foreach ($pets as $pet) {
            Visit::factory()->count(3)->create([
                'pet_id' => $pet->id,
            ]);
        }
    }
}