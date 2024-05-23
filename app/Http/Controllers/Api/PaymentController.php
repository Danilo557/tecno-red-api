<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function store(PaymentRequest $request)
    {
        return $this->service->store($request);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(PaymentRequest $request, Payment $payment)
    {
        return $this->service->update($request, $payment);
    }

    public function destroy(Payment $payment)
    {
        return $this->service->destroy($payment);
    }
}
