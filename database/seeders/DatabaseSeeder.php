<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\Category;
use App\Models\Movement;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => UserRoleEnum::ADMIN,
        ]);

        Category::factory(10)->create();
        Product::factory(50)->create();
        Supplier::factory(10)->create();
        Movement::factory(10)->create();
    }
}
