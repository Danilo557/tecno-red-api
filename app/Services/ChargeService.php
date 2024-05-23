<?php

namespace App\Services;

use App\Http\Resources\ChargeResource;
use App\Models\Charge;
use Illuminate\Http\Request;

class ChargeService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ChargeResource::collection(Charge::included()
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
            'data' => ChargeResource::make(Charge::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ChargeResource::make(Charge::create($request->all()))
        ], 200);
    }

    public function update(Request $request, Charge $charge)
    {
        $charge->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ChargeResource::make($charge),
        ], 200);
    }

    public function destroy(Charge $charge)
    {
        $charge->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ChargeResource::make($charge),
        ], 200);
    }
}
