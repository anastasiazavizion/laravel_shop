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
          'thumbnail_url'=>$this->thumbnail_url,
          'title'=>$this->pivot->name,
          'quantity'=>$this->pivot->quantity,
          'single_price'=>$this->pivot->single_price
        ];
    }
}
