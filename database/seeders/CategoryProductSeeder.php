<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::query()->delete();


        Category::factory(2)->create()->each(function ($parentCategory) {
            Category::factory(5)->create(['parent_id'=>$parentCategory->id])->each(function ($category){
                Product::factory(2)->create()->each(function ($product) use ($category){
                    $category->products()->save($product);
                });
            });
        });

        //index products using algolia
        Artisan::call('products-index');
    }
}
