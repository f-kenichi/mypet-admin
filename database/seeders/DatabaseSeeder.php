<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 既存のデータを削除
        \App\Models\User::truncate();

        // ユーザーを作成
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            PetSeeder::class,
            VisitSeeder::class,
            HealthRecordSeeder::class,
        ]);
    }
}
