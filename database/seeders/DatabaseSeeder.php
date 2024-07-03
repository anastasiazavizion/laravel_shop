<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Category::factory(3)->create()->each(function ($parentCategory) {
            Category::factory(5)->create(['parent_id'=>$parentCategory->id])->each(function ($category){
                Product::factory(2)->create()->each(function ($product) use ($category){
                    $category->products()->save($product);
                });
            });
        });

    }

}
