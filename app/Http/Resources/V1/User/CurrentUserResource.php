<?php

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentUserResource extends JsonResource
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
            'lastname'=>$this->lastname,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'telegram_id'=>$this->telegram_id
        ];
    }
}
