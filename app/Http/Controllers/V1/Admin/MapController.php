<?php

namespace App\Http\Controllers\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\OrderCoordinate;

class MapController extends Controller
{
    public function index()
    {
        $coordinates = OrderCoordinate::with(['order'])
            ->whereNotNull('lat')
            ->whereNotNull('lng')->get();

        return response()->json($coordinates);
    }
}
