<?php
namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Categories\CategoriesCollection;
use App\Repositories\Contract\CategoryRepositoryContract;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected CategoryRepositoryContract $repository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): CategoriesCollection
    {
        return new CategoriesCollection($this->repository->getAll());
    }
}
