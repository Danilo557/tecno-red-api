<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChargeRequest;
use App\Models\Charge;
use App\Services\ChargeService;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    private $service;

    public function __construct(ChargeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function store(ChargeRequest $request)
    {
        return $this->service->store($request);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(ChargeRequest $request, Charge $charge)
    {
        return $this->service->update($request, $charge);
    }

    public function destroy(Charge $charge)
    {
        return $this->service->destroy($charge);
    }
}
