<?php

namespace Tests\Feature;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
 // use RefreshDatabase; //To serest ypur db before each test
   /** @test */
    public function it_can_list_brands()
    {
        Brand::factory()->count(3)->create();

        $response = $this->getJson('/api/brands');

        $response->assertStatus(200)
                 ->assertJsonCount(3); // checks there are 3 brands in the response
    }

    /** @test */

    public function it_can_create_a_brand(){
        $data = [
            'name' => 'BrandTest1',
            'slug' => 'brandtest1',
            'description' => "Italian brand",
            'country' => 'Italia'
        ];

      $response = $this->postJson('/api/brands', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('brands', $data);
    }

    /** @test */

        /** @test */
    public function it_can_show_a_brand()
    {
        // Create a single Brand record
        $brand = Brand::factory()->create();

        // Make a GET request to /api/brands/{id} to fetch the brand
        $response = $this->getJson("/api/brands/{$brand->id}");

        // Assert the response status is 200 (OK)
        $response->assertStatus(200)
                 // Assert the JSON response contains the brand's name
                 ->assertJsonFragment(['name' => $brand->name,           // Assert the JSON response contains the brand's name
                                    'slug' => $brand->slug,
                                    'description' => $brand->description,
                                    'country' => $brand->country
                ]);
    }

    /** @test */
    public function it_can_update_a_brand()
    {
        $brand = Brand::factory()->create();

        $data = ['name' => 'UpdatedBrand'];

        $response = $this->putJson("/api/brands/{$brand->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment($data);

        $this->assertDatabaseHas('brands', $data);
    }

    /** @test */
    public function it_can_delete_a_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->deleteJson("/api/brands/{$brand->id}");

        $response->assertStatus(204); // No content

        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }

}
