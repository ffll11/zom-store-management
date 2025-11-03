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

    }

     public function it_can_show_a_subfamily(){

    }

    public function it_can_update_a_subfamily(){

    }

    public function it_can_delete_a_subfamily(){

    }
}


