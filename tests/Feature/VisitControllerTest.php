<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pet;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VisitControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_visits_for_a_pet()
    {
        $pet = Pet::factory()->create();
        Visit::factory()->count(3)->create(['pet_id' => $pet->id]);

        $response = $this->getJson("/api/pets/{$pet->id}/visits");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => ['id', 'clinic', 'reason', 'date', 'created_at', 'updated_at']
                     ]
                 ]);
    }

    /** @test */
    public function it_can_add_a_new_visit()
    {
        $pet = Pet::factory()->create();

        $data = [
            'clinic' => 'Happy Paws Clinic',
            'reason' => 'Annual Checkup',
            'date' => '2025-07-07',
        ];

        $response = $this->postJson("/api/pets/{$pet->id}/visits", $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'data' => $data,
                 ]);

        $this->assertDatabaseHas('visits', array_merge($data, ['pet_id' => $pet->id]));
    }

    /** @test */
    public function it_can_update_a_visit()
    {
        $visit = Visit::factory()->create();

        $data = [
            'clinic' => 'Updated Clinic',
            'reason' => 'Updated Reason',
            'date' => '2025-07-08',
        ];

        $response = $this->putJson("/api/visits/{$visit->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => $data,
                 ]);

        $this->assertDatabaseHas('visits', array_merge($data, ['id' => $visit->id]));
    }

    /** @test */
    public function it_can_delete_a_visit()
    {
        $visit = Visit::factory()->create();

        $response = $this->deleteJson("/api/visits/{$visit->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Visit deleted successfully',
                 ]);

        $this->assertDatabaseMissing('visits', ['id' => $visit->id]);
    }
}