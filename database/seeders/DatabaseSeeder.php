<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'role_id' => 1,
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin@123'),
        ]);

        $this->call([
            FamilySeeder::class,
            SubfamilySeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
