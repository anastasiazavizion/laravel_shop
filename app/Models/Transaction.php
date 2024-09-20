<?php
namespace App\Models;
use App\Enum\PaymentSystemEnum;
use App\Enum\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'payment_system' => PaymentSystemEnum::class,
        'status' => TransactionStatus::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
