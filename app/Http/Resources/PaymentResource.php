<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "paymentable_id"=>$this->paymentable_id,
            "paymentable_type"=>$this->paymentable_type,
            'amount'=>$this->amount,
            "date"=>$this->date,
            "status"=>$this->status,
            "description"=>$this->description
        ];
    }

}
