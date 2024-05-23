<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $service;

    public function __construct(BrandService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function store(BrandRequest $request)
    {
        return $this->service->store($request);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        return $this->service->update($request, $brand);
    }

    public function destroy(Brand $brand)
    {
        return $this->service->destroy($brand);
    }
}
