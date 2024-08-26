<?php

namespace App\Models;

use App\Enum\WishListType;
use App\Observers\ProductObserver;
use App\Observers\WishListObserver;
use App\Services\Contracts\FileServiceContract;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([ProductObserver::class, WishListObserver::class])]
class Product extends Model
{
    use HasFactory;

    protected $appends = ['thumbnail_url', 'final_price', 'is_in_wish_list_exist', 'is_in_wish_list_price', 'in_stock'];

    protected $fillable = [
        'slug',
        'title',
        'SKU',
        'description',
        'price',
        'discount',
        'quantity',
        'thumbnail',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images() :MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function followers() :BelongsToMany
    {
        return $this->belongsToMany(User::class,'wish_list','product_id', 'user_id');
    }

    protected function setThumbnailAttribute($image){
        $fileService = app(FileServiceContract::class);

        if(!empty($this->attributes['thumbnail'])){
            //remove previous thumbnail
            $fileService->remove($this->attributes['thumbnail']);
        }

        $path = $fileService->upload($image,$this->images_dir);

        $this->attributes['thumbnail'] = $path;
    }

    public function imagesDir(): Attribute
    {
        return Attribute::make(
            get: fn () => 'products/'.$this->attributes['slug'],
        );
    }

    public function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => str_contains($this->attributes['thumbnail'],'picsum.photos') ? $this->attributes['thumbnail'] : Storage::url($this->attributes['thumbnail'])
        );
    }
    public function inStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['quantity'] > 0
        );
    }

    public function isWishedProduct(string $type = WishListType::PRICE->value) : bool
    {
        if (Auth::check()) {
            return Auth::user()->wishes()
                ->where('product_id', $this->attributes['id'])
                ->wherePivot($type, true)
                ->exists();
        }
        return false;
    }

    public function isInWishListExist(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->isWishedProduct(WishListType::EXIST->value),
        );
    }

    public function isInWishListPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->isWishedProduct(WishListType::PRICE->value),
        );
    }

    public function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->attributes['price'] - ($this->attributes['price'] * $this->attributes['discount'] / 100), 2)
        );
    }


    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'final_price' => 'float',
        ];
    }

}
