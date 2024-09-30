<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Http\Resources\V1\Categories\CategoriesCollection;
use App\Http\Resources\V1\Categories\CategoryResource;
use App\Models\Category;
use App\Repositories\Contract\CategoryRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller
{

    public function __construct(protected CategoryRepositoryContract $repository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): CategoriesCollection
    {
        Gate::authorize('viewAny', Category::class);
        return new CategoriesCollection($this->repository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): JsonResponse
    {
        Gate::authorize('create', Category::class);
        if($category = $this->repository->create($request)){
            return response()->json(['message' => "Category $category->name was created", 'data'=>new CategoryResource($category)], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category  $category): CategoryResource
    {
        Gate::authorize('view', $category);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category): JsonResponse
    {
        Gate::authorize('update', $category);
        if($category = $this->repository->update($request, $category)){
            return response()->json(['message' => "Category $category->name was updated", 'data'=>new CategoryResource($category)], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        Gate::authorize('delete', $category);
        try {
            DB::beginTransaction();
            $name = $category->name;
            $category->delete();
            DB::commit();
            return response()->json(['message' => "Category $name was removed", 'data'=>new CategoryResource($category)], 200);
        }catch (\Exception $exception){
            DB::rollBack();
            logs()->error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'data'=>[]], $exception->getCode());
        }
    }
}
