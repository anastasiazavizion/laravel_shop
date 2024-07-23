<?php

namespace App\Models;

use App\Services\Contracts\FileServiceContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path'];
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
}
