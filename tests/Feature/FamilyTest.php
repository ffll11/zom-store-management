<?php

namespace Tests\Feature;

use App\Models\Family;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FamilyTest extends TestCase
{
    /** @test*/
    public function it_can_list_families(){
        Family::factory()->count(3)->create();

        $response = $this->getJson('/api/families');
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function it_can_create_a_family(){
        $data = [
            'name' => 'Familytest',
            'slug' => 'familytest',
            'description' => "family-description",
            'subcategory_id' => 5
        ];

        $response = $this->postJson('/api/families', $data);
        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('families', $data);

    }

    public function it_can_show_a_family(){
        $family = Family::factory()->create();

        $response = $this->getJson('/api/families/' . $family->id);
        $response->assertStatus(200)
            ->assertJsonFragment($family->toArray());

    }

    public function it_can_update_a_family(){
        $family = Family::factory()->create();

        $data = [
            'name' => 'UpdatedFamily',
            'slug' => 'updatedfamily',
            'description' => "updated-description",
            'subcategory_id' => 6
        ];

        $response = $this->putJson('/api/families/' . $family->id, $data);
        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('families', $data);

    }

    public function it_can_delete_a_family(){
        $family = Family::factory()->create();

        $response = $this->deleteJson('/api/families/' . $family->id);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('families', ['id' => $family->id]);
    }

}
