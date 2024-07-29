<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductListResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductIndexingController extends Controller
{
    public function index(){
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Product::query()
            ->where('title', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return ProductListResource::collection($query);
    }
    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
