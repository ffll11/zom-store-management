<?php

namespace Tests\Feature;

use App\Models\Subfamily;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubfamilyTest extends TestCase
{
    /** @test*/
    public function it_can_list_subfamily(){

        Subfamily::factory()->count(3)->create();

        $response = $this->getJson('/api/subfamily');
        $response->assertStatus(200)
        ->assertJsonCount(3);
    }
    /** @test*/
    public function it_can_create_a_subfamily(){

        $data = [
            'name' => 'Categorytest',
            'slug' => 'categorytest',
            'description' => "category-description",
            'family_id' => 5
        ];
        $response = $this->postJson('/api/subfamily', $data);
        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('subfamilies', $data);

    }

     public function it_can_show_a_subfamily(){
        $subfamily = Subfamily::factory()->create();

        $response = $this->getJson('/api/subfamily/' . $subfamily->id);
        $response->assertStatus(200)
            ->assertJsonFragment($subfamily->toArray());


    }

    public function it_can_update_a_subfamily(){
        $subfamily = Subfamily::factory()->create();

        $data = [
            'name' => 'UpdatedCategory',
            'slug' => 'updatedcategory',
            'description' => "updated-description",
            'family_id' => 6
        ];

        $response = $this->putJson('/api/subfamily/' . $subfamily->id, $data);
        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('subfamilies', $data);
    }

    public function it_can_delete_a_subfamily(){
        $subfamily = Subfamily::factory()->create();

        $response = $this->deleteJson('/api/subfamily/' . $subfamily->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('subfamilies', ['id' => $subfamily->id]);
    }
}


