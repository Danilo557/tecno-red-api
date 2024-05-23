<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Statement;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    private $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function store(ClientRequest $request)
    {
        return $this->service->store($request);
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function update(ClientRequest $request, Client $client)
    {
        return $this->service->update($request, $client);
    }

    public function destroy(Client $client)
    {
        return $this->service->destroy($client);
    }

    // public function estado_de_cuenta()
    // {
    //     $client = Client::where("status", Client::ACTIVE)
    //         ->with(["statements" => function ($query) {
    //             $query->withSum(["payments" => function ($query) {
    //             }], "amount");
    //         }])
    //         ->get();
    //     return $client;
    // }
}
