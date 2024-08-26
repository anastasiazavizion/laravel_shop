<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->product->id,
            'amount'=>$this->amount,
            'thumbnail_url'=>$this->product->thumbnail_url,
            'title'=>$this->product->title,
            'quantity'=>$this->product->quantity,
            'final_price'=>$this->product->final_price,
        ];
    }
}
