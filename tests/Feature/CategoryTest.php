<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test*/
    public function it_can_list_categories(){

        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

         $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test*/
    public function it_can_create_a_category(){

        $data = [
            'name' => 'Category test 3',
            'slug' => 'category-test3',
            'description' => "Category test",
        ];

        $response = $this->postJson('/api/categories' ,$data);

        $response->assertStatus(201)
        ->assertJsonFragment($data);

        $this->assertDatabaseHas('categories',$data);
    }

    public function it_can_show_a_category(){

       $category = Category::factory()->create();

        $response = $this->getJson('api/category/{$category->id}');

        $response->assertStatus(200)
                    ->assertJsonFragment([
                                    'name' => $category->name,           // Assert the JSON response contains the brand's name
                                    'slug' => $category->slug,
                                    'description' => $category->description,
                                ]);
    }

    public function it_can_update_a_category(){

        $category = Category::factory()->create();

        $data = ['name' => 'Category Update'];

        $response =$this->putJson("api/categories/{$category->id}");

        $response->assertStatus(200)
        ->assertJsonFragment($data);

        $this->assertDatabaseHas('category',$data);
    }

    public function it_can_delete_a_category(){

        $category = Category::factory()->create();

        $response = $this->deleteJson('/api/categories/{$category->id}');

        $response->assertStatus(204);

        $this->assertDatabaseMissing('categories',['id' => $category->id]);

    }
}
