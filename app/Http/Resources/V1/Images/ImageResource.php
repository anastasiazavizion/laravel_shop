<?php

namespace App\Http\Resources\V1\Images;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="Image",
     *     type="object",
     *     @OA\Property(
     *         property="url",
     *         type="string",
     *         example="http://example.com/images/product1.jpg"
     *     )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'url'=>$this->url,
        ];
    }
}
