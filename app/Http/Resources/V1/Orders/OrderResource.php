<?php

namespace App\Http\Resources\V1\Orders;

use App\Http\Resources\V1\Products\ProductsCollection;
use App\Http\Resources\V1\Transaction\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
          'status'=>$this->status->name,
          'name'=>$this->name,
          'lastname'=>$this->lastname,
          'phone'=>$this->phone,
          'email'=>$this->email,
          'city'=>$this->city,
          'address'=>$this->address,
          'total'=>$this->total,
          'products'=>new OrderProductCollection($this->products),
          'transaction'=>new TransactionResource($this->transaction),
          'created_at'=>$this->created_at->diffForHumans()
        ];
    }
}
