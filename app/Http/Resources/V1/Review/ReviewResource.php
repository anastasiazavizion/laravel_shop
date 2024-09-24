<?php

namespace App\Http\Resources\V1\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rate'=>$this->rate,
            'description'=>$this->description,
            'user'=>[
                'id'=>$this->user->id,
                'name'=>$this->user->name,
            ],
            'date'=>$this->created_at->diffForHumans()
        ];
    }
}
