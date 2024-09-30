<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\V1\Review\ReviewCollection;
use App\Http\Resources\V1\Review\ReviewResource;
use App\Models\Product;
use App\Repositories\Contract\ReviewRepositoryContract;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(public ReviewRepositoryContract $reviewRepository)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        return new ReviewCollection($this->reviewRepository->getAll($product));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request,Product $product)
    {
        $review = $this->reviewRepository->create($product,[...$request->validated(),'user_id'=>Auth::id()]);
         if($review){
            return response()->json(['message' => "Review was created", 'data'=>new ReviewResource($review)], 200);
        }
        return response()->json(['message' => 'Something was wrong', 'data'=>[]], 500);
    }

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['store']),
        ];
    }
}
