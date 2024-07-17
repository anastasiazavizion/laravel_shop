<?php
namespace App\Repositories\Contract;

use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface ImageRepositoryContract
{
    public function attach(Model $model, string $relation, array $images = [], ?string $directory = null) : void;
    public function detach(Model $model, string $relation) : void;

}
