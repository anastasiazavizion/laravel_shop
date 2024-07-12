<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\CreateRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoriesController extends Controller
{

    public function __construct(protected CategoryRepository $repository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->repository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $category = $this->repository->create($request);
        return response()->json(['message' => 'OK', 'data'=>$category], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category  $category)
    {
        $category->load(['parent']);
        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $category = $this->repository->update($request,$category);
        return response()->json(['message' => 'OK', 'data'=>$category], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->middleware('permission:delete category');
        $category->delete();
        return response()->json(['message' => 'OK'], 200);
    }
}
