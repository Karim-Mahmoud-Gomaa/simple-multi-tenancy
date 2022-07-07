<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tenant::factory(5)->create();
        \App\Models\User::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@demo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);     
        \App\Models\Admin::factory()->create([
            'name' => fake()->name(),
            'email' => 'admin@demo.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);     
        
        \App\Models\User::factory(2)->create();
        \App\Models\User::find(1)->tenants()->sync([1,2]);
        
        \App\Models\Product::factory()->count(2)->create([
            'name' => fake()->name(),
            'price' => fake()->numerify('##.00'),
            'user_id' => 1,'tenant_id' => 1,
        ]);
        \App\Models\Product::factory()->count(2)->create([
            'name' => fake()->name(),
            'price' => fake()->numerify('##.00'),
            'user_id' => 1,'tenant_id' => 2,
        ]);
    }
}
