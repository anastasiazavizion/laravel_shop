<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Status\StatusResource;
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
            'vendor_order_id'=>$this->vendor_order_id,
            'name'=>$this->name,
            'lastname'=>$this->lastname,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'city'=>$this->city,
            'address'=>$this->address,
            'total'=>$this->total,
            'status'=>new StatusResource($this->status),
           // 'transaction'=>new StatusResource($this->status),


        ];
    }
}
