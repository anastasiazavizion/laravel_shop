<?php
namespace App\Repositories\Contract;

use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryContract
{
    public function create(CreateRequest $request) : Category;
    public function update(UpdateRequest $request,Category $category) : Category;

    public function getAll() : Collection;
    public function getNestedCategories();

}
