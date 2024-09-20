<?php
namespace App\Models;
use App\Enum\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name','color'];

    //casts

    public function orders()
    {
        return $this->hasMany(Order::class,'status_id');
    }

    public function scopePaid(Builder $query)
    {
        return $query->where('name',OrderStatusEnum::Paid->value);
    }

    public function scopeInProcess(Builder $query)
    {
        return $query->where('name',OrderStatusEnum::IN_PROCESS->value);
    }

    public function scopeComplete(Builder $query)
    {
        return $query->where('name',OrderStatusEnum::COMPLETED->value);
    }

    public function scopeCancelled(Builder $query)
    {
        return $query->where('name',OrderStatusEnum::CANCELLED->value);
    }

}
