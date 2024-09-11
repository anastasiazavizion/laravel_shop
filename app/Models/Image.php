<?php

namespace App\Models;

use App\Observers\ImageObserver;
use App\Services\Contracts\FileServiceContract;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([ImageObserver::class])]
class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];
    protected $appends = ['url'];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function path(): Attribute
    {
        return Attribute::make(
            set: fn (array $value) => app(FileServiceContract::class)->upload($value['image'], $value['directory'] ?? null),
        );
    }

    protected function getUrlAttribute(): string
    {
        return app(FileServiceContract::class)->url($this->path,'products.images.'.$this->attributes['path']);
    }
}
