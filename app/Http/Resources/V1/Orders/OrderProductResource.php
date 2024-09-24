<?php

namespace App\Http\Resources\V1\Orders;

use App\Http\Resources\V1\Products\ProductsCollection;
use App\Http\Resources\V1\Transaction\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id'=>$this->id,
          'amount'=>(int)$this->pivot->quantity,
          'thumbnail_url'=>$this->thumbnail_url,
          'title'=>$this->pivot->name,
          'slug'=>$this->slug,
          'quantity'=>(int)$this->pivot->quantity,
          'single_price'=>(float)$this->pivot->single_price,
          'final_price'=>(float)$this->final_price,
        ];

    }
}
