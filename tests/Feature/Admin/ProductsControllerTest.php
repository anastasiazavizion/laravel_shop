<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Services\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use Tests\Feature\Traits\SetupTrait;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use SetupTrait;
    /**
     * A basic feature test example.
     */
    public function test_success_create_product_with_valid_data(): void
    {
        $file = UploadedFile::fake()->image('image.jpg');
        $data = array_merge(Product::factory()->make()->toArray(), ['thumbnail'=>$file]);
        $slug = Str::slug($data['title']);
        $imagePath = '/uploaded/'.$slug.'.jpg';

        $this->mock(FileServiceContract::class, function (MockInterface $mock) use ($imagePath){
            $mock->shouldReceive('upload')->andReturn($imagePath);
        });


        $this->actingAs($this->user())->postJson(route('v1.admin.products.store'), $data);
        $this->assertDatabaseHas(Product::class, ['slug'=>$slug]);

        dd($imagePath);
    }
}
