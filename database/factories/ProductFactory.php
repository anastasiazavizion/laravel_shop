<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title =  fake()->unique()->sentence(2);
        $slug = Str::slug($title);

        $imageId = rand(1,1000);
        $imageUrl = "https://picsum.photos/id/{$imageId}/800/600";

        return [
            'slug'=>$slug,
            'title'=>$title,
            'SKU'=>fake()->unique()->ean13(),
            'description'=>fake()->text,
            'price'=>fake()->randomFloat(2,10, 200),
            'discount'=>fake()->boolean() ? rand(10,40) : null,
            'quantity'=>fake()->numberBetween(1,10),
            'thumbnail' => $imageUrl
        ];
    }
}
