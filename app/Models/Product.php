<?php

namespace App\Models;

use App\Observers\ProductObserver;
use App\Services\Contracts\FileServiceContract;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasFactory;

    protected $appends = ['thumbnail_url', 'final_price'];

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

    public function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->attributes['price'] - ($this->attributes['price'] * $this->attributes['discount'] / 100), 2)
        );
    }

}
