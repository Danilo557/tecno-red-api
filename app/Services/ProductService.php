<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ProductResource::collection(Product::included()
                ->filter()
                ->sort()
                ->getOrPaginate()),
        ], 200);
    }


    public function show($id)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ProductResource::make(Product::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ProductResource::make(Product::create($request->all()))
        ], 200);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ProductResource::make($product),
        ], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ProductResource::make($product),
        ], 200);
    }
}
