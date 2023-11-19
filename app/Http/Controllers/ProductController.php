<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $storeIds = $request->get('market_ids', []);
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 30);

        $products = Product::query()
            ->when($search, fn($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($storeIds, fn($query) => $query->whereIn('market_id', $storeIds))
            ->orderBy('name')
            ->simplePaginate($perPage, page: $page);

        return response()->json($products);
    }
}
