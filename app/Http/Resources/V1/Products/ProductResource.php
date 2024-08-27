<?php

namespace App\Http\Resources\V1\Products;

use App\Http\Resources\V1\Categories\CategoriesCollection;
use App\Http\Resources\V1\Images\ImagesCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'id' => $this->id,
                'slug' => $this->slug,
                'title' => $this->title,
                'SKU' => $this->SKU,
                'description' => $this->description,
                'price' => $this->price,
                'discount' => $this->discount,
                'rate' => $this->rate,
                'quantity' => $this->quantity,
                'in_stock' => $this->in_stock,
                'thumbnail_url' => $this->thumbnail_url,
                'final_price' => $this->final_price,
                'is_in_wish_list_exist' => $this->is_in_wish_list_exist,
                'is_in_wish_list_price' => $this->is_in_wish_list_price,
                'categories'=> new CategoriesCollection($this->categories),
                'images'=> new ImagesCollection($this->images),
            ];
    }
}
