<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatementRequest;
use App\Models\Statement;
use App\Services\StatementService;


class StatementController extends Controller
{
    private $service;

    public function __construct(StatementService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function store(StatementRequest $request)
    {
        return $this->service->store($request);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(StatementRequest $request, Statement $statement)
    {
        return $this->service->update($request, $statement);
    }

    public function destroy(Statement $statement)
    {
        return $this->service->destroy($statement);
    }
}
