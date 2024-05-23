<?php

namespace App\Services;

use App\Http\Resources\StatementResource;
use App\Models\Statement;
use Illuminate\Http\Request;

class StatementService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => StatementResource::collection(Statement::included()
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
            'data' => StatementResource::make(Statement::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => StatementResource::make(Statement::create($request->all()))
        ], 200);
    }

    public function update(Request $request, Statement $statement)
    {
        $statement->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => StatementResource::make($statement),
        ], 200);
    }

    public function destroy(Statement $statement)
    {
        $statement->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => StatementResource::make($statement),
        ], 200);
    }
}
