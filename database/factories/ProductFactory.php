<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->company(),
            'slug' => $this->faker->slug(),
            'image_url' => $this->faker->imageUrl(),
            'sku' => $this->faker->unique()->word(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'subfamily_id' => \App\Models\Subfamily::factory(),
            'brand_id' => \App\Models\Brand::factory(),

        ];
    }
}
