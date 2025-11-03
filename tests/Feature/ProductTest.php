<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test*/
    public function it_can_list_products(){

        Product::factory()->count(3)->create();
        $response = $this->getJson('/api/products');
        $response->assertStatus(200)
        ->assertJsonCount(3);

    }
    /** @test*/
    public function it_can_create_a_product(){

        $data = [
            'name' => 'Producttest',
            'slug' => 'producttest',
            'description' => "product-description",
            'price' => 100,
            'subfamily_id' => 5
        ];

        $response = $this->postJson('/api/products', $data);
        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('products', $data);

    }

     public function it_can_show_a_product(){

        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);
        $response->assertStatus(200)
            ->assertJsonFragment($product->toArray());

    }

    public function it_can_update_a_product(){
        $product = Product::factory()->create();

        $data = [
            'name' => 'UpdatedProduct',
            'slug' => 'updatedproduct',
            'description' => "updated-description",
            'price' => 150,
            'subfamily_id' => 6
        ];

        $response = $this->putJson('/api/products/' . $product->id, $data);
        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('products', $data);
    }

    public function it_can_delete_a_product(){
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
