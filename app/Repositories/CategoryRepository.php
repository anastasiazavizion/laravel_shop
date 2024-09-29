<?php

namespace App\Repositories;
use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Http\Resources\V1\Categories\CategoryResource;
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

    public function getNestedCategories()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return self::buildNestedCategories($categories);
    }

    private static function buildNestedCategories(\Illuminate\Support\Collection $categories)
    {
        $nestedCategories = [];
        foreach ($categories as $category) {
            $nestedCategory = new CategoryResource($category);
            $nestedCategory->children = self::buildNestedCategories($category->children);
            $nestedCategories[] = $nestedCategory;
        }
        return $nestedCategories;
    }
}
