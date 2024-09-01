<?php

namespace App\Http\Resources\V2\Products;

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
                'title' => $this->title,
                'title10' => $this->title,
                'description' => $this->description,
                'price' => $this->price,
                'quantity' => $this->quantity,
                'in_stock' => $this->in_stock,
                'thumbnail_url' => $this->thumbnail_url,
                'final_price' => $this->final_price,
                'categories'=> new CategoriesCollection($this->categories),
                'images'=> new ImagesCollection($this->images),
            ];
    }
}
