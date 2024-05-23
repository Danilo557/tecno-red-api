<?php

namespace App\Services;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => BrandResource::collection(
                Brand::included()
                    ->filter()
                    ->sort()
                    ->getOrPaginate()
            ),
        ], 200);
    }


    public function show($id)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => BrandResource::make(Brand::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => BrandResource::make(Brand::create($request->all()))
        ], 200);
    }

    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => BrandResource::make($brand),
        ], 200);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => BrandResource::make($brand),
        ], 200);
    }
}
