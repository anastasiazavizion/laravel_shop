<?php

namespace App\Http\Resources\V1\Admin\Charts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersAmountByStatusesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'name'=>$this->name,
          'color'=>$this->color,
          'total'=>$this->orders_count
        ];
    }
}
