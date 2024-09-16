<?php

namespace App\Models;

use App\Enum\Role;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens, LaravelPermissionToVueJS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'birthday',
        'email',
        'password',
        'telegram_id',
        'provider_name',
        'provider_id',
        'provider_token',
        'avatar',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday'=> 'date'
        ];
    }

    public function cartItems() : HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishes() : BelongsToMany
    {
        return $this->belongsToMany(Product::class,'wish_list','user_id', 'product_id')
            ->withPivot(['price','exist']);
    }

    public function isWishedProduct(Product $product, string $type = 'price')
    {
        return $this->wishes()->where('product_id', $product->id)
            ->wherePivot('type', $type)
            ->exists();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isAdminOrModerator(): bool
    {
        return $this->hasAnyRole([Role::ADMIN->value, Role::MODERATOR->value]);
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value),
            set: fn (string $value) => strtolower($value),
        );
    }
}
