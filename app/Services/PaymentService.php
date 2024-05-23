<?php

namespace App\Services;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentService
{
    public function all()
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => PaymentResource::collection(Payment::included()
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
            'data' => PaymentResource::make(Payment::included()->findOrFail($id)),
        ], 200);
    }


    public function store(Request $request)
    {
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => PaymentResource::make(Payment::create($request->all()))
        ], 200);
    }

    public function update(Request $request, Payment $payment)
    {
        $payment->update($request->all());
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => PaymentResource::make($payment),
        ], 200);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => PaymentResource::make($payment),
        ], 200);
    }
}
