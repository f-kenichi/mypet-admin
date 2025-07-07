<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pet;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PetControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_pets()
    {
        Pet::factory()->count(3)->create();

        $response = $this->getJson('/api/pets');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         '*' => ['id', 'name', 'species', 'breed', 'birth_date', 'gender', 'weight', 'created_at', 'updated_at']
                     ]
                 ]);
    }

    /** @test */
    public function it_can_get_a_specific_pet()
    {
        $pet = Pet::factory()->create();

        $response = $this->getJson("/api/pets/{$pet->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => $pet->toArray(),
                 ]);
    }

    /** @test */
    public function it_returns_404_if_pet_not_found()
    {
        $response = $this->getJson('/api/pets/999');

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Pet not found',
                 ]);
    }

    /** @test */
    public function it_can_create_a_new_pet()
    {
        $data = [
            'name' => 'Buddy',
            'species' => 'Dog',
            'breed' => 'Golden Retriever',
            'birth_date' => '2020-01-01',
            'gender' => 'male',
            'weight' => 30.5,
        ];

        $response = $this->postJson('/api/pets', $data);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'data' => $data,
                 ]);

        $this->assertDatabaseHas('pets', $data);
    }

    /** @test */
    public function it_can_update_a_pet()
    {
        $pet = Pet::factory()->create();

        $data = [
            'name' => 'Updated Buddy',
            'weight' => 32.0,
        ];

        $response = $this->putJson("/api/pets/{$pet->id}", $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => array_merge($pet->fresh()->toArray(), $data),
                 ]);

        $this->assertDatabaseHas('pets', $data);
    }

    /** @test */
    public function it_can_delete_a_pet()
    {
        $pet = Pet::factory()->create();

        $response = $this->deleteJson("/api/pets/{$pet->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Pet deleted successfully',
                 ]);

        $this->assertDatabaseMissing('pets', ['id' => $pet->id]);
    }
}