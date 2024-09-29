<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Image;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'parent_id',
    ];

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function image() :MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function children() : HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
