<?php

namespace App\Services;


use Illuminate\Http\Request;
use Luecano\NumeroALetras\NumeroALetras;

class NumeroALetrasService
{

    public function toMoney($num)
    {
        $formatter = new NumeroALetras();

        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => $formatter->toWords($num)
        ], 200);
    }


    public function toMoneyArray()
    {
        $formatter = new NumeroALetras();
        $result = [];

        $r = request("array");
        
        foreach ($r as $i) {
            array_push($result, ["id" => $i["id"], "letters" => $formatter->toWords($i["amount"])]);
        }


        return response()->json([
            'status' => 'ok',
            'code' => 200,
            'data' => $result
        ], 200);
    }
}
