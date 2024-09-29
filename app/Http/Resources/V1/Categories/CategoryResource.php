<?php

namespace App\Http\Resources\V1\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="Category",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Electronics"
     *     ),
     *     @OA\Property(
     *         property="slug",
     *         type="string",
     *         example="electronics"
     *     ),
     *     @OA\Property(
     *         property="parent",
     *         type="object",
     *         nullable=true
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'parent' => $this->parent ? new self($this->parent) : null,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
