<?php

namespace App\Services;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ClientResource::collection(Client::included()
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
            'data' => ClientResource::make(Client::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ClientResource::make(Client::create($request->all()))
        ], 200);
    }

    public function update(Request $request, Client $client)
    {
        $client->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ClientResource::make($client),
        ], 200);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => ClientResource::make($client),
        ], 200);
    }
}
