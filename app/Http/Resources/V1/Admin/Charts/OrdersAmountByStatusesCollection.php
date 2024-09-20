<?php

namespace App\Http\Resources\V1\Admin\Charts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrdersAmountByStatusesCollection extends ResourceCollection
{
    public $collects = OrdersAmountByStatusesResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
