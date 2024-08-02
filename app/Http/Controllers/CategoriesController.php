<?php
namespace App\Http\Controllers;
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
    public function index()
    {
        return response()->json($this->repository->getAll());
    }

}
