<?php

namespace App\Models;

use App\Enum\OrderStatusEnum;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
       return  $this->belongsTo(OrderStatus::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['name', 'single_price','quantity']);
    }

    public function transaction(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function scopeTotalByStatus(Builder $query, $status = OrderStatusEnum::Paid)
    {
        return $query->whereHas('status', function ($query) use ($status){
            $query->where('name', $status);
        })->sum('total');

    }


}
