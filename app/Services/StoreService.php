<?php

namespace App\Services;

use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => StoreResource::collection(
                Store::included()
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
            'data' => StoreResource::make(Store::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => StoreResource::make(Store::create($request->all()))
        ], 200);
    }

    public function update(Request $request, Store $store)
    {
        $store->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => StoreResource::make($store),
        ], 200);
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => StoreResource::make($store),
        ], 200);
    }
}
