<?php
namespace App\Repositories\Contract;

use Illuminate\Database\Eloquent\Model;

interface ImageRepositoryContract
{
    public function attach(Model $model, string $relation, array $images = [], ?string $directory = null) : void;
    public function detach(Model $model, string $relation) : void;

}
