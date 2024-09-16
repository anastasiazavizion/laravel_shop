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

    /**
     * @OA\Schema(
     *     schema="Product",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="slug",
     *         type="string",
     *         example="electronics"
     *     ),
     *     @OA\Property(
     *         property="title",
     *         type="string",
     *         example="Electronics"
     *     ),
     *     @OA\Property(
     *         property="SKU",
     *         type="string",
     *         example="ELEC123"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         example="A high-quality electronic product."
     *     ),
     *     @OA\Property(
     *         property="price",
     *         type="number",
     *         format="float",
     *         example=99.99
     *     ),
     *     @OA\Property(
     *         property="discount",
     *         type="number",
     *         format="float",
     *         example=10.0
     *     ),
     *     @OA\Property(
     *         property="rate",
     *         type="number",
     *         format="float",
     *         example=4.5
     *     ),
     *     @OA\Property(
     *         property="quantity",
     *         type="integer",
     *         example=100
     *     ),
     *     @OA\Property(
     *         property="in_stock",
     *         type="boolean",
     *         example=true
     *     ),
     *     @OA\Property(
     *         property="thumbnail_url",
     *         type="string",
     *         example="http://example.com/images/product.jpg"
     *     ),
     *     @OA\Property(
     *         property="final_price",
     *         type="number",
     *         format="float",
     *         example=89.99
     *     ),
     *     @OA\Property(
     *         property="is_in_wish_list_exist",
     *         type="boolean",
     *         example=false
     *     ),
     *     @OA\Property(
     *         property="is_in_wish_list_price",
     *         type="boolean",
     *         example=true
     *     ),
     *     @OA\Property(
     *         property="gallery",
     *         type="array",
     *         @OA\Items(type="string", example="http://example.com/images/gallery1.jpg")
     *     ),
     *     @OA\Property(
     *         property="categories",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Property(
     *         property="images",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Image")
     *     )
     * )
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
                'gallery' => $this->gallery,
                'categories'=> new CategoriesCollection($this->categories),
                'images'=> new ImagesCollection($this->images),
            ];
    }
}
