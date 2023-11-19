<?php

namespace App\Http\Controllers;

use App\Models\Market;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function index(): JsonResponse
    {
        $stores = Market::query()->get(['id', 'name', 'website']);
        return response()->json($stores);
    }
}
