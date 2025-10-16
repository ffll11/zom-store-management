<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Family>
 */
class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'name' => $this->faker->company(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'subcategory_id' => \App\Models\Subcategory::factory(),

        ];
    }
}
