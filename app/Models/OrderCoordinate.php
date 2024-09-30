<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderCoordinate extends Model
{
    use HasFactory;

    protected $fillable = ['lat','lng'];

    protected $table = 'order_address_coordinates';

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    protected function lat(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => floatval($value)
        );
    }

    protected function lng(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => floatval($value)
        );
    }
}
