<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthRecord;
use App\Models\Pet;

class HealthRecordSeeder extends Seeder
{
    public function run(): void
    {
        // 既存のペットに関連付けて健康記録を作成
        $pets = Pet::all();

        foreach ($pets as $pet) {
            HealthRecord::factory()->count(3)->create([
                'pet_id' => $pet->id,
            ]);
        }
    }
}