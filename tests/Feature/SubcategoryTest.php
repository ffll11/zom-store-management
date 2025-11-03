<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubcategoryTest extends TestCase
{
    public function it_can_list_subcategories(){

        Subcategory::factory()->count(3)->create();

        $response = $this->getJson('/api/subcategories');
        $response->assertStatus(200)
            ->assertJsonCount(3,'data');
    }

    /** @test*/
    public function it_can_create_a_subcategory(){
        //Create a category first

        $category = Category::factory()->create();

        $data = [
            'name' => 'Subcategorytest4',
            'slug' => 'subcategorytest4',
            'description' => "subcategory-description",
            'category_id' => $category->id
        ];

        $response = $this->postJson('/api/subcategories', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('subcategories', $data);

    }

     public function it_can_show_a_subcategory(){
        $subcategory = Subcategory::factory()->create();

        $response = $this->getJson("/api/subcategories/{$subcategory->id}");
        $response->assertStatus(200)
            ->assertJsonFragment($subcategory->toArray());

    }

    public function it_can_update_a_subcategory(){
        $subcategory = Subcategory::factory()->create();

        $data = [
            'name' => 'UpdatedSubcategory2',
            'slug' => 'updatedsubcategory2',
            'description' => "updated-description",
            'category_id' => 6
        ];

        $response = $this->putJson("/api/subcategories/{$subcategory->id}", $data);
        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('subcategories', $data);

    }

    public function it_can_delete_a_subcategory(){
        $subcategory = Subcategory::factory()->create();

        $response = $this->deleteJson("/api/subcategories/{$subcategory->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('subcategories', ['id' => $subcategory->id]);

    }

}
