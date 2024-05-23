<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\NumeroALetrasService;
use Illuminate\Http\Request;




class NumeroALetrasController extends Controller
{
    private $service;

    public function __construct(NumeroALetrasService $service)
    {
        $this->service = $service;
    }

    public function toMoney($num = '')
    {
        return $this->service->toMoney($num);
    }

    public function toMoneyArray()
    {
        
       return $this->service->toMoneyArray();
    }
}
