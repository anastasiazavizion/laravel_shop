<?php

namespace App\Repositories;
use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Models\Category;
use App\Repositories\Contract\CategoryRepositoryContract;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryContract
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(CreateRequest $request) : Category
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        return Category::create($data);
    }

    public function update(UpdateRequest $request, Category $category) : Category
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return $category;
    }

    public function getAll() : Collection
    {
        return Category::query()->with(['parent'])->get();
    }
}
